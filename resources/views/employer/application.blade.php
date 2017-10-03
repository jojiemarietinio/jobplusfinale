@extends('masters.EmpPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/employer-application.css">
@endsection
@section('body')
@include('employer.modals.jobpage.jobposting')
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
    <h1>Pending Applications</h1>
    <hr>
    <div id="appfeeds"></div>
</div>

@endsection

@section('js')
<script src="/calendar/moment.min.js"></script>
<script src="/sweetalert/sweetalert.min.js"></script>
<script src="/js/employer-application.js"></script>
@endsection
