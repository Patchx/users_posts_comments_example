<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\Builders\JsonHierarchyBuilder;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class RelationalDatabaseWebController extends Controller
{
	public function getIndex(
		JsonHierarchyBuilder $json_builder,
		Request $request
	) {
		$users = User::all();
		$posts = Post::all();
		$comments = Comment::all();
dd($comments);
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
