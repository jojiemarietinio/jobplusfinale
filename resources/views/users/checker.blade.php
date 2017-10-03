@extends('masters.AppPrimary')
@section('css')
<style type="text/css">
	#map{
		margin-top: 20px;
		margin-bottom: 20px;
		width: 100%;
		height: 500px;
		background-color: #e7e7e7;
	}
</style>
@endsection
<div class="container">
<h1>Job Checker Page</h1>
<div class="col-md-12">
<table class="table">
    <thead>
      <tr>
        <th>Job ID</th>
        <th>Title</th>
        <th>Start</th>
        <th>End</th>
      </tr>
    </thead>
    <tbody>
    @foreach($job as $j)
      <tr>
        <td>{{$j->job_id}}</td>
        <td>{{$j->title}}</td>
        @foreach($sched as $sc)
        @if($sc->job_id == $j->job_id)
        <td>{{$sc->start}}</td>
        <td>{{$sc->end}}</td>
        @endif
        @endforeach
      </tr>
    @endforeach
    </tbody>
  </table>
  </div>
</div>

@section('js')
<script src="/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">

</script>
@endsection