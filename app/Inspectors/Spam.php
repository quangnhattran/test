<?php
namespace App\Inspectors;

class Spam 
{
    protected $inspectors = [
        KeyHeldDown::class,
        InvalidKeywords::class
    ];

    public function detect($body) 
    {
       foreach ($this->inspectors as $inspector) {
           app($inspector)->detect($body);
       }
       return false;
    }
}