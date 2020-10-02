@extends('layouts.app')

@section('content')
    <thread-view :data-replies-count="{{ $thread->replies_count }}" :data-locked="{{ $thread->locked }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-md-5">
                        <div class="card-header d-flex justify-content-between">

                            <div class="d-flex align-items-center">
                                <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" width="25" height="25" class="mr-1">

                                <a href="{{ route('profile', $thread->creator) }}"
                                   class="pr-1">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                            </div>

                            @can ('update', $thread)
                                <form action="{{ $thread->path() }}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-link">Delete Thread</button>
                                </form>
                            @endcan
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies
                             @added="repliesCount++"
                             @removed="repliesCount--"
                    ></replies>
                </div>

                <div class="col-md-4">
                    <div class="card mb-md-5">
                        <div class="card-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>,
                                @if ($thread->replies_count)
                                    and currently
                                    has <span v-text="repliesCount"></span> {{ Str::plural('comment', $thread->replies_count) }}.
                                    <!-- SQL query just catch count, instead of return all collection, then count. -->
                                @endif
                            </p>

                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>

                                <button class="btn btn-light" v-if="authorize('isAdmin') && ! locked" @click="locked = true">Lock</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
