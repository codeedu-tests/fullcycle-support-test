<?php


namespace Tests\Unit\Models;


use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\TestCase;

#Classe especifica - vendor/bin/phpunit tests/Unit/CategoryTest.php
#Método  especifico em um arquivo - vendor/bin/phpunit --filter testIfUseTraits test/Unit/CategoryTest.php
#Método  especifico em uma classe - vendor/bin/phpunit --filter CategoryTest::testIfUseTraits

class CategoryTest extends TestCase
{


    public function  testDateAttribute(){

        $dates =['deleted_at','created_at','updated_at'];
        $category = new Category();
        foreach ($dates as $date) {
            $this->assertContains($date,$category->getDates());
        }

        $this->assertCount(count($dates),$category->getDates());
    }
    public function testFillableAttributes(){

        $fillable = ['name', 'description','is_active'];
        $category = new Category();
        $this->assertEquals(
            $fillable, $category->getFillable()
        );
    }

    public function testIfUseTraits(){
        //Category::create(['name'=>'test']);

        $traits = [
            SoftDeletes::class,Uuid::class
        ];
        $categoryTraits = array_keys(class_uses(Category::class));
        $this->assertEquals($traits,$categoryTraits);
    }

    public function  testCasts() {
        $cast =['id'=> 'string'];
        $category = new Category();
        $this->assertEquals($cast,$category->getCasts());
    }

    public function testIncrementing(){
        $category = new Category();
        $this->assertFalse($category->incrementing);
    }

}
