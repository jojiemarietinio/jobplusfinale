@extends('layouts.inbox')
@section('body')
<div class="media">
    <a class="pull-left" href="#">
        <img src="{{ $message->user->profile->avatar}}"
             alt="{{ $message->user->name }}" class="img-circle" style="width:60px;height:60px;border-radius:50%;">
    </a>
    <div class="media-body">
        <h4 class="media-heading">{{ $message->user->profile->lname }} {{ $message->user->profile->fname }}</h4>
        <p><h3>{{ $message->body }}</h3></p>
        <div class="text-muted">
            <small>Posted {{ $message->created_at->diffForHumans() }}</small>
        </div>
    </div>
</div>
@endsection