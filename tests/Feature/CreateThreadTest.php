<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function no_administrator_may_not_lock_threads() 
    {
       $this->signIn();
       $thread = create('App\Thread');
       $this->post(route('locked-thread.store',$thread))
            ->assertStatus(403);
    }

    /** @test */
    function administrator_can_lock_a_thread() 
    {
       $this->signIn(factory('App\User')->states('administrator')->create());
       $thread = create('App\Thread');
       $this->post(route('locked-thread.store',$thread))
            ->assertStatus(200);
        $this->assertEquals(1,$thread->fresh()->locked);
    }

    /** @test */
    function no_reply_for_locked_thread() 
    {
        $this->signIn();
        $thread = create('App\Thread');
        $thread->lock();
        $this->postJson($thread->path().'/replies',[
            'body' => 'hello, qt',
            'user_id' => auth()->id()
        ])->assertStatus(422);   
    }
}
