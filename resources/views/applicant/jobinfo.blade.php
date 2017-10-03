@extends('masters.primary')

@section('body')

<div class="container">
	<div class="col-md-12 dash-content">
		<br>
  			@foreach($skills as $skill)
                @if($job->skill_id == $skill->skill_id)
                   <h2 class="list-group-item-heading">{{ $skill->name }}</h2> 
                @endif
            @endforeach

            @foreach($profile as $prof)
	            @if($prof->user_id == $job->user_id)
	            <tag>Posted by: {{ $prof->fname }} {{ $prof->lname }}</tag>
	          	@endif
            @endforeach
            <hr>
            <h2> Description </h2>
            <p>{{ $job->description }}</p>
            <hr>
            <h3>Salary</h3>
            {{ $job->salary }}
            <hr>
               <div class="button pull-right">
            	<a href="{{ route('app/apply',$job->job_id) }}" class="btn btn-primary btn-lg">Apply</a>
            	</div>
            	<div class="button pull-left">
            	<a href="{{ route('app/dashboard') }}" class="btn btn-default btn-lg">Back to Dashboard</a>
            	</div>
	</div>	
</div>
@endsection