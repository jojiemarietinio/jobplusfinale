@extends('masters.primary')
@section('css')
 	<link rel="stylesheet" href="/css/custom.css">
 @endsection
@section('body')
  <div class="container">
      <div class="row row-offcanvas row-offcanvas-left">
        <!-- sidebar -->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <ul class="nav nav-primary">
              <li><a href="{{route('app/dashboard')}}"><i class="fa fa-calendar nav-icon" aria-hidden="true"></i> Job+ Schedule</a></li>
              <hr>
              <li><a href="{{ route('app/job/search') }}"><i class="fa fa-suitcase nav-icon" aria-hidden="true"></i> Job+ Postings </a></li>
              <hr>
              <li><a href="#"><i class="fa fa-credit-card-alt nav-icon" aria-hidden="true"></i> Job+ Wallet </a></li>
              <hr>
              <li><a href="#"><i class="fa fa-bookmark nav-icon" aria-hidden="true"></i> Bookmarks</a></li> 
              <hr>
              <li><a href="#"><i class="fa fa-archive nav-icon" aria-hidden="true"></i> Logs</a></li>
              <hr>
              <li><a href=""><i class="fa fa-user nav-icon" aria-hidden="true"></i> Profile</a></li>                
            </ul>
        </div>
        <!-- main area -->
        <div class="col-xs-12 col-sm-9 dash-content">
        <br>
              <div class="well well-md">
                <h2>Job Searching</h2>
                <p>Here we will assist you to find a job that fits your needs.</p>
              </div>
  <div class="row">
    <section>
     <form role="form" action="{{ route('app/job/result') }}" method="post" class="registration-form">
    {{ csrf_field() }}
        <div class="wizard">
            <div class="wizard-inner">
                <div class="jobpost-connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <span class="round-tab">
                               <i class="fa fa-wrench" aria-hidden="true"></i>
                            </span>
                        </a>
                        <p>Step 1</p>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <span class="round-tab">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                            </span>
                        </a>
                     <p>Step 2</p>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Step 3">
                            <span class="round-tab">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </span>                     
                        </a>
                          <p>Step 3</p>
                    </li>
                </ul>
            </div>
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h2>Categories and Skills </h2>
                         <p>Select your desired category and skills to start with.</p>
                              <div class="form-box">
                                <div class="col-sm-12">
                                <div class="panel">
                                <div class="panel-heading"><h3>Housekeeping</h3></div>
                                <div class="panel-body">
                                    <ul class="input-list">
                                         <li class="setup-skills">
                                        <div class="pure-checkbox">@foreach ($housekeeping as $house)
                                      <input id="{{$house->name}}" name="housekeeping[]" type="checkbox" value="{{$house->skill_id}}">
                                     <tag>{{$house->name}}</tag>
                                     @endforeach
                                        </div>
                                        </li>
                                    </ul>
                                </div>
                                </div>
                                <div class="panel-heading"><h3>Construction</h3></div>
                                <div class="panel-body">
                                    <ul class="input-list">
                                         <li class="setup-skills">
                                        <div class="pure-checkbox">
                                             @foreach ($construction as $cons)
                                    <input id="{{$cons->name}}" name="construction[]" type="checkbox" value="{{$cons->skill_id}}">
                                    <tag>{{$cons->name}}</tag>
                                    @endforeach
                                        </div>
                                        </li>
                                    </ul>
                                </div>
                                 <hr>
                                <div class="panel-heading"><h3>Personel</h3></div>
                                <div class="panel-body">
                                    <ul class="input-list">
                                         <li class="setup-skills">
                                        <div class="pure-checkbox">
                                            @foreach ($personel as $per)
                                                               <input id="{{$per->name}}" name="personel[]" type="checkbox" value="{{$per->skill_id}}">
                                                            <tag>{{$per->name}}</tag>
                                             @endforeach
                                        </div>
                                        </li>
                                    </ul>
                                </div>
                                <hr>
                                 <div class="panel-heading"><h3>Maintenance</h3></div>
                                <div class="panel-body">
                                    <ul class="input-list">
                                         <li class="setup-skills">
                                        <div class="pure-checkbox">
                                              @foreach ($maintenance as $main)
                                    <input id="{{$main->name}}" value="{{$main->skill_id}}" name="maintenance[]" type="checkbox">
                                    <tag>{{$main->name}}</tag>
                                 @endforeach
                                        </div>
                                        </li>
                                    </ul>
                                </div>
                                <hr>
                               
                               </div>
                            </div>
                            <hr>
                        <ul class="list-inline ">
                            <li><button type="button" class="btn btn-primary next-step">Next<span class="glyphicon glyphicon-menu-right"></span></button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h2>Location</h2>
                        <p>Search jobs nearby you.</p>
                           <div class="form-box">
                    </div>
                        <ul class="list-inline">
                            <li><button type="button" class="btn btn-primary prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Next</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h2>Basic Filters</h2>
                        <p>Filter your results.</p>
                <br> <br>
                                <h3>Salary</h3>
                                <div class="col-sm-6">
                                <p>Minimum</p>
                                   <div class="range range-danger">
                        <input type="range" name="min" min="250" max="10000" step="250" value="50" onchange="minimum.value=value">
                        <output id="minimum">50</output>
                      </div>
                     </div>
                     <div class="col-sm-6">
                        <p>Maximum</p>
                                   <div class="range range-danger">
                        <input type="range" name="max" min="250" max="10000" step="250" value="50" onchange="maximum.value=value">
                        <output id="maximum">50</output>
                      </div>
                                </div>

                                <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                <br>
                                <h3>Date Posted</h3>
                               <ul class="input-list">
                                         <li class="setup-skills">
                                        <div class="pure-checkbox">
                                            <input id="posted1" name="posted1" type="checkbox">
                                            <tag>Today</tag>
                                        </div>
                                        </li>
                                          <li class="setup-skills">
                                        <div class="pure-checkbox">
                                            <input id="posted2" name="posted2" type="checkbox">
                                            <tag>days ago</tag>
                                        </div>
                                        </li>
                                         <li class="setup-skills">
                                        <div class="pure-checkbox">
                                            <input id="posted3" name="posted3" type="checkbox">
                                            <tag>weeks ago</tag>
                                        </div>
                                        </li>
                                 </ul>
                                 </div>
                                 </div>
                                 <hr>
                        <ul class="list-inline ">
                            <li><button type="button" class="btn btn-primary prev-step">Previous</button></li>
                            <li><button type="submit" class="btn btn-primary btn-info-full next-step">Search</button></li>
                        </ul>
                    </div>
                </div>
                     </div>
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
            </section>

    </div>
</div></div>
     </div>
@stop

 <script src="/js/jquery-1.11.1.min.js"></script>