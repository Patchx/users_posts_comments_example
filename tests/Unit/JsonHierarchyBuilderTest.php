<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Classes\Builders\JsonHierarchyBuilder;

class JsonHierarchyBuilderTest extends TestCase
{
    /**
     * @return void
     */
    public function testNestRelationReturnsCorrectNesting()
    {
    	$parent_id = random_int(1, 100);
    	$parent_name = 'parent_' . random_int(1, 100);

    	$parent = (object) [
    		'id' => $parent_id,
    		'name' => $parent_name,
    	];

    	$child_id = random_int(1, 100);
    	$child_name = 'child_' . random_int(1, 100);

    	$child = (object) [
    		'id' => $child_id,
    		'name' => $child_name,
    		'parentId' => $parent_id,
    	];

    	$builder = new JsonHierarchyBuilder;

    	$nested_parents = $builder->nestRelation([
    		'parents' => [$parent],
    		'children' => [$child],
    		'nest_parent_on' => 'id',
    		'nest_child_on' => 'parentId',
    		'child_label' => 'children',
    	]);

    	$nested_parent = $nested_parents[0];
    	$nested_child = $nested_parent->children[0];

    	$this->assertTrue($nested_parent->id === $parent_id);
    	$this->assertTrue($nested_parent->name === $parent_name);
		$this->assertTrue($nested_child->id === $child_id);
		$this->assertTrue($nested_child->name === $child_name);
		$this->assertTrue(count($nested_parent->children) === 1);
    }
}
