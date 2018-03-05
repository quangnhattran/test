<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Notifications\ReplyWasAdded;
use App\Reply;
use App\Events\ThreadWasReplied;
use App\Reputation;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index']]);
    }

    public function index($channelId,Thread $thread) 
    {
       return $thread->replies()->paginate(5);
    }

    public function store($channelId,Thread $thread) 
    {
        $reply = request()->validate([
            'body' => ['required','min:3','spamfree']
        ]);

        if($thread->locked) {
            return response('Thread is Locked',422);
        }
        
        return $thread->addReply($reply+['user_id'=>auth()->id()])
                ->load('owner');
       
    }

    public function update(Reply $reply) 
    {
        $reply->update(['body'=>request('body')]);
       return response('Updated REPLY',202);
    }
    /**
     * Remove a reply
     *
     * @param Reply $reply
     * @return void
     */
    public function destroy(Reply $reply) 
    {
        $reply->delete();
       return response('Reply removed',202);
    }

    public function markBestReply(Reply $reply) 
    {
        $this->authorize('update',$reply->thread);
        $reply->thread()->update(['best_reply_id'=>$reply->id]);
        //$reply->owner->increment('reputation',50);
        Reputation::award($reply->owner,Reputation::REPLY_MARKED_AS_BEST_POINTS);
        return response('Reply marked as best',202);
    }
}
