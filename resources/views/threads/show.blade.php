@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h1>{{ $thread->title }}</h1>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
