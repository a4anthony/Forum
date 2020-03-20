@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach($threads as $thread)
                    <article>
                        <div class="level">
                            <h4 class="flex">
                                <a href="{{$thread->path()}}">
                                    {{$thread->title}}
                                </a>
                            </h4>
                            <strong>
                                <a href="{{$thread->path()}}">
                                    {{$thread->replies_count}} {{Str::plural('comment', $thread->replies_count)}}.
                                </a>
                            </strong>
                        </div>

                        <p>{{$thread->body}}</p>
                    </article>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection