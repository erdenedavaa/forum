<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        // doorh ni bainga duudagddag, harin uuniig
        // DBiin columnd oruulbal nemelt query hiigdehgui
//        static::addGlobalScope('replyCount', function($builder) {
//            $builder->withCount('replies');
//        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();

//            $thread->replies->each(function ($reply) {
//                $reply -> delete();
//            });
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
//
//    public function getReplyCountAttribute()
//    {
//        return $this->replies()->count();
//    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
//        (new \App\Spam)->detect($reply->body);

        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

//        $this->notifySubscribers($reply); // listener

//        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

//    public function notifySubscribers($reply)
//    {
//        $this->subscriptions
//            ->where('user_id', '!=', $reply->user_id)
//            ->each
//            ->notify($reply);
//    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this; // return this instance
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user = null)
    {
        $user = $user ?: auth()->user();

        // Look in the cache for the proper key.
        // compare that carbon instance with the $thread->updated_at
        $key = auth()->user()->visitedThreadCacheKey($this);
        // users.50.visits.1

        return $this->updated_at > cache($key);
    }

    public function visits()
    {
        return new Visits($this);
        // Thread $thread iig shuud oruulj bn
    }
}
