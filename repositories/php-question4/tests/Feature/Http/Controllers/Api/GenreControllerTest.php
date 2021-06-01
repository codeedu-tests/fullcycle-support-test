<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Http\Controllers\Api\GenreController;
use App\Models\Category;
use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Request;
use Tests\Exceptions\TestException;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;


class GenreControllerTest extends TestCase
{


    use DatabaseMigrations, TestValidations, TestSaves;

    private $genre;


    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = factory(Genre::class)->create();
    }

    public function testIndex()
    {

        $response = $this->get(route('genres.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$this->genre->toArray()]);

    }

    public function testShow()
    {
        $this->genre = factory(Genre::class)->create();
        $response = $this->get(route('genres.show',['genre'=> $this->genre->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->genre->toArray());

    }

    public  function  testInvalidationData()
    {

        $response = $this->json('POST',route('genres.store'),[]);
        $this->assertInvalidarionRequired($response);

        $category = factory(Category::class)->create();
        $response = $this->json('POST',route('genres.store'),[
            'name'=>str_repeat('a',256),
            'is_active'=>'a',
            'categories_id'=>[$category->id]
        ]);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name','is_active'])
            ->assertJsonFragment(
                [\Lang::get('validation.max.string',['attribute'=>'name','max'=>255])]
            )
            ->assertJsonFragment([
                \Lang::get('validation.boolean',['attribute'=> 'is active']),
            ]);


        $this->genre = factory(Genre::class)->create();
        $response =
            $this->json('PUT',route('genres.update',['genre'=>$this->genre->id]),[
                'name'=>str_repeat('a',256),
                'is_active'=> 'a',
                'categories_id'=>[$category->id]
            ]);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name','is_active'])
            ->assertJsonFragment(
                [\Lang::get('validation.max.string',['attribute'=>'name','max'=>255])]
            )
            ->assertJsonFragment([
                \Lang::get('validation.boolean',['attribute'=> 'is active']),
            ]);

        $data =['categories_id'=>'a'];
        $this->assertInvalidationStoreAction($data,'array');
        $this->assertInvalidationUpdateAction($data,'array');

    }

    public function testStore()
    {

        $categoryId = factory(Category::class)->create()->id;
        $data =[
            'name' =>'test'
        ];
        $this->assertStore(
                $data+['categories_id'=>[$categoryId]],
                $data+['is_active'=>true, 'deleted_at'=>null]);

        $data =[
            'name'=> 'test',
            'is_active'=>false

        ];
        $this->assertStore($data+['categories_id'=>[$categoryId]],$data+['is_active'=>false]);

    }


    public function testDestroy()
    {
        $this->genre = factory(Genre::class)->create();
        $response = $this->json('DELETE',route('genres.destroy',['genre'=>$this->genre->id]));
        $response->assertStatus(204);
        $this->assertNull(Genre::find($this->genre->id));
        $this->assertNotNull(Genre::withTrashed()->find($this->genre->id));
    }

    private function assertInvalidarionRequired(TestResponse  $response){
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name'])
            ->assertJsonMissingValidationErrors(['is_active'])
            ->assertJsonFragment(
                [\Lang::get('validation.required',['attribute'=>'name'])]
            );
    }

    public function testSyncCategories()
    {
        $categoriesId = Factory(Category::class, 3)->create()->pluck('id')->toArray();
        $sendData = [
            'name' => 'test',
            'categories_id' => [$categoriesId[0]]
        ];
        //Inclui com a category index 0
        $response = $this->json('POST', $this->routeStore(), $sendData);
        $this->assertDatabaseHas('category_genre', [
            'category_id' => $categoriesId[0],
            'genre_id' => $response->json('id')
        ]);


        $sendData = [
            'name' => 'test',
            'categories_id' => [$categoriesId[1], $categoriesId[2]]
        ];

        $response = $this->json(
            'PUT',
            route('genres.update', ['genre' => $response->json('id')]),
            $sendData
        );

        $this->assertDatabaseMissing('category_genre', [
            'category_id' => $categoriesId[0],
            'genre_id' => $response->json('id')
        ]);

        $this->assertDatabaseHas('category_genre', [
            'category_id' => $categoriesId[1],
            'genre_id' => $response->json('id')
        ]);

        $this->assertDatabaseHas('category_genre', [
            'category_id' => $categoriesId[2],
            'genre_id' => $response->json('id')
        ]);
    }

    public function testRollbackStore()
    {
        $controller = \Mockery::mock(GenreController::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $controller
            ->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn([
                'name' => 'test',
            ]);

        $controller
            ->shouldReceive('rulesStore')
            ->withAnyArgs()
            ->andReturn([]);

        $controller
            ->shouldReceive('handleRelations')
            ->once()
            ->andThrow(new TestException());

        $request = \Mockery::mock(Request::class);
        $hasErro = false;
        try {
            $controller->store($request);
        } catch (TestException $exception) {
            $this->assertCount(1, Genre::all());
            $hasErro = true;
        }
        $this->assertTrue($hasErro);
    }

    public function testRollbackUpdate()
    {
        $controller = \Mockery::mock(GenreController::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $controller
            ->shouldReceive('findOrFail')
            ->withAnyArgs()
            ->andReturn($this->genre);


        $controller
            ->shouldReceive('validate')
            ->withAnyArgs()
            ->andReturn([
                'name' => 'test',
            ]);

        $controller
            ->shouldReceive('rulesStore')
            ->withAnyArgs()
            ->andReturn([]);

        $controller
            ->shouldReceive('handleRelations')
            ->once()
            ->andThrow(new TestException());

        $request = \Mockery::mock(Request::class);
        $hasErro = false;
        try {
            $controller->update($request, 1);
        } catch (TestException $exception) {
            $this->assertCount(1, Genre::all());
            $hasErro = true;
        }
        $this->assertTrue($hasErro);
    }


    protected function model()
    {
        return Genre::class;
    }

    protected function routeStore()
    {
        return route('genres.store');
    }

    protected function routeUpdate()
    {
        return route('genres.update',['genre'=>$this->genre->id]);
    }

}
