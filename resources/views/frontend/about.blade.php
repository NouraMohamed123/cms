
@extends('layouts.frontend.app')
@section('content')

<div class='page about-us py-md-5 py-0'>

    <div class="container mt-5 pt-5">
        <div class='row align-items-center'>
           <div class="col-md-7">
                <h1>
                     @if (App::getLocale() == 'en')
                    {{ $setting['about_title_en'] ?? ''}}
                    @elseif (App::getLocale() == 'ar')
                    {{ $setting['about_title_ar'] ?? ''}}
                    @endif
                </h1>
                <p>
                    @if (App::getLocale() == 'en')
                    {{ $setting['about_content_en'] ?? ''}}
                    @elseif (App::getLocale() == 'ar')
                    {{ $setting['about_content_ar'] ?? ''}}
                    @endif
                 
                </p>
           </div>
           <div class="col-md-5">
               <div class="img position-relative">
                @php
                if(isset($setting['avatar']))
                    $logo = asset('storage/uploads/abouts') . '/' . $setting['avatar'];
            @endphp

            <img src="{{ $logo  ??  asset('assets/images/about_img.jpg')}}" alt="" class='img-fluid rounded'>

               </div>
           </div>
           
        </div>        
    </div>

</div>

@endsection