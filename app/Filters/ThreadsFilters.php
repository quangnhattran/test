<?php
namespace App\Filters;

class ThreadsFilters 
{
    protected $builder;
    protected $filters = ['by','popular','unanswered','channel'];
    public function apply($builder) 
    {
       $this->builder = $builder;
       foreach (request()->all() as $key => $value) {
            if(array_key_exists($key,array_flip($this->filters)) && $value) {
                $this->$key(request($key));
            }
        }
    }

    protected function by($name) 
    {
        return $this->builder->whereHas('creator',function($query) use($name) {
            $query->whereName($name);
        });
    }

    protected function popular()
    {
        return $this->builder->orderBy('replies_count','desc'); 
    }

    protected function unanswered()
    {
        return $this->builder->where('replies_count',0);
    }

    protected function channel($channel)
    {
        return $this->builder->whereHas('channel',function($query) use($channel) {
            $query->whereName($channel);
        });
    }
}