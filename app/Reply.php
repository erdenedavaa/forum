<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected static function boot()
    {
        parent::boot();

        // doorhiin davuu tal ni jishee ni,
        // factory('App\Reply')->create(); hiihed
        // automataar tootsogddgo

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
//            dd($reply->thread->replies_count);
        });
    }


    protected $appends = ['favoritesCount', 'isFavorited', 'isUserLoggedIn'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

}
