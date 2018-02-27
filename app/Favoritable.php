<?php
namespace App;

trait Favoritable 
{
    public static function bootFavoritable() 
    {
       static::deleting(function($model){
               $model->favorites->each->delete();
           });
    }

    public function getIsFavoritedAttribute() 
    {
       return $this->isFavorited();
    }

    public function isFavorited() 
    {
       return !! $this->favorites_count;
    }

    public function getFavoritesCountAttribute() 
    {
       return $this->favorites->count();
    }

    public function favorite() 
    {
        $attributes = ['user_id'=>auth()->id()];
       if(! $this->favorites()->where($attributes)->exists())
       $this->favorites()->create($attributes);
    }

    public function unfavorite() 
    {
        $attributes = ['user_id'=>auth()->id()];
        $this->favorites()->where($attributes)->delete(); 
    }

    public function favorites() 
    {
       return $this->morphMany('App\Favorite','favorited');
    }

}