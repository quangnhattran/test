<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\ThreadWasReplied;

class Thread extends Model
{
    //use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator','channel']; //Just eager loading relationships
    protected $appends = ['isSubscribed'];
    public function path() 
    {
       return "/threads/{$this->channel->name}/{$this->id}";
    }

    public function addReply($reply) 
    {
       $reply= $this->replies()->create($reply); 
       event(new ThreadWasReplied($reply));
       return $reply;
    }
    /**
     * Check whether thread was updated since last user visit
     *
     * @param App\User $user
     * @return boolean
     */
    public function hasUpdateFor($user) 
    {
       return $this->updated_at > cache()->store('redis')->get($user->getCacheKeyName($this));
    }

    public function getIsSubscribedAttribute() 
    {
       return $this->subscriptions()->where('user_id',auth()->id())->exists();
    }

    public function subscribe() 
    {
        $this->subscriptions()->create(['user_id'=>auth()->id()]); 
    }

    public function unsubscribe() 
    {
        $this->subscriptions()->where(['user_id'=>auth()->id()])->delete(); 
    }

    public function subscriptions() 
    {
       return $this->hasMany('App\ThreadSubscription','thread_id');
    }

    public function scopeFilter($builder,$filter) 
    {
       return $filter->apply($builder);
    }

    public function replies() 
    {
       return $this->hasMany('App\Reply');
    }

    public function creator() 
    {
       return $this->belongsTo('App\User','user_id');
    }

    public function channel() 
    {
       return $this->belongsTo('App\Channel');
    }
}
