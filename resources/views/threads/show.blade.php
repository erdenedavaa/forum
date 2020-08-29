@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-md-5">
                    <div class="card-header d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
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

                @foreach ($replies as $reply)
                    @include ('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}" class="mt-md-5">
                        @csrf

                        <div class="form-group">
                            <textarea name="body" id="body" rows="5" class="form-control"
                                      placeholder="Have something to say?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                @else
                    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this
                        discusstion.</p>
                @endif

            </div>

            <div class="col-md-4">
                <div class="card mb-md-5">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a>
                            @if ($thread->replies_count)
                                , and currently has {{ $thread->replies_count }} {{ Str::plural('comment', $thread->replies_count) }}.
                                <!-- SQL query just catch count, instead of return all collection, then count. -->
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
