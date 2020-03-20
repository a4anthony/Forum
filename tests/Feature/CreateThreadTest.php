<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use App\Thread;
use App\User;
use App\Channel;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_cannot_create_thread()
    {
        $this->withExceptionHandling()
            ->post('/threads')
            ->assertRedirect('/login');
        $this->get('/threads/create')
            ->assertRedirect('/login');
        $this->post('/threads')
            ->assertRedirect('/login');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_create_thread()
    {
        //an authenticated user
        $this->signIn();

        //an existing thread
        $thread = make(Thread::class);

        //when user adds reply to threads
        $response = $this->post('/threads', $thread->toArray());

        //a user can seee their reply
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    public function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }
    public function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }
    public function test_a_thread_requires_a_valid_channelId()
    {
        factory(Channel::class, 2)->create();
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 888])
            ->assertSessionHasErrors('channel_id');
    }
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);
        //dd($thread);
        return $this->post('/threads', $thread->toArray());
    }
}
