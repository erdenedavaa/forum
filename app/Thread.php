<?php

namespace App;

use App\Filters\ThreadFilters;
use App\Notifications\ThreadWasupdated;
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
        $reply = $this->replies()->create($reply);
        // replies_count columniig ihesgeh ehnii arga, nuguuh ni
        // model event
        // Model Event ashiglahiin davuu tal ni
        // replies_count ni addReply bolon busdaas hamaaralgui ajildag bolno
//        $reply = $this->replies()->create($reply);
//
//        $this->increment('replies_count');
//
//        return $reply;

        // prepare notifications for all subscribers.
        $this->subscriptions
            ->filter(function($sub) use ($reply) {
                return $sub->user_id != $reply->user_id;
            })
            ->each->notify($reply);
//            ->each(function($sub) use ($reply) {
//                $sub->notify($reply);
//            });

        // Doorhiig deerheer shinejilj solison.
//        foreach ($this->subscriptions as $subscription) {
//            if ($subscription->user_id != $reply->user_id) {
//                $subscription->user->notify(new ThreadWasupdated($this, $reply));
//            }
//        }

        return $reply;
    }

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
}
