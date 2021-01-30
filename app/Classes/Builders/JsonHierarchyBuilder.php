<?php

namespace App\Classes\Builders;

use Illuminate\Database\Eloquent\Model;

class JsonHierarchyBuilder
{
	public function nestRelation($inputs)
	{
		$this->validateInputs($inputs);

		$nest_parent_on = $inputs['nest_parent_on'];
		$nest_child_on = $inputs['nest_child_on'];
		$child_label = $inputs['child_label'];

		$parents = $inputs['parents'];
		$children = $inputs['children'];

		$parents_count = count($parents);
		$children_count = count($children);

		for ($i1 = 0; $i1 < $parents_count; $i1++) {
		    $parent = clone $parents[$i1];
		    $parent = $this->convertModelToSimpleObject($parent);

		    for ($i2 = 0; $i2 < $children_count; $i2++) {
		        $child = clone $children[$i2];
		        $child = $this->convertModelToSimpleObject($child);

		        if ($child->$nest_child_on === $parent->$nest_parent_on) {
		        	$parent->$child_label[] = $child;
		        }
		    }

		    $output[] = $parent;
		}

		return $output;
	}

	// -------------------
	// - Private Methods -
	// -------------------

	private function convertModelToSimpleObject($input)
	{
		if (!$input instanceof Model) {
			return $input;
		}

		return json_decode($input->toJson());
	}

	private function validateInputs($inputs)
	{
		if (!array_key_exists('parents', $inputs)
			|| !array_key_exists('children', $inputs)
			|| !array_key_exists('nest_parent_on', $inputs)
			|| !array_key_exists('nest_child_on', $inputs)
			|| !array_key_exists('child_label', $inputs)
		) {
			abort(500, "nestRelation requires the following parameters: 'parents', 'children', 'nest_parent_on', 'nest_child_on' and 'child_label'");
		}
	}
}