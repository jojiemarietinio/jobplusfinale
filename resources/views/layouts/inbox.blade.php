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


<div class="container" style="padding-top:30px">
    <div class="row">
        <div class="col-sm-6">
             <div id="tb-testimonial" class="testimonial testimonial-warning">
                <div class="testimonial-section">
                   <p><h3>{{ $message->body }}</h3></p>
                </div>
                <div class="testimonial-desc">
                    <img src="{{ $message->user->profile->avatar}}"
             alt="{{ $message->user->name }}" class="img-circle" style="width:60px;height:60px;border-radius:50%;">
                    <div class="testimonial-writer">
                        <div class="testimonial-writer-name">{{ $message->user->profile->lname }} {{ $message->user->profile->fname }}</div>
                        <div class="testimonial-writer-designation">{{ $message->created_at->diffForHumans() }}</div>
                        <!-- <a href="#" class="testimonial-writer-company">Touch Base Inc</a> -->
                    </div>
                </div>
            </div>   
        </div>
    </div>
</div>



</body>
</html>