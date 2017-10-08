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
    <link rel="stylesheet" href="/bootstrap/bootstrap-select.min.css">
    <link rel="stylesheet" href="/sweetalert/sweetalert.css">
    <link href="/css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/css/inbox.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/css/fontawesome-stars.css" media="all" rel="stylesheet" type="text/css" />

</head>
<body>
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
                                @yield('body')
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>