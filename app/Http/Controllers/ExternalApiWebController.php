<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\Builders\JsonHierarchyBuilder;

class ExternalApiWebController extends Controller
{
    public function getIndex(
    	JsonHierarchyBuilder $json_builder,
    	Request $request
    ) {
    	$users = json_decode(
    		file_get_contents('https://jsonplaceholder.typicode.com/users')
    	);
    	
    	$posts = json_decode(
    		file_get_contents('https://jsonplaceholder.typicode.com/posts')
    	);

    	$comments = json_decode(
    		file_get_contents('https://jsonplaceholder.typicode.com/comments?_limit=200')
    	);

    	foreach (['users', 'posts', 'comments'] as $data_element) {
    		if (!is_array($$data_element)) {
    			abort(500, "{$data_element} was not decoded to an array");
    		}
    	}

    	$nested_posts = $json_builder->nestRelation([
    		'parents' => $posts,
    		'children' => $comments,
    		'nest_parent_on' => 'id',
    		'nest_child_on' => 'postId',
    		'child_label' => 'comments',
    	]);

    	$nested_users = $json_builder->nestRelation([
    		'parents' => $users,
    		'children' => $nested_posts,
    		'nest_parent_on' => 'id',
    		'nest_child_on' => 'userId',
    		'child_label' => 'posts',
    	]);

    	return json_encode($nested_users);
    }
}
