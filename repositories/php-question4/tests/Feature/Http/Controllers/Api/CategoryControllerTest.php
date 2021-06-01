<?php

namespace Tests\Feature\Http\Controllers\Api;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;
use Tests\TestCase;


class CategoryControllerTest extends TestCase
{


    use DatabaseMigrations,TestValidations,TestSaves;

    private $category;
    protected function setUp():void
    {
        parent::setUp();
        $this->category = factory(Category::class)->create();
    }


    public function testIndex()
    {

        $response = $this->get(route('categories.index'));

        $response
            ->assertStatus(200)
            ->assertJson([$this->category->toArray()]);

    }

    public function testShow()
    {

        $response = $this->get(route('categories.show',['category'=> $this->category->id]));

        $response
            ->assertStatus(200)
            ->assertJson($this->category->toArray());

    }

    public  function  testInvalidationData()
    {
        $data =[
            'name'=>''
        ];
        $this->assertInvalidationStoreAction($data,'required');
        $this->assertInvalidationUpdateAction($data,'required');

        $data =[
            'name'=>str_repeat('a',256)
        ];
        $this->assertInvalidationStoreAction($data,'max.string',['max'=>255]);
        $this->assertInvalidationUpdateAction($data,'max.string',['max'=>255]);
        $data =[
            'is_active'=>'a'
        ];
        $this->assertInvalidationStoreAction($data,'boolean');
        $this->assertInvalidationUpdateAction($data,'boolean');

        $response = $this->json('POST',route('categories.store'),[]);
        $this->assertInvalidarionRequired($response);


        $category = factory(Category::class)->create();
        $response =
            $this->json('PUT',route('categories.update',['category'=>$category->id]),[
                'name'=>str_repeat('a',256),
                'is_active'=> 'a'
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
    }

    public function testStore()
    {
        $data =[
            'name' =>'test'
        ];
        $this->assertStore($data,$data+['description'=>null,'is_active'=>1, 'deleted_at'=>null]);

        $data =[
            'name'=> 'test',
            'description'=>'teste',
            'is_active'=>0
        ];
        $this->assertStore($data,$data+['description'=>'teste','is_active'=>0]);


    }

    public function testUpdate()
    {
        $this->category = factory(Category::class)->create([
            'description'=>'teste',
            'is_active'=>false
        ]);
        $data=[
            'name'=> 'test',
            'description'=>'terror',
            'is_active'=>true
        ];
        $this->assertUpdate($data,$data+['deleted_at'=>null]);

        $data=[
            'name'=> 'test',
            'description'=>''
        ];
        $this->assertUpdate($data,array_merge($data,['description'=>null]));

        $data['description']='test';
        $this->assertUpdate($data,array_merge($data,['description'=>'test']));
        $data['description']=null;
        $this->assertUpdate($data,array_merge($data,['description'=>null]));

    }

    public function testDestroy()
    {

        $response = $this->json('DELETE',route('categories.destroy',['category'=>$this->category->id]));
        $response->assertStatus(204);
        $this->assertNull(Category::find($this->category->id));
        $this->assertNotNull(Category::withTrashed()->find($this->category->id));
    }

    private function assertInvalidarionRequired(TestResponse  $response){

        $this->assertInvalidationFields(
            $response,['name'],'required',[]
        );

        $response
            ->assertJsonMissingValidationErrors(['is_active']);

    }

    protected function routeStore()
    {
        return route('categories.store');
    }

    protected function routeUpdate()
    {
        return route('categories.update',['category'=> $this->category->id]);
    }

    protected function model(){
        return Category::class;
    }

}
