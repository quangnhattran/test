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
            Reputation::award($reply->owner,Reputation::ADD_REPLY_POINTS);
        });
        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
            Reputation::reduce($reply->owner,Reputation::ADD_REPLY_POINTS);
            if($reply->id==$reply->thread->best_reply_id) {
                $reply->thread()->update(['best_reply_id'=>null]);
                Reputation::reduce($reply->owner,Reputation::REPLY_MARKED_AS_BEST_POINTS);
            }
        });
    }

    public function getIsBestAttribute() 
    {
       return $this->thread->where('best_reply_id',$this->id)->exists();
    }

    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
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

    public function markBestReply()
    {
        $current_best_reply = $this->thread->best_reply_id;
        if($current_best_reply && $this->id != $current_best_reply) {
            Reputation::reduce(Reply::find($current_best_reply)->owner,Reputation::REPLY_MARKED_AS_BEST_POINTS);
        }
        Reputation::award($this->owner,Reputation::REPLY_MARKED_AS_BEST_POINTS);
        $this->thread()->update(['best_reply_id'=>$this->id]);
    }
}
