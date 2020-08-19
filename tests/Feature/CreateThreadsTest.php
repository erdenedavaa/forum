<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guest_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread');

        $this->post('threads', $thread->toArray());

    }

    /** @test */
    function guests_cannot_see_the_create_thread_page()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed in user
        $this->signIn();

        // When we hit the endpoint to create a new thread
        $thread = make('App\Thread');  // ehleed not persist tul make or raw gene.

        $this->post('threads', $thread->toArray());

        // Then we visit the thread page
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
   }
}
