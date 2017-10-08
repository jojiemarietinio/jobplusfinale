<!DOCTYPE html>
<html>
<head>
    <title>Chats</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/chats.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div class="col-lg-4 col-lg-offset-4">
        <h1 id="greeting">Hello, <span id="username">{{Auth::user()->profile->fname}}</span></h1>

        <div id="chat-window" class="col-lg-12">

        </div>
        <div class="col-lg-12">
            <div id="typingStatus" class="col-lg-12" style="padding: 15px"></div>
            <input type="text" id="text" class="form-control col-lg-12" autofocus="" onblur="notTyping();">
            <input id="button" type="button" value="send" onclick="sendMessage();" />
        </div>
    </div>

    <script src="{{URL::asset('js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{URL::asset('js/chats.js')}}"></script>
</body>
</html>