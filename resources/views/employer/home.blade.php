@extends('masters.EmpPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/employer-dashboard.css">
@endsection
@section('body')
@include('employer.modals.dashboard.endjob')

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
	<h1>Schedule</h1>
	<hr>
	<h2 id="pending-header">End Job Requests</h2>
	<hr>
	<div id="pending-feeds"></div>
	<h2>Applicants currently working right now.</h2>
	<hr>
	<div id="active-feeds"></div>
	<hr>
	<h2 class="dash-head">Applicants going to work today.</h2>
	<hr>
	<div id="upcoming-feeds"></div>
</div>
@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places"></script>
<script src="/sweetalert/sweetalert.min.js"></script>
<script src="/calendar/moment.min.js"></script>
<script src="/js/star-rating.js" type="text/javascript"></script>
<script src="/bootstrap/bootstrap-select.js"></script>
<script src="/js/employer-dashboard.js"></script>
@endsection
