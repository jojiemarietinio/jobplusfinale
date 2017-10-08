<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobPlus</title>
    <!-- CSS -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bootstrap/css/empfinale.css">
    <link rel="stylesheet" href="/bootcard/css/bootcards-desktop.min.css">
    <link rel="stylesheet" href="/bootstrap/bootstrap-select.min.css">
    <link rel="stylesheet" href="/sweetalert/sweetalert.css">
    <link href="/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    @yield('css')
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">for Employers</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
     <div id="navbar" class="collapse navbar-collapse">
            <!-- <ul class="nav navbar-nav">
                <li><a href="/employer/dashboard">Home</a></li>
                <li><a href="/messages">Messages @include('messenger.unread-count')</a></li>
                <li><a href="/messages/create">Create New Message</a></li>
            </ul> -->
            <ul class="nav navbar-nav">
        <li><a href="{{route('emp/dashboard')}}"><i class="fa fa-lg fa-clock-o" aria-hidden="true"></i> Schedule</a></li>
        <li><a href="{{route('emp/job/post')}}"><i class="fa fa-lg fa-pencil" aria-hidden="true"></i>Job Postings</a></li>
        <li><a href="{{route('emp/applications')}}"><i class="fa fa-handshake-o" aria-hidden="true"></i>Applicants</a></li>
      </ul>

     <ul class="nav navbar-nav navbar-right">   
      <li><a href="/messages">Messages</a></li>    
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="{{Auth::user()->profile->avatar}}" style="width:25px;height:25px;border-radius:50%;"> <!-- <i class="fa fa-lg fa-user-circle" aria-hidden="true"></i> -->{{Auth::user()->profile->fname}} {{ Auth::user()->profile->lname}}<span class="caret"></span></a>
          <ul class="dropdown-menu dropdown-cart" role="menu">
              <li>
                <a href="{{url('/applicant/dashboard')}}"><span>Switch to Applicant</span></a>
                <a href="{{url('/get/employer/profile')}}"><span>Profile</span></a>
                <a href="{{url('/employer/jobwallet')}}"><span>Job+ Wallet</span></a>
              </li>
              <li class="divider"></li>
              <li><a class="" href="{{url('/logout')}}">Signout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
    <hr>
    <div class="row">
        <!--left-->
        <aside class="col-sm-3 col-md-2">
            <a href="messages/create" class="btn btn-danger btn-sm btn-block" role="button"><i class="glyphicon glyphicon-edit"></i> Compose</a>
            <hr>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="/messages"><span class="badge pull-right"></span> Inbox </a></li>
               
            </ul>
            <hr>
           
        </aside>
        <!--main-->
        <div class="col-sm-9 col-md-10">
            <!-- tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
                </span>Primary</a></li>
                
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="inbox">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <!-- inbox item -->
                            <tr>
                                @yield('content')
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 foot ">
                    <h1> JobPlus </h1>
                    <ul>
                        <li><a href="#"><h1>#<b>Where opportunity meets people</b></h1></a> </li>
                    </ul>
                </div>
              
                <div class="col-lg-3  col-md-2 col-sm-4 col-xs-6 foot foot-social">
                   <ul class="social">
                    <li> <a href="#"> <i class=" fa fa-facebook">   </i> </a> </li>
                    <li> <a href="#"> <i class="fa fa-twitter">   </i> </a> </li>
                    <li> <a href="#"> <i class="fa fa-google-plus">   </i> </a> </li>
                    <li> <a href="#"> <i class="fa fa-pinterest">   </i> </a> </li>
                    <li> <a href="#"> <i class="fa fa-youtube">   </i> </a> </li>
                </ul>
            </div>
            <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 foot">
            </div>
            <div class="col-lg-2  col-md-3 col-sm-6 col-xs-12 ">
              
            </div>
        </div>
        <!--/.row--> 
    </div>
    <!--/.container--> 
</div>
<!--/.footer-->

<div class="footer-bottom">
    <div class="container">
        <p class="pull-left"> JobPlus. All right reserved. </p>
        <div class="pull-right">
            <ul class="nav nav-pills payments">
                <li><i class="fa fa-cc-visa"></i></li>
                <li><i class="fa fa-cc-mastercard"></i></li>
                <li><i class="fa fa-cc-amex"></i></li>
                <li><i class="fa fa-cc-paypal"></i></li>
            </ul> 
        </div>
    </div>
</div>
<!--/.footer-bottom--> 
</footer>
</body>
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootcard/js/bootcards.min.js"></script>
@yield('js')
</html>