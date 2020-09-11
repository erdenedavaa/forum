<?php

    namespace Tests\Unit;

    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Tests\TestCase;

    class ThreadTest extends TestCase
    {
        use DatabaseMigrations;

        protected $thread;

        public function setUp(): void
        {
            parent::setUp();

            $this->thread = create('App\Thread');
        }

        /** @test */
        function a_thread_can_make_a_string_path()
        {
            $thread = create('App\Thread');

            $this->assertEquals(
                "/threads/{$thread->channel->slug}/{$thread->id}", $thread->path()
            );
        }

        /** @test */
        function a_thread_has_replies()
        {
            $this->assertInstanceOf(
                'Illuminate\Database\Eloquent\Collection', $this->thread->replies
            );
        }

        /** @test */
        function a_thread_has_a_creator()
        {
            $this->assertInstanceOf('App\User', $this->thread->creator);
        }

        /** @test */
        function a_thread_can_add_a_reply()
        {
            $this->thread->addReply([
                'body'    => 'Foobar',
                'user_id' => 1
            ]);

            $this->assertCount(1, $this->thread->replies);
        }

        /** @test */
        function a_thread_belongs_to_a_channel()
        {
            $thread = create('App\Thread');

            $this->assertInstanceOf('App\Channel', $thread->channel);
        }

        /** @test */
        function a_thread_can_be_subscribed_to()
        {
            // Given we have a thread
            $thread = create('App\Thread');

            // And an authenticated user
//            $this->signIn();
            // When the user subscribes to the thread
//            $thread->subscribe();
            // ene uildliig tovchloh uudnees daraab baidlaar shinechillee

            $thread->subscribe($userId = 1);

            // Then we should be able to fetch all threads that the user has subscribed to.
            $this->assertEquals(
                1,
//                $thread->subscription()->where('user_id', auth()->id())->count()
                // deerh uurchlulttei holbootoigoor daraah baidlaar hiisen
                $thread->subscription()->where('user_id',$userId)->count()
                // ene uurchlultiig hiisneer bid never bother signIn user
            );
        }

        /** @test */
        function a_thread_can_be_unsubscribed_from()
        {
            // Given we have a thread
            $thread = create('App\Thread');

            // And a user who is subscribed to the thread.
            $thread->subscribe($userId = 1);

            $thread->unsubscribe($userId);

            $this->assertCount(0, $thread->subscription);
        }
    }
