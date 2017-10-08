@extends('masters.header')

@section('content')
<div class="container">
    <div class="row">
            <div class="panel panel-default">
          
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                <h2> Welcome, {{ Auth::user()->username }} </h2>
                </div>
                <hr>
                <div class="col-md-12 cover-top">
                <div class="col-md-6">
                    <div class="cover-hero"><img class="cover-pic pull-right" src="/img/builder.png"/> </div>
                </div>
                <div class="col-md-6">
                <div class="cover-app">
                <h1>Become one of thousands of people that gets hired everyday! </h1>
                    <a id="abutton" href="{{ route('app/dashboard') }}">
                        <button class="btn btn-primary">I want to Work</button>
                    </a>
                </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-12 cover-bottom">
                <div class="col-md-6">
                <div  class="cover-app-bott">
                 <h1>Millions of people waiting for you to hire! </h1>
                    <a href="{{ route('emp/dashboard') }}">
                        <button class="btn btn-primary">I want to Hire People</button>
                    </a>
                </div>
                </div>
                <div class="col-md-6 cover-bottom">
                   <div class="cover-hero-bott"><img class="cover-pic bott pull-left" src="/img/employer.png"/> </div>
                 </div>
                </div>
                </div>
       
    </div>
</div>


@endsection

