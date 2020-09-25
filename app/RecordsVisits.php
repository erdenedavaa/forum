<?php

    namespace App;

    use Illuminate\Support\Facades\Redis;

    trait RecordsVisits
    {

        public function recordVisit()
        {
            Redis::incr($this->visitsCacheKey());

            return $this;
        }

        public function resetVIsits()
        {
            Redis::del($this->visitsCacheKey());

            return $this;
            // chaining hiihiin tuld return $this hiij bn
        }

        public function visits()
        {
            return Redis::get($this->visitsCacheKey()) ?? 0;
            // hervee iu ch butsaahgui bol default ni 0
        }

        protected function visitsCacheKey()
        {
            return "threads.{$this->id}.visits";
        }
    }
