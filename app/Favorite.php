<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    

    /**
     * Fetch model that was favorited
     *
     * @return void
     */
    public function favorited() 
    {
       return $this->morphTo();
    }
}
