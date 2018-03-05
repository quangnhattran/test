<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReputationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_user_earn_points_when_open_a_thread() 
    {
       $thread = create('App\Thread');
       $this->assertEquals(5,$thread->creator->reputation);
    }

    /** @test */
    function a_user_earn_points_when_reply_to_a_thread() 
    {
       $reply = create('App\Reply');
       $this->assertEquals(2,$reply->owner->reputation);
    }

    /** @test */
    function a_user_earn_points_when_their_reply_selected_as_best_reply() 
    {
        $this->signIn();
        $thread = create('App\Thread',['user_id'=>auth()->id()]);
        $reply = create('App\Reply',['thread_id'=>$thread->id]);
        $this->post("/replies/{$reply->id}/best");
        $this->assertEquals(52,$reply->owner->fresh()->reputation);
    }
}
