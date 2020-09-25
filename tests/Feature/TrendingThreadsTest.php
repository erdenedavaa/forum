<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        Redis::del('trending_threads');
    }


    /** @test */
    function it_increments_a_threads_score_each_time_it_is_read()
    {
//        Redis::flushdb();

        $this->assertEmpty(Redis::zrevrange('trending_threads', 0, -1));

        $thread = create('App\Thread');

        $this->call('GET', $thread->path());
        // simulate the user reading a thread

        $trending = Redis::zrevrange('trending_threads', 0, -1);

        $this->assertCount(1, $trending);

//        dd($trending);
        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }
}