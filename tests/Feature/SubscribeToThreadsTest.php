<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_subscribe_to_threads()
    {
        $this->signIn();

        // Given we have a thread ...
        $thread = create('App\Thread');

        // And the user subscribe to the thread...
        $this->post($thread->path() . '/subscriptions');

        // Then, each time a new reply is left.
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        // A notification should be prepared for the user.
        $this->assertCount(1, auth()->user()->notifications);

//        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        // Given we have a thread ...
        $thread = create('App\Thread');

        $thread->subscribe();

        // And the user subscribe to the thread...
        $this->delete($thread->path() . '/subscriptions');

//        dd($thread->subscription);
        $this->assertCount(0, $thread->subscription);
    }
}
