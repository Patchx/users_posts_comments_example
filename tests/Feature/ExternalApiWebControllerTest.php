<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExternalApiWebControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testFirstCommentRetrievedHasCorrectEmail()
    {
        $response = $this->get('/external-api');

        $data = json_decode($response->getContent());
        $first_comment = $data[0]->posts[0]->comments[0];

        $this->assertTrue($first_comment->email === 'Eliseo@gardner.biz');
    }

    /**
     * @return void
     */
    public function testUsersCountEqualsTen()
    {
        $response = $this->get('/external-api');

        $data = json_decode($response->getContent());
        $user_count = count($data);

        $this->assertTrue($user_count === 10);
    }
}
