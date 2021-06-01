<?php

namespace Tests\Feature\Models;


use App\Models\Genre;
use App\Models\Traits\ValidUuid;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;



class GenreTest extends TestCase
{

    use DatabaseMigrations, ValidUuid;


    public function testCreate(){

        $genre = Genre::create([
            'name'=> 'test1'
        ]);

        $genre->refresh();
        $this->assertEquals('test1',$genre->name);
        $this->assertTrue($this->isValidUuid($genre->id));
        $this->assertTrue((bool)$genre->is_active);

    }

    public function testUpdate(){
        /**@var Genre $genre */
        $genre= factory(Genre::class)->create([
            'name'=> 'teste_description','is_active'=>false
        ])->first();

        $data =[
            'name'=>'test_name_updated',
            'is_active'=>false
        ];
        $genre->update($data);
        foreach ($data as $key => $value){
            $this->assertEquals($value,$genre->{$key});
        }
    }
//
    public function testDelete(){

        $genre1 = Genre::create([
            'name'=> 'test1'
        ]);
        $genre1->refresh();

        $genre2 = Genre::create([
            'name'=> 'test2'
        ]);
        $genre2->refresh();
        $genres = Genre::all();
        $this->assertCount(2,$genres);

        $genre1->delete($genre1);
        $genre1->refresh();
        $genres = Genre::all();
        $this->assertCount(1,$genres);

    }


}

