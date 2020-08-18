<div class="col-md-8">
    <div class="card mb-2">
        <h1 class="block my-1 text-lg leading-tight font-semibold text-gray-900 ">
            <a href="#">
                {{ $reply->owner->name }}
            </a>
            said {{ $reply->created_at->diffForHumans() }}
        </h1>

        <div class="panel-body">
            {{ $reply->body }}
        </div>
    </div>
</div>
