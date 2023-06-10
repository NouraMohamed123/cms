@extends('layouts.frontend.app')
@push('css')
<style>
.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
 
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
 
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (and change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
@endpush
@section('content')
<div class='page about-us py-md-5 py-0'>

<div class="container mt-5 pt-5">
 <div class='row align-items-center'>
<div class="row">
  <div class="col-75">
    <div class="container">
       <form action="{{ route('checkout.payment') }}" method="POST"  novalidate>
          @csrf
        @method('post')
      <input type="hidden" name="product_id" value="1">

        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input type="text" id="fname" name="name">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email" >
            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
            <input type="text" id="adr" name="address">
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city" >
             <label for="city"><i class="fa fa-institution"></i> country</label>
            <input type="text" id="country" name="country" >
            <div class="row">
              <div class="col-50">
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="NY">
              </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" placeholder="10001">
              </div>
            </div>
          </div>

           <div class="col-50">
                    <h4 class="mt-4">Payment Options</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_option" id="stripe" value="stripe" checked>
                        <label class="form-check-label" for="stripe">
                            Stripe
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_option" id="paypal" value="paypal">
                        <label class="form-check-label" for="paypal">
                            PayPal
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_option" id="paymob" value="paymob">
                        <label class="form-check-label" for="paymob">
                            Paymob
                        </label>
                    </div>
          </div>

        </div>
      
        <input type="submit" value="Continue to checkout" class="btn">
      </form>
    </div>
  </div>

  <div class="col-25">
    <div class="container">
      <h4>Cart
        <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
          <b>4</b>
        </span>
      </h4>
      <p><a href="#">Product 1</a> <span class="price">$15</span></p>
      <p><a href="#">Product 2</a> <span class="price">$5</span></p>
      <p><a href="#">Product 3</a> <span class="price">$8</span></p>
      <p><a href="#">Product 4</a> <span class="price">$2</span></p>
      <hr>
      <p>Total <span class="price" style="color:black"><b>$30</b></span></p>
    </div>
  </div>
</div>

</div>
</div>
</div>



@push('js')
     <script>
        // Show/hide payment forms based on selection
        $('input[type=radio][name=payment_option]').change(function() {
            if (this.value === 'stripe') {
                $('#stripe-form').removeClass('d-none');
                $('#paypal-form').addClass('d-none');
                $('#paymob-form').addClass('d-none');
            }
            else if (this.value === 'paypal') {
                $('#stripe-form').addClass('d-none');
                $('#paypal-form').removeClass('d-none');
                $('#paymob-form').addClass('d-none');
            }
            else if (this.value === 'paymob') {
                $('#stripe-form').addClass('d-none');
                $('#paypal-form').addClass('d-none');
                $('#paymob-form').removeClass('d-none');
            }
        });
    </script>
    @endpush
@endsection
   