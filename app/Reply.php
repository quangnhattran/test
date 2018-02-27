<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable,RecordsActivity;
    protected $guarded=[];

    protected $with=['owner'];

    protected $appends = ['isFavorited','favorites_count','isBest'];

    protected static function boot()
    {
        parent::boot();
        static::created(function($reply) {
            $reply->thread->increment('replies_count');
        });
        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function getIsBestAttribute() 
    {
       return $this->thread->where('best_reply_id',$this->id)->exists();
    }
    /**
     * Return mentioned usernames within reply body
     *
     * @return void
     */
    public function mentionedUsers() 
    {
        preg_match_all('/@([\w\-]+)/',$this->body,$mentionedNames);
       return $mentionedNames[1];
    }

    public function setBodyAttribute($body) 
    {
       return $this->attributes['body']=preg_replace('/@([\w\-]+)/','<a href="/profiles/$1">$0</a>',$body);
    }

    public function path() 
    {
       return $this->thread->path().'#reply-'.$this->id;
    }
    
    public function thread() 
    {
       return $this->belongsTo('App\Thread');
    }

    public function owner() 
    {
       return $this->belongsTo('App\User','user_id');
    }
}
