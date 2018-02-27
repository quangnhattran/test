<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    /**
     * Get subject of the activity
     *
     * @return void
     */
    public function subject() 
    {
       return $this->morphTo(); 
    }

    /**
     * Fetch all activities associated with a user
     *
     * @param App\User $user
     * @param integer $take
     * @return void
     */
    public static function feed($user, $take=50) 
    {
       return static::where('user_id',$user->id)
                ->latest()
                ->with('subject')
                ->take($take)
                ->get()
                ->groupBy(function($activity){
                    return $activity->created_at->format('Y-m-d');
                }) ;
    }
}
