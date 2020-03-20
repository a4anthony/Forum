<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use App\User;
use App\Thread;
use App\Reply;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_participate_in_forum()
    {
        $this->withExceptionHandling()
            ->post('/threads/quin/1/replies', [])
            ->assertRedirect('/login');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_participate_in_forum()
    {
        //an authenticated user
        $this->signIn();

        //an existing thread
        $thread = create(Thread::class);

        //when user adds reply to threads
        $reply = make(Reply::class);
        $this->post(
            '/threads/' . $thread->channel->slug . '/' . $thread->id . '/replies',
            $reply->toArray()
        );

        //a user can seee their reply
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
    public function test_a_reply_must_have_a_body()
    {
        $this->withExceptionHandling()->signIn();

        //an existing thread
        $thread = create(Thread::class);

        //when user adds reply to threads
        $reply = make(Reply::class, ['body' => null]);
        $this->post(
            '/threads/' . $thread->channel->slug . '/' . $thread->id . '/replies',
            $reply->toArray()
        )
            ->assertSessionHasErrors('body');
    }
}
