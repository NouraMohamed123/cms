@extends('layouts.frontend.app')

@section('content')
<div class='page about-us py-md-5 py-0'>

    <div class="container mt-5 pt-5">
        <div class='row align-items-center'>
     
        @foreach ($products as $product)
            <div class="col-md-4">
                <a href="{{route('product.show',$product->id)}}" style="    text-decoration: none;
                    color: #C00000;
                }">
                <div class="card mb-4 box-shadow">    
                    
                    <img class="card-img-top" src="{{ asset('storage/uploads/products/' . $product->avatar) }}" alt="" style="height: 225px; width: 100%; display: block;">
                    <div class="card-body">
                        <p class="card-text">{{$product->name}}</p>
                        <span>{{$product->price_new}}</span>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                {{$product->desc}}  
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>
        @endforeach
    </div>
    </div>
</div>
@endsection