<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            ['id', 'name', 'description', 'is_active', 'deleted_at', 'created_at', 'updated_at'],
            $categoryKey
        );
    }

    public function testCreate()
    {
        /** @var Category $category */
        $category = Category::create(['name' => 'test1']);
        $category->refresh();

        $this->assertEquals(36, strlen($category->id));
        $this->assertTrue(Uuid::isValid($category->id));
        $this->assertEquals('test1', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue((bool)$category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'description' => null
        ]);
        $this->assertNull($category->description);

        $category = Category::create([
            'name' => 'test1',
            'description' => 'test_description'
        ]);
        $this->assertEquals('test_description', $category->description);


        $category = Category::create([
            'name' => 'test1',
            'is_active' => false
        ]);
        $this->assertFalse((bool)$category->is_active);

        $category = Category::create([
            'name' => 'test1',
            'is_active' => true
        ]);
        $this->assertTrue((bool)$category->is_active);

    }


    public function testUpdate()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create([
            'description' => 'test_description',
            'is_active' => false
        ]);
        $data = [
            'name' => 'test_name_updated',
            'description' => 'test_description_updated',
            'is_active' => true
        ];
        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }

    }

    public function testDelete() {

        /** @var Category $category */
        $category = factory(Category::class)->create();

        $category->delete();

        $this->assertNull(Category::find($category->id));
        $this->assertNotNull(Category::withTrashed($category->id));

        $category->restore();
        $this->assertNotNull(Category::find($category->id));
    }
}
