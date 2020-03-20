@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Threads</div>

                <div class="card-body">
                    <form action="/threads" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="channel_id">Choose a Channel:</label>
                            <select class="form-control" name="channel_id" id="channel_id" required>
                                <option value="">-- Select Channel --</option>
                                @foreach($channels as $channel)
                                <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{old('title')}}" placeholder="title" required>
                        </div>
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" class="form-control" id="body" cols="30" rows="10" value="{{old('body')}}" placeholder="Enter your body" required></textarea>
                        </div>
                        @if (count($errors))
                        <ul class="aler alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>
                                {{$error}}
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection