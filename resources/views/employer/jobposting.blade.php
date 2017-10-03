@extends('masters.EmpPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/employer-jobpost.css">
<link rel="stylesheet" href="/css/malot-timepicker.css">
@endsection

@section('body')
@include('employer.modals.jobpage.jobposting')
@include('employer.modals.jobpage.recommended')

<div class="hero">
	<div class="container">
		<h1>In need of assistance?</h1>
		<button class="btn btn-md btn-postjob" id="btn-postjob">POST A JOB</button>
	</div>
</div>

<div class="container">
	<div class="row">
		<h1 class="up-header">Jobs Posted</h1>
		<div class="form-group-md col-md-offset-6  sort-by">
			<h3>Sort by</h3>
			<select class="selectpicker" data-style="selectp">
				<option value="0" class="selectoption" selected="selected">All</option>
			</select>
		</div>
	</div>
	<hr>
	<div class="jobfeeds"></div>
</div>
@endsection

@section('js')	
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places"></script>
<script src="/bootstrap/bootstrap-select.js"></script>
<script src="/calendar/moment.min.js"></script>
<script src="/js/malot-timepicker.js"></script>
<script src="/sweetalert/sweetalert.min.js"></script>
<script src="/js/employer-jobpost.js"></script>
@endsection

