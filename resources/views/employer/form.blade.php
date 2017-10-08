@extends('masters.EmpPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/employer-jobpost.css">
<link rel="stylesheet" href="/css/malot-timepicker.css">
@endsection

@section('body')
@include('employer.modals.jobpage.jobposting')
@include('employer.modals.jobpage.recommended')

    <div class="container">
        <div class="gateway--info">
            <div class="gateway--desc">
                @if(session()->has('message'))
                    <p class="message">
                        {{ session('message') }}
                    </p>
                @endif
                <p><strong>Order Overview !</strong></p>
                <hr>
                <p>Item : Yearly Subscription cost !</p>
                <p>Amount : ${{ $order->amount }}</p>
                <hr>
            </div>
            <div class="gateway--paypal">
                <form method="POST" action="{{ route('checkout.payment.paypal', ['order' => encrypt(mt_rand(1, 20))]) }}">
                    {{ csrf_field() }}
                    <button class="btn btn-pay">
                        <i class="fa fa-paypal" aria-hidden="true"></i> Pay with PayPal
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')  
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB6Q71RQFpX_9-0qQtuQgxe9EFmGmKIIc8&libraries=places"></script>
<script src="/bootstrap/bootstrap-select.js"></script>
<script src="/calendar/moment.min.js"></script>
<script src="/js/malot-timepicker.js"></script>
<script src="/sweetalert/sweetalert.min.js"></script>
<script src="/js/employer-jobpost.js"></script>
@endsection
