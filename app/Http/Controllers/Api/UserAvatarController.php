<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    public function store() 
    {
       request()->validate([
           'avatar' => 'required|image'
       ]); 
       auth()->user()->update(['avatar'=>request()->file('avatar')->store('images/avatars','public')]);
       
       return response('New avatar uploaded',202);
    }
}
