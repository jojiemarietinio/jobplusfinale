<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>JobPlus</title>
        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
		    <link rel="stylesheet" href="/css/form-elements.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/bootcard/css/bootcards-desktop.min">
        
        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
        @yield('css')
</head> 

<body id="parent">
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
        <div class="col-md-4">
           <a class="sub-nav noti" href="#"><i class="fa fa-bell" aria-hidden="true"></i></a>
        </div>
         <div class="col-md-8 dropdown pull-right">
            <a class="sub-nav" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">
             <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->username }} 
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{url('/logout')}}">Logout</a></li>
            </ul>
        </div>
        </ul>
       </div>
       </div>
    </div>
   </div>
  @yield('body')

    <footer class="footer">
      <div class="container">
        <div class="col-md-4 foot">
          <h1>JobPlus</h1>
          <p >Were amazing happens.</p>
        </div>
      </div>
    </footer>
    
        <!-- Javascript -->
        <script src="/js/scripts.js"></script>
        <script src="/js/custom.js"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <script src="/bootcard/js/bootcards.min.js"></script>
        @yield('scripts')

    </body>

</html>