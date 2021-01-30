<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

// Note: For this Proof of Concept we are relying on the database to be empty at the start of this command. If the database is not empty, then columns which refer to the primary id of other tables will not be accurate. In a real-world application, this would be addressed by establishing relationships between tables via a different column, other than simply the primary id columns
// --
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->populateUsers();
        $this->populatePosts();
        $this->populateComments();
    }

    // -------------------
    // - Private Methods -
    // -------------------

    private function populateComments()
    {
    	$comments = json_decode(
    		file_get_contents('https://jsonplaceholder.typicode.com/comments?_limit=200')
    	);

    	foreach ($comments as $comment) {
    		Comment::create([
    			'postId' => $comment->postId,
    			'name' => $comment->name,
    			'email' => $comment->email,
    			'body' => $comment->body,
    		]);
    	}
    }

    private function populatePosts()
    {
    	$posts = json_decode(
    		file_get_contents('https://jsonplaceholder.typicode.com/posts')
    	);

    	foreach ($posts as $post) {
    		Post::create([
    			'userId' => $post->userId,
    			'title' => $post->title,
    			'body' => $post->body,
    		]);
    	}
    }

    private function populateUsers()
    {
    	$users = json_decode(
    		file_get_contents('https://jsonplaceholder.typicode.com/users')
    	);

    	foreach ($users as $user) {
    		User::create([
    			'name' => $user->name,
    			'username' => $user->username,
    			'email' => $user->email,
    			'address' => json_encode($user->address),
    			'phone' => $user->phone,
    			'website' => $user->website,
    			'company' => json_encode($user->company),
    			'password' => uniqid(), // Only adding this in because we must specify the password for the seeder
    		]);
    	}
    }
}
