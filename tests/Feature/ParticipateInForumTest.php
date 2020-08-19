<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

//        $thread = factory('App\Thread')->create();
//
//        $reply = factory('App\Reply')->create();
//        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->post('/threads/1/replies', []);
    }

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
//        $user = factory('App\User')->create();
        $this->be($user = create('App\User'));

        // Controller deer middleware auth hiisen tul daraah baidlaar
        // shuud auth user yysgej bolno.

        // And an existing thread
        $thread = create('App\Thread');

        // When the user adds a reply to the thread
        $reply = create('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
