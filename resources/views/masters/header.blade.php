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
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/bootstrap/bootstrap-select.min.css">
    </head> 
<body>
<div class="page-container">
    <!-- top navbar -->
<div class="page-container">
  <div class="row">
    <!-- top navbar -->
   <div class="navbar navbar-default" role="navigation">
       <div class="container">
        <div class="navbar-header">
           <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
             <span class="icon-bar"></span>
           </button>
           <a class="navbar-brand " href="#">JobPlus</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
         <div class="dropdown ">
            <a class="sub-nav-home" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
              <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->username }} 
            </a>
        <ul class="dropdown-menu">
            <li><a href="#">Switch to Employer</a></li>
            <li><a href="{{url('/logout')}}">Logout</a></li>
        </ul>
        </div>
        </ul>

       </div>
       </div>
    </div>
   </div>
   <div class="row">
   @yield('css')
   @yield('content')
</div>

   </div>
  
        <!-- Javascript -->
        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <script src="/bootstrap/bootstrap-select.js"></script>
        <script src="/js/scripts.js"></script>
        @yield('js')
    </body>

</html>