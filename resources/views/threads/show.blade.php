@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> <a href="">{{$thread->creator->name}}</a> posted {{$thread->title}}</div>
                <div class="card-body">
                    <p>{{$thread->body}}</p>
                </div>
            </div>
            <hr>

            <div>
                @foreach($replies as $reply)
                @include('threads.reply')
                @endforeach
                {{$replies->links()}}
            </div>

            @if (Auth()->check())
            <div>
                <form action="{{$thread->path() . '/replies'}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" cols="30" rows="10" placeholder="Leave a reply"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
            @else
            <p>Please <a href="{{route('login')}}"> sign in </a> to join discussion</p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p>
                        This thread was published {{$thread->created_at->diffForHumans()}} by
                        <a href="#">{{$thread->creator->name}}</a>
                        and currently has {{$thread->replies_count}} {{Str::plural('comment', $thread->replies_count)}}.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection