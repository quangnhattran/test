<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function anyone_can_search_threads() 
    {
       $keyword = 'foobar';
       create('App\Thread',[],2);
       create('App\Thread',['title'=>"The thread is about {$keyword}"],2);
       while (empty($results)) {
           sleep(.25);
           $results = $this->getJson('/threads/search?q='.$keyword)->json()['data'];
       }
       
       $this->assertCount(2,$results);
       Thread::latest()->take(4)->get()->unsearchable();
    }
}
