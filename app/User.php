<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded= [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
        return redirect('/threads')->with('flash','Thanks, you verified email address');
    }

    public function getAvatarAttribute($avatar) //accessor mutator
    {
       return asset($avatar ?: 'images/avatars/default.png');
    }

    public function isAdmin()
    {
        return in_array($this->name,['QT','Anh Ngoc']);
    }

    public function threads() 
    {
       return $this->hasMany('App\Thread');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function read($thread) 
    {
       return cache()->store('redis')->forever($this->getCacheKeyName($thread),now());
    }

    public function getCacheKeyName($thread) 
    {
       return sprintf('user.%s.visits.%s',$this->id,$thread->id);
    }
}
