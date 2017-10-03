@extends('masters.AppPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/dashboard.css">
<link rel="stylesheet" href="/css/datetimepicker.min.css">
@endsection

@section('body')
@include('applicant.modals.dashboard.endjob')
@include('applicant.modals.dashboard.resched')
@include('applicant.modals.dashboard.seemore')
@include('applicant.modals.dashboard.received')

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
  <div class="col-md-12 time-body ">
    <div class="pending_confirm">
      <h1>Pending Employer's Confirmation</h1>
      <div class="pending-feed"></div>
    </div>

    <h1>Active Job</h1>
    <p id="active-p">No items to display.</p>
    <div class="active-body">
      <div class="timeline-heading">
        <div class="col-md-12 head-tools">
          <button class="btn btn-md btn-apply hidden" id="actend">End job </button>
          <button class="btn btn-md btn-apply" id="actstart">Start job</button>
          <h1 id="head-min"></h1>
          <h2 id="head-meta"></h2>
          <hr>
        </div>
        <p class="hidden" id="act-workid"></p>
        <h1 id="actitle"></h1>
        <p id="actemp"></p>
        <div class="head-button pull-right">
          <select class="selectpicker " data-width="170px" data-style="actselect" title="Set actions" id="act-actions">
            <option  class="actoption" data-icon="fa fa-envelope" value="1"> Send a message</option>
            <option class="actoption" data-icon="fa fa-calendar" value="2"> Request a reschedule</option>
            <option class="actoption" data-icon="fa fa-times" value="3"> Dismiss this job</option>
          </select>
        </div>
      </div>
      <div class="timeline-body">
        <div class="jtitle">
         <p id="actdesc">
         </p>
       </div>
       <div class="row contents">
        <div class="col-md-6">
          <div class="sched">
           <p id="startDay"></p>
           <h1 id="startTime"></h1>
           <p>Starts at</p>
         </div>
         <div class="sched head-center">
          <h1><i class="fa fa-long-arrow-right" aria-hidden="true"></i></h1>
        </div>
        <div class="sched">
          <p id="endDay"></p>
          <h1 id="endTime"></h1>
          <p>Ends at</p>
        </div>
      </div>
      <div class="row contents">
        <div class="col-md-6 cont-col">
          <div class="head-time">
            <h1 id="actsal"></h1>
            <p>You will receive</p>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div id="actgmap" style="height:300px;"></div>
      </div>
      <div class="col-md-6 cont-col">
        <h1 id="actaddress"></h1>
        <p>Located at</p>
      </div>
      <div class="col-md-3 cont-col cont-col-center ">
        <h1 id="actdistance"></h1>
        <p>Distance from current location</p>
      </div>
      <div class="col-md-3 cont-col">
        <h1 id="acttime"></h1>
        <p>Approximate travel time</p>
      </div>
    </div>
  </div>
</div>
</div>

<h1>Upcoming Jobs</h1>
<p id="upcoming-p">No items to display.</p>
<ul id="upcoming-timeline" class=" timeline"></ul>
</div>
@endsection

@section('js')
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places"></script>
<script src="/sweetalert/sweetalert.min.js"></script>
<script src="/calendar/moment.min.js"></script>
<script src="/js/star-rating.js" type="text/javascript"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/bootstrap-select.js"></script>
<script type="text/javascript" src="/js/datetimepicker.min.js"></script>
<script src="/js/app-dashboard.js"></script>

@endsection
