<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use App\User;
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
     * @param \App\Http\Forms\CreatePostRequest $form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\Response
     */
    public function store($channeld, Thread $thread, CreatePostRequest $form)
    {
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        // Inspect the body of the reply for username mentions
        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

        foreach ($matches[1] as $name) {
            $user = User::whereName($name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
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

