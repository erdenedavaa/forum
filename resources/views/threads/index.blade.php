@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="d-flex flex-column align-items-center">
                @include('threads._list')

                {{ $threads->render() }}
            </div>
        </div>
    </div>
@endsection


