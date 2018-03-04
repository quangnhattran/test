<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trending;

class SearchController extends Controller
{
    public function index(Trending $trending)
    {
        return view('threads.search',[
             'trending' => $trending->all()
        ]);
    }
}
