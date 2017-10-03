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
    <link rel="stylesheet" href="/bootstrap/css/appfinale.css">
    <link rel="stylesheet" href="/bootcard/css/bootcards-desktop.min.css">
     <link rel="stylesheet" href="/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="/bootstrap/bootstrap-select.min.css">
    <link href="/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    @yield('css')
</head>
<body>
@yield('body')
<footer>
    <div class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 foot ">
                    <h1> JobPlus </h1>
                    <ul>
                        <li> <a href="#"><h1>#<b>Where opportunity meets people</b></h1></a> </li>
                    </ul>
                </div>
                <div class="col-lg-2  col-md-2 col-sm-4 col-xs-6 foot ">
                 
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
@yield('js')
</html>