<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * @param $channeld
     * @param \App\Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channeld, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back()->with('flash', 'Your reply has been left.');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
//        $reply->update(['body' => request('body')]);
        // doorhtoi adilhan

        $reply->update(request(['body']));
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

