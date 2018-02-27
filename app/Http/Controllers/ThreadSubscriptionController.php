<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ThreadSubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store($channelId,Thread $thread) 
    {
        $thread->subscribe();
        return response('You are subscribed',202);
        //return back()->with('flash','You subscribed to this thread');
    }

    public function destroy($channelId,Thread $thread) 
    {
        $thread->unsubscribe();
        return response('You are unsubscribed',202);
        //return back()->with('flash','You no longer subscribe to this thread'); 
    }
}
