<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_can_be_locked() 
    {
       $thread = create('App\Thread');
       $this->assertFalse($thread->locked);
       $thread->lock();
       $this->assertTrue($thread->locked);
    }
}
