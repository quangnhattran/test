<?php
namespace App;

trait RecordsActivity 
{
    public static function bootRecordsActivity() 
    {
       foreach(static::getActivityTypes() as $type)
       {
           static::$type(function($model) use ($type){
               $model->recordActivity($type);
           });

           static::deleting(function($model){
               $model->activity()->delete();
           });
       } 
    }

    public function recordActivity($type) 
    {
       $user_id = auth()->check() ? auth()->id() : $this->id;
       return $this->activity()->create(['user_id'=>$user_id,'type'=>$this->getType($type)]); 
    }

    /**
     * Define all types of model events need to be recorded
     *
     * @return void
     */
    public static function getActivityTypes() 
    {
       return ['created'];
    }

    public  function getType($type) 
    {
       return $type.'_'.strtolower((new \ReflectionClass($this))->getShortName());
    }

    /**
     * Create relationship to Activity model
     *
     * @return void
     */
    public function activity() 
    {
       return $this->morphMany('App\Activity','subject');
    }
}