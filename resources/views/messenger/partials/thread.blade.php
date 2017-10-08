@extends('layouts.messageList')

<?php $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; ?>

@section('content')
    <td>
    <p>
        <span class="subject"><a href="{{ route('messages.show', $thread->id) }}">{!! $thread->participantsString(Auth::id(), ['username']) !!} ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</a></span>
    </p>
    </td>   
     <td><span class="subject">{{ $thread->subject }}</span>
        <small class="text-muted">{{ $thread->latestMessage->body }}</small></td>
    <td><small>{{ $thread->created_at->diffForHumans() }}</small></td>
</div>
@endsection