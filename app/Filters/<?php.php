<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];
    
    public function by($username)
    {
        dd($username);
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}



<?php

namespace App\Filters;

use Illuminate\Http\Request;
use App\User;

class ThreadFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function apply($builder)
    {
        $this->builder = $builder;
        if ($this->request->has('by')) {
            $this->by($this->request->by);
        }
        return $this->builder;
    }
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
