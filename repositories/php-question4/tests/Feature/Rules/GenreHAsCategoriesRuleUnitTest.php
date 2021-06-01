<?php

namespace Tests\Feature\Rules;

use App\Rules\GenresHasCategoriesRule;
use Tests\TestCase;

class GenreHAsCategoriesRuleUnitTest extends TestCase
{

    public function testCategoriesIdField()
    {
        $rule = new GenresHasCategoriesRule([1,1,2,2]);
        $reflectionClass = new \ReflectionClass(GenresHasCategoriesRule::class);
        $reflectionProperty = $reflectionClass->getProperty('categoriesId');
        $reflectionProperty->setAccessible(true);

        $categoriesId = $reflectionProperty->getValue($rule);
        $this->assertEqualsCanonicalizing([1,2],$categoriesId);
    }

    public function testGenresIdValue()
    {
        $rule = new GenresHasCategoriesRule([]);
        $rule->passes('',[1,1,2,2]);

        $reflectionClass = new \ReflectionClass(GenresHasCategoriesRule::class);
        $reflectionProperty = $reflectionClass->getProperty('genresId');
        $reflectionProperty->setAccessible(true);

        $genresId = $reflectionProperty->getValue($rule);
        $this->assertEqualsCanonicalizing([1,2],$genresId);
    }

}
