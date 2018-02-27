<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply) 
    {
        $reply->favorite();
       return response('You favorites this reply',202);
    }

    public function destroy(Reply $reply) 
    {
        $reply->unfavorite();
        return response('You unfavorites this reply',202); 
    }
}