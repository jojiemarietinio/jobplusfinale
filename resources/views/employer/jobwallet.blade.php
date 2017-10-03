@extends('masters.EmpPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/dashboard.css">
@endsection

<script language="JavaScript">
      function change() {
          document.getElementById('display_credit').innerHTML = "30"
      }
        function change1() {
          document.getElementById('display_credit').innerHTML = "50"
      }
      function change2() {
          document.getElementById('display_credit').innerHTML = "100"
      }
</script>
@section('body')
@include('employer.modals.jobpage.jobposting')
@include('employer.modals.jobpage.recommended')
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
         <div class="row row-offcanvas row-offcanvas-left">
      
        <!-- main area -->

        <div class="col-xs-12 dash-content">
        <br><br>
          <H1><b>JOB WALLET</b></H1>
          <div class="btn btn-primary" id="display_credit" size="100px"></div>
          <br><br>

          <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
             <h4> Post Credit A </h4>
            </div>
            <div class="panel-body">
             <form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
             <center>
             <p><b><h1>30</h1></b></p>
             <p><h2>Credits</h2></p>
            <br><br>
            <p>Php 50.20 <br>
            (Php 1.67/credit)</p>
            </center>
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="upload" value="1">
            <input type="hidden" name="business" value="jobplusAdmin@gmail.com">
                    <!-- Begin First Item -->
            <input type="hidden" name="quantity_1" value="1">
            <input type="hidden" name="item_name_1" value="Post Credit">
            <input type="hidden" name="item_number_1" value="Post Credit A">
            <input type="hidden" name="amount_1" value="50.20">
            <input type="hidden" name="currency_code" value="PHP">
           
            </div>
            <div class="panel-footer">
            <center>
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" onclick= "change()" id="postA" border="0" name="upload" alt="Make payments with PayPal - it's fast, free and secure!" width="120" height="30">
            </center>
            </div>
             </form>
          </div>
          </div>

          <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
             <h4> Post Credit B </h4>
            </div>
            <div class="panel-body">
             <form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
             <center>
             <p><b><h1>50</h1></b></p>
             <p><h2>Credits</h2></p>
            <br><br>
            <p>Php 63.36 <br>
            (Php 1.27/credit)</p>
            </center>
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="upload" value="1">
            <input type="hidden" name="business" value="jobplusAdmin@gmail.com">
                    <!-- Begin First Item -->
            <input type="hidden" name="quantity_1" value="1">
            <input type="hidden" name="item_name_1" value="Post Credit">
            <input type="hidden" name="item_number_1" value="Post Credit B">
            <input type="hidden" name="amount_1" value="63.36">
            <input type="hidden" name="currency_code" value="PHP">
           
            </div>
            <div class="panel-footer">
            <center>
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" onclick= "change1()" id="postA" border="0" name="upload" alt="Make payments with PayPal - it's fast, free and secure!" width="120" height="30">
            </center>
            </div>
             </form>
          </div>
          </div>

          <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
             <h4> Post Credit C </h4>
            </div>
            <div class="panel-body">
             <form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
             <center>
             <p><b><h1>100</h1></b></p>
             <p><h2>Credits</h2></p>
            <br><br>
            <p>Php 150.00<br>
            (Php 1.50/credit)</p>
            </center>
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="upload" value="1">
            <input type="hidden" name="business" value="jobplusAdmin@gmail.com">
                    <!-- Begin First Item -->
            <input type="hidden" name="quantity_1" value="1">
            <input type="hidden" name="item_name_1" value="Post Credit">
            <input type="hidden" name="item_number_1" value="Post Credit C">
            <input type="hidden" name="amount_1" value="150.00">
            <input type="hidden" name="currency_code" value="PHP">
           
            </div>
            <div class="panel-footer">
            <center>
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" onclick= "change2()" id="postA" border="0" name="upload" alt="Make payments with PayPal - it's fast, free and secure!" width="120" height="30">
            </center>
            </div>
             </form>
          </div>
          </div>
          <center>
            <p>Save money and get free bonus credits when you buy in bulk.</p>
          </center>
        </div>
        </div>
    </div>
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
 <script src="/js/employer-dashboard.js"></script>
@endsection
