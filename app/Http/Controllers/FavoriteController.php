<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Reputation;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply) 
    {
        $reply->favorite();
        //$reply->owner->increment('reputation',10);
        Reputation::award($reply->owner,Reputation::REPLY_FAVORITED_POINTS);
       return response('You favorites this reply',202);
    }

    public function destroy(Reply $reply) 
    {
        $reply->unfavorite();
        return response('You unfavorites this reply',202); 
    }
}