@extends('layouts.app')

@section('content')
    <div class="container mb-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="block my-1 text-lg leading-tight font-semibold text-gray-900 hover:underline">{{ $thread->title }}</h1>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            @foreach ($thread->replies as $reply)
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
            @endforeach
        </div>
    </div>
@endsection
