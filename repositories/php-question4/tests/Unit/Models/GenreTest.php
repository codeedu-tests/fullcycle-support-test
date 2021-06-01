<?php


namespace Tests\Unit\Models;



use App\Models\Genre;
use Tests\TestCase;

#Classe especifica - vendor/bin/phpunit tests/Unit/CategoryTest.php
#Método  especifico em um arquivo - vendor/bin/phpunit --filter testIfUseTraits test/Unit/CategoryTest.php
#Método  especifico em uma classe - vendor/bin/phpunit --filter CategoryTest::testIfUseTraits

class GenreTest extends TestCase
{


    public function  testDateAttribute(){

        $dates =['deleted_at','created_at','updated_at'];
        $genre = new Genre();
        foreach ($dates as $date) {
            $this->assertContains($date,$genre->getDates());
        }

        $this->assertCount(count($dates),$genre->getDates());
    }

    public function testFillableAttributes(){

        $fillable = ['name', 'is_active'];
        $genre = new Genre();
        $this->assertEquals(
            $fillable, $genre->getFillable()
        );
    }


}
