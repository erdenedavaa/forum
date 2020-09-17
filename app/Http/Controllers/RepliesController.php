<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * @param $channeld
     * @param \App\Thread $thread
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($channeld, Thread $thread)
    {
        if (Gate::denies('create', new Reply)) {
            return response(
                'You are posting too frequently. Please take a break. :)', 422
            );
        }

        try {
            request()->validate(['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch(\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

        return $reply->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
//        $reply->update(['body' => request('body')]);
        // doorhtoi adilhan

        try {
//            $this->validate(request(), ['body' => 'required|spamfree']);
            request()->validate([
                'body' => ['required', new SpamFree]
            ]);

            $reply->update(request(['body']));
        } catch(\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }


    }

    public function destroy(Reply $reply)
    {
//        if ($reply->user_id != auth()->id()) {
//            return response([], 403);
//        }
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
        // butsaah utga ni 302 bdag.
    }
}

