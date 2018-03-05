<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\ThreadWasReplied;
use App\Exceptions\LockedThreadException;
use Laravel\Scout\Searchable;
class Thread extends Model
{
    use RecordsActivity;
    use Searchable;

    protected $guarded = [];
    protected $with = ['creator','channel']; //Just eager loading relationships
    protected $appends = ['isSubscribed'];
    protected $casts = [
        'locked' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function($thread){
            $thread->update(['slug'=>$thread->title]);
            Reputation::award($thread->creator,Reputation::PUBLISH_THREAD_POINTS);
        });
        static::deleted(function($thread){
            Reputation::reduce($thread->creator,Reputation::PUBLISH_THREAD_POINTS);
        });
    }
    public function path() 
    {
       return "/threads/{$this->channel->slug}/{$this->slug}";
    }


    public function addReply($reply) 
    {
       $reply= $this->replies()->create($reply); 
       event(new ThreadWasReplied($reply));
       return $reply;
    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path'=>$this->path()];
    }

    public function setSlugAttribute($title)
    {
        if(static::whereSlug($slug = str_slug($title))->exists()) {
            $slug = "{$slug}-{$this->id}";
        }
        return $this->attributes['slug'] = $slug;
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

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
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

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
