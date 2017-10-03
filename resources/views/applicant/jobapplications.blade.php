@extends('masters.AppPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/japplications.css">
@endsection
@section('body')
<div id="loading">
	<div id="loading-center">
		<div id="loading-center-absolute">
			<div class="object" id="object_one"></div>
			<div class="object" id="object_two"></div>
			<div class="object" id="object_three"></div>
			<div class="object" id="object_four"></div>
		</div>
	</div>
</div>
<div class="container">
	<h1>Pending Job Applications</h1>
	<hr>
	
	<table class="table">
		<thead>
			<tr>
				<th>Date Applied</th>
				<th>Job Title</th>
				<th>Employer</th>
				<th>Salary</th>
				<th>Request</th>
			</tr>
		</thead>
		<tbody>
			@foreach($apps as $app)
			<tr>
				<td>{{$app->jobs->date_posted}}</td>
				<td>{{$app->jobs->title}}</td>
				<td>{{$app->jobs->users->profile->fname}} , {{$app->jobs->users->profile->lname}}</td>
				<td>Php {{$app->jobs->salary}} / {{$app->jobs->paytypes->name}}</td>
				<td><button class="btn btn-md" appid="{{$app->application_id}}" id="btn-cancel">Cancel Application</button></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection

@section('js')
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		  $("#loading").fadeOut(300);
		$(document).on('click','#btn-cancel',function(){
			var appid = $(this).attr('appid');
			
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var decline = $.ajax({
				url:'/set/application/decline',
				method:'GET',
				data:{
					'id':appid
				}
			});

			decline.done(function(data){
				location.reload();
			});

		});
	});
</script>
@endsection