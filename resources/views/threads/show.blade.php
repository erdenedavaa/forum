@extends('layouts.app')

@section('content')
    <div class="container mb-10">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1 class="block my-1 text-lg leading-tight font-semibold text-gray-900 hover:underline">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </h1>

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
                @include('threads.reply')
            @endforeach
        </div>
    </div>
@endsection
