<?php

namespace App;

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
        return $this->replies()->create($reply);
        // replies_count columniig ihesgeh ehnii arga, nuguuh ni
        // model event
        // Model Event ashiglahiin davuu tal ni
        // replies_count ni addReply bolon busdaas hamaaralgui ajildag bolno
//        $reply = $this->replies()->create($reply);
//
//        $this->increment('replies_count');
//
//        return $reply;
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
        $this->subscription()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscription()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscription()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscription()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
