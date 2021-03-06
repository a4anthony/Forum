<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reply;
use App\User;
use App\Channel;
use App\Filters\ThreadFilters;

class Thread extends Model
{
    //
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(
            'replyCount',
            function ($builder) {
                $builder->withCount('replies');
            }
        );
    }


    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    public function path()
    {
        return  '/threads/' . $this->channel->slug . '/' . $this->id;
    }
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
