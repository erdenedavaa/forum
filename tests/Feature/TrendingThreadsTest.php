<?php

namespace Tests\Feature;

use App\Trending;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->trending = new Trending();

        $this->trending->reset();
    }


    /** @test */
    function it_increments_a_threads_score_each_time_it_is_read()
    {
//        Redis::flushdb();

        $this->assertEmpty($this->trending->get());

        $thread = create('App\Thread');

        $this->call('GET', $thread->path());
        // simulate the user reading a thread

        $this->assertCount(1, $trending = $this->trending->get());

//        dd($trending);
        $this->assertEquals($thread->title, $trending[0]->title);
        // Trending get() deer already json_decoded hiisen tul
    }
}
