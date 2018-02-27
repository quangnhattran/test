<?php
namespace App\Inspectors;
class InvalidKeywords 
{
    protected $keywords = [
        'yahoo customer support'
    ];

    public function detect($body) 
    {
       foreach ($this->keywords as $keyword) {
           if(stripos($body,$keyword) === 0) {
               throw new \Exception('Your reply contains spam');
           }
       }
    }
}