<?php

/**
 * @category For thread testing
 * @package category
 * @author Anthony Akro <anthonygakro@gmail.com>
 * @license MIT
 * @link http://url.com
 */

namespace Tests\Feature;

use App\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Thread;
use App\Reply;
use App\User;

/**
 * Tests for threads
 *
 * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
 */
class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_browse_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_browse_a_threads()
    {
        $response = $this->get($this->thread->path());
        $response->assertSee($this->thread->title);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_read_thread_replies()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id, 'user_id' => $this->thread->user_id]);

        $response = $this->get($this->thread->path());
        $response->assertSee($reply->body);
    }
    public function test_a_useer_can_filter_test_by_tag()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
    public function test_a_user_can_filter_thread_by_author()
    {
        $this->signIn(create(User::class, ['name' => 'Tony']));
        $threadByTony = create(Thread::class, ['user_id' => auth()->id()]);
        $threadNotByTony = create(Thread::class);
        $this->get('/threads?by=Tony')
            ->assertSee($threadByTony->title)
            ->assertDontSee($threadNotByTony->title);
    }
    public function test_a_user_can_feature_test_by_popularity()
    {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

   
        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
