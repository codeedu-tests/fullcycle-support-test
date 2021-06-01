<?php

namespace Tests\Feature\Models;

use App\Models\CastMember;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CastMemberTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(CastMember::class, 1)->create();
        $castMember = CastMember::all();
        $this->assertCount(1, $castMember);
        $castMemberKey = array_keys($castMember->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            ['id', 'name', 'type', 'deleted_at', 'created_at', 'updated_at'],
            $castMemberKey
        );
    }

    public function testCreate()
    {
        $castMember = CastMember::create(['name' => 'test1', 'type'=>CastMember::TYPE_DIRECTOR]);
        $castMember->refresh();

        $this->assertEquals(36, strlen($castMember->id));
        $this->assertTrue(Uuid::isValid($castMember->id));
        $this->assertEquals('test1', $castMember->name);
        $this->assertEquals(CastMember::TYPE_DIRECTOR, $castMember->type);
    }


    public function testUpdate()
    {
        /** @var CastMember $castMember */
        $castMember = factory(CastMember::class)->create([
            'type'=>CastMember::TYPE_DIRECTOR
        ]);
        $data = [
            'name' => 'test_name_updated',
            'type'=>CastMember::TYPE_ACTOR
        ];
        $castMember->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $castMember->{$key});
        }

    }

    public function testDelete() {

        /** @var CastMember $castMember */
        $castMember = factory(CastMember::class)->create();

        $castMember->delete();

        $this->assertNull(CastMember::find($castMember->id));
        $this->assertNotNull(CastMember::withTrashed($castMember->id));

        $castMember->restore();
        $this->assertNotNull(CastMember::find($castMember->id));
    }
}
