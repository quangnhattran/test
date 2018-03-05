<?php
namespace App;

class Reputation 
{
    const PUBLISH_THREAD_POINTS = 5,
          ADD_REPLY_POINTS = 2,
          REPLY_FAVORITED_POINTS = 10,
          REPLY_MARKED_AS_BEST_POINTS = 50;
    
    public static function award($user,$points)
    {
        return $user->increment('reputation',$points);
    }
}