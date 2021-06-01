<?php

namespace Tests\Feature\Http\Controllers\Api;


use App\Http\Controllers\Api\VideoController;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Video;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Request;
use Tests\Exceptions\TestException;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;


class VideoControllerTest extends TestCase
{

    use DatabaseMigrations,TestValidations,TestSaves;

    private $video;
    private $sendData;

    protected function setUp():void
    {
        parent::setUp();
        $this->video = factory(Video::class)->create([
            'opened'=>0,
        ]);
        $this->sendData = [
            'title'=>'title',
            'description'=>'description',
            'year_launched'=>2010,
            'rating'=>Video::RATING_LIST[0],
            'duration'=>90,
        ];
    }


    public function testShow()
    {
        $response = $this->get(route('videos.show',['video'=> $this->video->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->video->toArray());

    }
    public function testIndex()
    {

        $response = $this->get(route('videos.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$this->video->toArray()]);

    }
//
    public function testInvalidationRequired()
    {
        $data=[
            'title'=>'',
            'description'=>'',
            'year_launched'=>'',
            'rating'=>'',
            'duration'=>''
        ];
        $this->assertInvalidationStoreAction($data,'required');
        $this->assertInvalidationUpdateAction($data,'required');
    }


    public function  testInvalidationMax()
    {
        $data = [
            'title'=>str_repeat('a',256)
        ];
        $this->assertInvalidationStoreAction($data,'max.string',['max'=>255]);
        $this->assertInvalidationUpdateAction($data,'max.string',['max'=>255]);
    }

    public function testInvalidationInteger(){
        $data = [
            'duration'=>'s'
        ];
        $this->assertInvalidationStoreAction($data,'integer');
        $this->assertInvalidationUpdateAction($data,'integer');
    }

    public function testInvalidationYearLaunchedField(){
        $data = [
            'year_launched'=>'a'
        ];
        $this->assertInvalidationStoreAction($data,'date_format',['format'=>'Y']);
        $this->assertInvalidationUpdateAction($data,'date_format',['format'=>'Y']);
    }

    public function testInvalidationOpenedField(){
        $data = [
            'opened'=>'s'
        ];
        $this->assertInvalidationStoreAction($data,'boolean');
        $this->assertInvalidationUpdateAction($data,'boolean');
    }

    public function testInvalidationRatingField(){
        $data = [
            'rating'=>0
        ];
        $this->assertInvalidationStoreAction($data,'in');
        $this->assertInvalidationUpdateAction($data,'in');
    }



    public function testSave()
    {
        $category = factory(Category::class)->create();
        $genre = factory(Genre::class)->create();
        $genre->categories()->sync($category->id);
        $data = [
            [
                'send_data' => $this->sendData +
                    ['opened' => false,
                        'categories_id' => [$category->id],
                        'genres_id' => [$genre->id]],
                'test_data' => $this->sendData + ['opened' => false],
            ],
            [
                'send_data' => $this->sendData + ['opened' => true, 'categories_id' => [$category->id], 'genres_id' => [$genre->id]],
                'test_data' => $this->sendData + ['opened' => true],
            ],
            [
                'send_data' => $this->sendData + ['rating' => Video::RATING_LIST[1], 'categories_id' => [$category->id], 'genres_id' => [$genre->id]],
                'test_data' => $this->sendData + ['rating' => Video::RATING_LIST[1]],
            ],
        ];

        foreach ($data as $value) {
            $response = $this->assertStore(
                $value['send_data'],
                $value['test_data'] + ['deleted_at' => null]
            );

            $response = $this->assertUpdate(
                $value['send_data'],
                $value['test_data'] + ['deleted_at' => null]
            );

        }
    }

    public function testRollbackStore()
    {
        $controller = \Mockery::mock(VideoController::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $controller
            ->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn($this->sendData);

        $controller
            ->shouldReceive('rulesStore')
            ->withAnyArgs()
            ->andReturn([]);

        $controller
            ->shouldReceive('handleRelations')
            ->once()
            ->andThrow(new TestException());

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('get')
            ->withAnyArgs()
            ->andReturnNull();

        try {
            $controller->store($request);
        } catch (TestException $exception) {
            $this->assertCount(1, Video::all());
        }
    }

    public function testRollbackUpdate()
    {
        $controller = \Mockery::mock(VideoController::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $controller
            ->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn($this->sendData);

        $controller
            ->shouldReceive('rulesUpdate')
            ->withAnyArgs()
            ->andReturn([]);

        $controller
            ->shouldReceive('handleRelations')
            ->once()
            ->andThrow(new TestException());

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('get')
            ->withAnyArgs()
            ->andReturnNull();

        try {
            $controller->update($request, $this->video->id);
        } catch (TestException $exception) {
            $this->assertCount(1, Video::all());
        }
    }

    public function testDestroy()
    {
        $response = $this->json('DELETE',route('videos.destroy',['video'=>$this->video->id]));
        $response->assertStatus(204);
        $this->assertNull(Video::find($this->video->id));
        $this->assertNotNull(Video::withTrashed()->find($this->video->id));
    }

    public function testInvalidationCategoriesIdField() {

        $data = [
            'categories_id' =>'a'
        ];
        $this->assertInvalidationStoreAction($data,'array');
        $this->assertInvalidationUpdateAction($data,'array');

        $data = [
            'categories_id' =>[100]
        ];
        $this->assertInvalidationStoreAction($data,'exists');
        $this->assertInvalidationUpdateAction($data,'exists');
    }

    public function testInvalidationGenresIdField() {

        $data = [
            'genres_id' =>'a',
        ];
        $this->assertInvalidationStoreAction($data,'array');
        $this->assertInvalidationUpdateAction($data,'array');

        $data = [
            'genres_id' =>[100],
        ];
        $this->assertInvalidationStoreAction($data,'exists');
        $this->assertInvalidationUpdateAction($data,'exists');
    }


    protected function model()
    {
        return Video::class;
    }

    protected function routeStore()
    {
        return route('videos.store');
    }

    protected function routeUpdate()
    {
        return route('videos.update',['video'=>$this->video->id]);
    }
}
