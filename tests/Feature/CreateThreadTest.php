<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rules\Recaptcha;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        app()->singleton(Recaptcha::class,function(){
            $m = \Mockery::mock(Recaptcha::class);
             $m->shouldReceive('passes')->andReturn(true);
             return $m;
        });
        
    }

    /** @test */
    function a_thread_requires_a_valid_recaptcha() 
    {
        //dd(new Recaptcha);
        unset(app()[Recaptcha::class]);
       $this->publishThread()
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    public function publishThread($attributes=[])
    {
        $this->signIn();
        $thread = make('App\Thread',$attributes);
        return $this->post('/threads',$thread->toArray()+['g-recaptcha-response'=>'test']);
        //return $this;
    }

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
