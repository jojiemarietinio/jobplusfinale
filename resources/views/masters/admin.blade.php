@extends('masters.AppPrimary')

@section('body')
<div class="container">
  <h2>Bagzki's Cheat Code</h2>
  <hr>
  <table class="table">
    <thead>
      <tr>
        <th>JId</th>
        <th>Job Title</th>
        <th>Category</th>
        <th>Skills</th>
        <th>Schedule</th>
        <th>City</th>
        <th>Ptype</th>
        <th>Salary</th>
        <th>DatePosted</th>
      </tr>
    </thead>
    <tbody>
    @foreach($job as $j)
    <tr>
    	<td>{{ $j->job_id }}</td>
    	<td>{{ $j->title }}</td>
    	<td>
    	@foreach($category as $c)
    	@if($c->category_id == $j->category_id)
    	{{ $c->name }}
    	@endif
    	@endforeach
    	</td>
    	<td>
    	@foreach($skill as $s)
		@if($s->job_id == $j->job_id)
			@foreach($sk as $ski)
				@if($s->skill_id == $ski->skill_id)
					<p>{{$ski->name}}</p>
				@endif
			@endforeach
		@endif    	
    	@endforeach
    	</td>
    	<td>
    		@foreach($schedule as $sch)
    		@if($sch->job_id == $j->job_id)
    			<p><b>Start:</b> {{$sch->start}}</p>
    			<p><b>End:</b> {{$sch->end}}</p>
    		@endif
    		@endforeach
    	</td>
    	<td>
    		@foreach($address as $a)
    			@if($a->jobid == $j->job_id)
    				{{$a->locality}}
    			@endif
    		@endforeach
    	</td>
    	<td>
    		@foreach($paytype as $p)
    		@if($p->paytype_id == $j->paytype)
    		{{$p->name}}
    		@endif
    		@endforeach
    	</td>
    	<td>
    		{{$j->salary}}
    	</td>
    	<td>{{$j->date_posted}}</td>
    </tr>
    @endforeach
    </tbody>
  </table>
</div>

@endsection

