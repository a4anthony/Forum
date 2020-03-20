@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> <a href="">{{$thread->creator->name}}</a> posted {{$thread->title}}</div>
                <div class="card-body">
                    <p>{{$thread->body}}</p>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach($thread->replies as $reply)
            @include('threads.reply')
            @endforeach
        </div>
    </div>

    @if (Auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{$thread->path() . '/replies'}}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" id="body" class="form-control" cols="30" rows="10" placeholder="Leave a reply"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>
    </div>
    @else
    <p>Please <a href="{{route('login')}}"> sign in </a> to join discussion</p>
    @endif
</div>
@endsection