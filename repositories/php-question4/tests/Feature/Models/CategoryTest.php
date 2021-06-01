<?php

namespace Tests\Feature\Models;



use App\Models\Category;
use App\Models\Traits\ValidUuid;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    use DatabaseMigrations, ValidUuid;

    public function testList()
    {
        factory(Category::class,1)->create();
        $categories = Category::all();
        $this->assertCount(1,$categories);
        $categoryKeys = array_keys($categories -> first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'id','name','description','created_at','updated_at','deleted_at','is_active'
        ],$categoryKeys);

    }

    public function testCreate(){
        $category = Category::create([
            'name'=> 'test1'
        ]);

        $category->refresh();
        $this->assertEquals('test1',$category->name);
        $this->assertNull($category->description);
        $this->assertTrue((bool)$category->is_active);
        $this->assertTrue($this->isValidUuid($category->id));

    }

    public function testUpdate(){
        $category= factory(Category::class)->create([
            'description'=> 'teste_description','is_active'=>false
        ])->first();

        $data =[
            'name'=>'test_name_updated',
            'description'=> 'test_description_update',
            'is_active'=>false
        ];
        $category->update($data);
        foreach ($data as $key => $value){
            $this->assertEquals($value,$category->{$key});
        }
    }

    public function testDelete(){

        $category1 = Category::create([
            'name'=> 'test1'
        ]);
        $category1->refresh();

        $category2 = Category::create([
            'name'=> 'test2'
        ]);
        $category2->refresh();
        $categories = Category::all();
        $this->assertCount(2,$categories);

        $category1->delete($category1);
        $category1->refresh();
        $categories = Category::all();
        $this->assertCount(1,$categories);

    }

    protected function setUuid1Values(array $uuids)
    {
        $stack = array_map(function ($uuid) {
            return \Ramsey\Uuid\Uuid::fromString($uuid);
        }, $uuids);

        $factory = $this->createMock(\Ramsey\Uuid\UuidFactoryInterface::class);
        $revs =0;
        $factory
            ->expects($this->exactly(count($revs)))
            ->method('uuid1')
            ->will(new \PHPUnit_Framework_MockObject_Stub_ConsecutiveCalls($stack));

        \Ramsey\Uuid\Uuid::setFactory($factory);
    }

    protected function clearUuid()
    {
        \Ramsey\Uuid\Uuid::setFactory(new \Ramsey\Uuid\UuidFactory());
    }


}
