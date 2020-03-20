<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Thread;
use App\User;
use App\Channel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Database\Eloquent\Collection;

class ThreadTest extends TestCase
{
    protected $thread;
    use DatabaseMigrations;
    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_ca_add_a_reply()
    {
        $this->thread->addReply(
            [
                'body' => 'Foobar',
                'user_id' => 1
            ]
        );

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);
        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
    public function test_a_thread_van_make_a_string_path()
    {
        $thread = create(Thread::class);
        $this->assertEquals(
            '/threads/' . $thread->channel->slug . '/' . $thread->id,
            $thread->path()
        );
    }
}
