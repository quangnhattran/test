<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Notifications\ReplyWasAdded;
use App\Reply;
use App\Events\ThreadWasReplied;

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
        $reply->thread()->update(['best_reply_id'=>$reply->id]);
        return response('Reply marked as best',202);
    }
}
