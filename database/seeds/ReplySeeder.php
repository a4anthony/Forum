<?php

use App\Thread;
use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads =  factory(App\Thread::class, 50)->create();
        $threads->each(
            function ($thread) {
                factory(App\Reply::class, 5)->create(['thread_id' => $thread->id]);
            }
        );
    }
}
