@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._list')

                {{ $threads->render() }}
            </div>

            <div class="col-md-4">
                @if (count($trending))
                    <div class="card">
                        <div class="card-header bg-transparent">
                            Trending Threads
                        </div>

                        <div class="card-body">
                            @foreach ($trending as $thread)
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a href="{{ url($thread->path) }}">
                                            {{ $thread->title }}
                                        </a>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection


