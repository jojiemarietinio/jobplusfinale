@extends('masters.AppPrimary')

@section('body')
<div class="container">
	<h1>SMS Page</h1>
	<hr>
	<form action="{{url('sms/send')}}" method="POST">
	{{ csrf_field() }}
	<h1>Recipient Number</h1>
	<input type="text" id="mobile" name="mobile" placeholder="phone number">
	<h1>Message</h1>
	<textarea  style="width:100%;height:130px;" id="message" placeholder="Message to recipient"></textarea>
	<hr>
	<button type="submit" class="btn btn-lg" id="btn-send">Send</button>
	</form>
</div>
@endsection
