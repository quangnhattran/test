<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() 
    {
        $name = request('name');

       return User::where('name','LIKE',"%$name%")
                ->take(5)->pluck('name'); 
    }

    public function confirm()
    {
        $user = auth()->user();
        if($user->confirmation_token == request('token')) {
            $user->confirm();
            return redirect('/threads')->with('flash','Congrats, you verified your email');
        }
        return redirect('/threads')->with(['flash'=>'Whoops, token is invalid','type'=>'danger']);
    }
}
