<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function non_administrator_may_not_lock_threads()
    {
        $this->withExceptionHandling();  // энэ нь convert to proper response code

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        // locked ийн утгыг boolean болгоно
        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /** @test */
    function administrator_can_lock_threads()
    {
        // Дараах мөрөнд админий нэрийг шууд зааж өгч байгаа нь эрсдэлтэй,
        // Иймээс ModelFactory дээр "state" зааж өгөх байдлаар шийдэж болно
        // $this->signIn(create('App\User', ['name' => 'Ongoo']));

        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue(!! $thread->fresh()->locked, 'Failed asserting that the thread was locked.');
    }

    /** @test */
    function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
