<?php
namespace App;

use Illuminate\Support\Facades\Redis;


class Trending 
{
    public function push($thread) 
    {
        Redis::zincrby($this->getCacheKey(),1,json_encode([
            'link' => $thread->path(),
            'title' => $thread->title
        ]));
        
    }

    public function all() 
    {
       return array_map('json_decode',Redis::zrevrange($this->getCacheKey(),0,4));
    }

    protected function getCacheKey()
    {
        return app()->environment()=='testing' ? 'testing_trending' : 'trending_threads';
    }

    public function destroy() 
    {
       return Redis::del($this->getCacheKey());
    }
}