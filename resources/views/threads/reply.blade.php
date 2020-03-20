<div class="card">
    <div class="card-header">Replied {{$reply->created_at->diffForHumans()}}</div>
    <div class="card-body">
        <p>
            <a href="">
                {{$reply->owner->name}}
            </a>
            said:</p>
        <p>{{$reply->body}}</p>
    </div>
</div>
<hr>