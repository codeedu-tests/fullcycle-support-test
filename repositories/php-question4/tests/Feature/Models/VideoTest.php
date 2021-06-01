<?php

namespace Tests\Feature\Models;


use App\Models\Video;
use App\Models\Traits\ValidUuid;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;



class VideoTest extends TestCase
{

    use DatabaseMigrations, ValidUuid;

    private $video;

    protected function setUp(): void
    {
        parent::setUp();
        $this->video = new Video();
    }


    public function testCreate(){

        $video = Video::create([
            'title'=> 'test1', 'description'=>'testDescription' ,'year_launched'=>1999,'rating'=>'a','duration'=>120
        ]);

        $video->refresh();
        $this->assertEquals('test1',$video->title);
        $this->assertTrue($this->isValidUuid($video->id));

    }
    public function testFillable()
    {
        $fillable = [
            'title',
            'description',
            'year_launched',
            'opened',
            'rating',
            'duration'

        ];
        $this->assertEquals($fillable, $this->video->getFillable());
    }

    public function testCasts()
    {
        $Casts = [
            'id' => 'string',
            'opened' => 'boolean',
            'year_launched' => 'integer',
            'duration' => 'integer'
        ];

        $this->assertEquals(
            $Casts,
            $this->video->getCasts()
        );
    }



}

