
@extends('masters.EmpPrimary')
@section('css')
<link rel="stylesheet" href="/bootstrap/css/employer-jobpost.css">
<link rel="stylesheet" href="/css/malot-timepicker.css">
@endsection


@section('body')
@include('employer.modals.jobpage.jobposting')
@include('employer.modals.jobpage.recommended')

    <div class="ez-payment-info-left pull-left">
    <form data-stripe-form="handleStripe" name="billingForm">
      <div class="row">
        <div class="form-group col-xs-6">
          <label for="card-number" class="control-label">Card number:</label>
          <div class="form-control-wrapper">
            <input type="text"
                    name="number"
                    id="card-number"
                    class="form-control ez-input-standard"
                    required="required"
                    data-ng-model="number"
                    payments-validate="card"
                    payments-format="card"
                    payments-type-model="type"
                    data-ng-class="billingForm.number.$card.type"
                    placeholder="Card Number"/>
            <span class="material-input"></span>
          </div>

          <div class="ez-error" data-ng-if="billingForm.number.$invalid && billingForm.number.$touched" >
              <span data-ng-if="billingForm.number.$viewValue != '' && billingForm.number.$viewValue">Card number is invalid.</span>
              <span data-ng-if="billingForm.number.$viewValue == '' || !billingForm.number.$viewValue">Card number is required.</span>
          </div>
        </div>
        <div class="form-group col-xs-4 col-xs-offset-1">
          <label for="expire" class="control-label">Expires:</label>
          <div class="form-control-wrapper">
            <input type="text"
                  name="expire"
                  id="expire"
                  maxlength="9" 
                  class="form-control ez-input-standard"
                  required="required"
                  data-ng-model="expiry"
                  payments-validate="expiry"
                  payments-format="expiry"
                  placeholder="MM/YYYY">
            <span class="material-input"></span>
          </div>
          <div class="ez-error" data-ng-if="billingForm.expire.$invalid && billingForm.expire.$touched" >
              <span data-ng-if="billingForm.expire.$viewValue != '' && billingForm.expire.$viewValue">Expiry date is invalid.</span>
              <span data-ng-if="billingForm.expire.$viewValue == '' || !billingForm.expire.$viewValue">Expiry date is required.</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-xs-6">
          <label for="card-name" class="control-label">Name on card:</label>
          <div class="form-control-wrapper">
            <input type="text"
                    name="cardname"
                    data-ng-model="cardname"
                    id="card-name"
                    class="form-control ez-input-standard"
                    required="required">
            <span class="material-input"></span>
          </div>
          <div class="ez-error"
                   data-ng-messages="billingForm.cardname.$error"
                   data-ng-if="billingForm.cardname.$touched">
            <span data-ng-message="required">
                Name on card is required.
            </span>
        </div>
        </div>
        <div class="form-group col-xs-4 col-xs-offset-1">
          <label for="csc" class="control-label">Card security code:</label>
          <div class="form-control-wrapper">
            <input type="text"
                    name="cvc"
                    id="cvc"
                    class="form-control ez-input-standard"
                    required="required"
                    data-ng-model="cvc"
                    payments-validate="cvc"
                    payments-type-model="type"
                    maxlength="4"
                    data-ng-pattern="[0-9]"
                    placeholder="●●●●">
            <span class="material-input"></span>
            <img id="info"
            src="images/info-gray.png"
            alt="info"
            uib-tooltip-html="htmlTooltip"
            tooltip-placement="right"
            tooltip-class="customClass">
            <div class="panel hidden">
              <img src="images/card-template.png" alt="Card template">
            </div>
          </div>
          <div class="ez-error" data-ng-if="billingForm.cvc.$invalid" >
              <span data-ng-if="billingForm.cvc.$viewValue != '' && billingForm.cvc.$viewValue">Card security code is invalid.</span>
              <span data-ng-if="(billingForm.cvc.$viewValue == '' || !billingForm.cvc.$viewValue) && billingForm.cvc.$touched">Card security code is required.</span>
          </div>
        </div>
      </div>
      <div class="row">
        <button type="submit"
                data-ng-disabled="billingForm.$invalid || billingForm.$pristine"
                class="btn btn-success btn-raised pull-right">
                Active your Plan
        </button>
      </div>
    </form>
  </div>
  @endsection

@section('js')
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootcard/js/bootcards.min.js"></script>
<script src="/bootstrap/bootstrap-select.js"></script>
<script src="/calendar/moment.min.js"></script>
<script src="/js/malot-timepicker.js"></script>
<script src="/sweetalert/sweetalert.min.js"></script>
<script type="/js/employer-dashboard.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBJJH4SL6eCDPu7N5C-2XcBt8jpZJeMyQ&libraries=places"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
     // This identifies your website in the createToken call below
     Stripe.setPublishableKey(STRIPE_KEY);
     // ...
</script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
@endsection
