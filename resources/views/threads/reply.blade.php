<div id="reply-{{ $reply->id }}" class="my-2">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6>
{{--                    <a href="/profiles/{{ $reply->owner->name }}">--}}
                    <a href="{{ route('profile', $reply->owner) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}...
                </h6>

                <div>
                    <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                        @csrf

                        <button type="submit"
                                class="btn btn-light btn-outline-secondary"
                                {{ $reply->isFavorited() ? 'disabled' : '' }}
                        >
{{--                            {{ $reply->favorites()->count() }} {{ Str::plural('Favorite', $reply->favorites()->count()) }}--}}
                            {{ $reply->favorites_count}} {{ Str::plural('Favorite', $reply->favorites_count) }}

                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{ $reply->body }}
        </div>
    </div>
</div>
