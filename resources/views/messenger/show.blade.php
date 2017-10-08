@extends('layouts.master')

@section('content')
    <div class="col-md-6">
        <h1>Subject: {{ $thread->subject }}</h1>
        @each('messenger.partials.messages', $thread->messages, 'message')

        @include('messenger.partials.form-message')
    </div>
@stop
