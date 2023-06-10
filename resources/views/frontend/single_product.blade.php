@extends('layouts.frontend.app')

@section('content')
<div class='page product pt-md-3 pt-0'>

    <div class="container mt-5 pt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class='text-decoration-none text-dark'>   {{  trans('product.home_page')  }} </a></li>
                <li class="breadcrumb-item active " aria-current="page">  <span class="text-main">    {{  trans('product.product_name')  }}  </span> </li>
            </ol>
        </nav>        
        <div class="rounded-3 shadow-sm p-3 border">
            <div class='heading d-flex '>
                <input type="hidden" id="ProductId" value="{{  $product->id }}">
                <div class="img">
                    <img src="{{asset('storage/uploads/products'.'/'. $product->avatar )}}" width='75px' height='75px' class='rounded' alt="">
                </div>
                <div class="title ms-3">
                    <h1 class='h3 mb-1'>
                         <h2>{{  $product->name }}</h2>
                        
                    <p class='mb-0 text-muted'>
                     {{ $product->desc }}                 
                          </p>

                    <div class="avalible-system mt-3">
                        <span>    {{  trans('product.available_system')  }}:</span>

                        <div class="systems d-flex align-items-center mt-2">
                           @foreach ($product->tags as $tag )
      
                            <div class='border p-1 px-3 d-inline-block rounded-pill fs-14px me-2'> {{ $tag->name  }}</div>
                           @endforeach
                          
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mt-3 row g-0" id="myTab" role="tablist">
                <li class="nav-item col" role="presentation">
                    <button class="nav-link active m-0 border-0 w-100 text-center" id="product-desc" data-bs-toggle="tab" data-bs-target="#product-desc-pane" type="button" role="tab" aria-controls="product-desc-pane" aria-selected="true">
                        {{  trans('product.desc_product')  }}
                    </button>
                </li>
                <li class="nav-item col" role="presentation">
                    <button class="nav-link m-0 border-0 w-100 text-center" id="feature-product-tab" data-bs-toggle="tab" data-bs-target="#feature-product-tab-pane" type="button" role="tab" aria-controls="feature-product-tab-pane" aria-selected="false">
                          {{  trans('product.advantage')  }}
                    </button>
                </li>
            </ul>
            <div class="tab-content p-3" id="myTabContent">
                <div class="tab-pane fade show active" id="product-desc-pane" role="tabpanel" aria-labelledby="product-desc" tabindex="0">
                    <h3 class='my-3'>      {{  trans('product.desc_product')  }} </h3>
                    <p class='lead fs-14px'>
                          {{ $product->descLong }}    
                    </p>
                </div>
                <div class="tab-pane fade" id="feature-product-tab-pane" role="tabpanel" aria-labelledby="feature-product-tab" tabindex="0">
                    <h3 class='my-3'>    {{  trans('product.advantage')  }} </h3>
                    <div class="row g-3">
                        @foreach ($product->advantages as $advantage )
                            
                       
                        <div class="col-md-4">
                            <div class='box rounded-3 border p-3 bg-white'>
                                <img src="{{ asset('assets/images/Icon-1.png') }}" class='w-auto img-fluid mb-3' alt="">
                                <h3 class='mb-3'>  {{ $advantage->advantage }} </h3>
                                <p>
                                    {{ $advantage->desc_advantage }} 
                                </p>
                            </div>
                        </div>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="border p-4 shadow-sm mt-3 rounded">
            <div class="heading d-flex align-items-center justify-content-between">
                <div id="price-box">
                    <div class="price-before">
                      <span>Price:</span>
                      <span > <span id="price-before">{{ $product->price_new }}$</span></span>
                    </div>
                    <div class="price-after">
                      {{-- <span>Price after coupon:</span> --}}
                      <span id="price-after"></span>
                    </div>
                    @if(isset($taxId))
                    <div class="tax">
                        <span>tax:</span>     
                        <span id="tax"> {{$taxId}}</span>
                     </div>
                     @endif
                     <hr>
                     <div class="price">
                        <span>Total:</span>
                        <span id="total">

                            @php 
                              if(isset($taxId)){
                                $taxAmount =  $product->price_new * ($taxId/ 100);
                                $total  =  $product->price_new  + $taxAmount ;
                                echo $total.'$';
                              }else{
                                echo $product->price_new.'$';
                              }   
                            @endphp
                        </span>
                      
                      </div>
                  </div>
               

            </div>

            <div class="coupon mt-4">
                <h6>  {{  trans('product.discount_code')  }}</h6>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class='form-control input-coupon' id="couponCode">

                        <div class="applay-coupon mt-3">
                            <button class='btn btn-outline-danger p-3 py-2'  id="checkCoupon" type="button">  {{  trans('product.apply_discount')  }}</button>
                             <div id="error-message" ></div>  
                             <div  id="info"></div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="heading d-flex align-items-center justify-content-between">
                <h5 class="mb-0">  </h5>
                   <button class='btn btn-outline-danger p-3 py-2'  type="button">
                    <a href="{{ route('checkout', ['id'=>$product->id]) }}"> {{  trans('product.payment_page')  }}</a> </button>
            </div>
              
              
        </div>
    </div>

</div>
<style>
    #error-message {
        color: gray;
        font-size: 14px;
        margin-top: 10px;
        background-color: #F2DEDE;
    }

    #error-message p {
        margin: 5px;
        padding: 10px;
    }
</style>
@endsection


@push('js')
    <script>
  var input = document.getElementById("price-after");
  var tax = $("#tax").text();
 $('#checkCoupon').click(function() {
    var couponCode = $('#couponCode').val();
    var ProductId = $('#ProductId').val();
    
    $.ajax({
        // url: '/dashboard/check-coupon',
       url: '{{ route("dashboard.checkCoupon") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            coupon_code: couponCode,
            ProductId:ProductId,
          
        },
        success: function(response) {
            console.log(response);
            if (response.valid) {
               var  message = 'Coupon code is valid!';

                   $('#info').html('<p class="alert alert-info">' + message + '</p>');          
                   $('#price-after').html('<span> discount :' + response.value + '</span>');
                   /////////////calculate taxes
                   var taxAmount = response.price * (tax/ 100);
                   var  num = response.price + taxAmount ;
                 var total = num.toFixed(3)
                   $('#total').html('<span>' + total + '$</span>');
            } else{
                if(response.limit){
                    var  message = 'Coupon code has already been used the maximum number of times'
                $('#error-message').html('<p>' + message + '</p>');
                }else{
                    var  message = 'Coupon code is not valid!';
                $('#error-message').html('<p>' + message + '</p>');
                }
              
            }
           
    },
        error: function() {
            alert('Error checking coupon code.');
        }
    });
});


    </script>
@endpush



