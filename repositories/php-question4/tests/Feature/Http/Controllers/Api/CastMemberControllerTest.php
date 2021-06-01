<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\CastMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\Traits\TestSaves;
use Tests\Traits\TestValidations;


class CastMemberControllerTest extends TestCase
{
    use DatabaseMigrations,TestSaves, TestValidations;

    private $castMember;

    protected function setUp():void{
        parent::setUp();
        $this->castMember = factory(CastMember::class)->create([
            'type'=>CastMember::TYPE_DIRECTOR
        ]);
    }

    public function testIndex()
    {
        $response = $this->get(route('cast_members.index'));
        $response
            ->assertStatus(200)
            ->assertJson([$this->castMember->toArray()]);
    }

    public function testShow()
    {
        $response = $this->get(route('cast_members.show',['cast_member'=> $this->castMember->id]));
        $response
            ->assertStatus(200)
            ->assertJson($this->castMember->toArray());

    }

    public  function  testInvalidationData()
    {
        $data=[
            'name'=> '',
            'type'=>''
        ];

        $this->assertInvalidationStoreAction($data,'required');
        $this->assertInvalidationUpdateAction($data,'required');

        $data=[
            'type'=>'s'
        ];
        $this->assertInvalidationStoreAction($data,'in');
        $this->assertInvalidationUpdateAction($data,'in');

    }

    public function testStore()
    {
        $data =[

            [
                'name' =>'test',
                'type'=>CastMember::TYPE_DIRECTOR
            ],
            [
                'name' =>'test',
                'type'=>CastMember::TYPE_ACTOR
            ]
        ];
        foreach ($data as $key => $value){
            $response = $this->assertStore($value,$value+['deleted_at'=>null]);
        }

    }

    public function testUpdate()
    {
        $data=[
            'name'=> 'test',
            'type'=>CastMember::TYPE_ACTOR
        ];
        $response = $this->assertUpdate($data,$data+['deleted_at'=>null]);


    }

    public function testDestroy()
    {

        $response = $this->json('DELETE',route('cast_members.destroy',['cast_member'=>$this->castMember->id]));
        $response->assertStatus(204);
        $this->assertNull(CastMember::find($this->castMember->id));
        $this->assertNotNull(CastMember::withTrashed()->find($this->castMember->id));
    }

    protected function model()
    {
        return CastMember::class;
    }

    protected function routeStore()
    {
        return route('cast_members.store');
    }

    protected function routeUpdate()
    {
        return route('cast_members.update',['cast_member'=>$this->castMember->id]);
    }


}
