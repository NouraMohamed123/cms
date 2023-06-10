@extends('layouts.dashboard.app')

@section('content')


    <div class="d-flex align-items-center justify-content-between mb-3">
        <ol class="breadcrumb breadcrumb-dot text-muted fs-6 fw-semibold">
            <li class="breadcrumb-item pe-3 "><a href="#" class="pe-3 text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item pe-3"><a href="#" class="pe-3 text-muted">الاعدادات</a></li>
            <li class="breadcrumb-item pe-3 text-primary"> الاعدادات العامة </li>
        </ol>
    </div>


    <div class="card">
        <div class="card-body fs-6 p-5 text-gray-700">

            <form  action="{{ route('dashboard.settings.store')  }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                @include('dashboard.partials._errors')

                <div class="row">
                    <div class="form-group mb-4 col-md-6">
                        <label for="generalName" class="form-label fw-bolder d-block text-capitalize">  {{trans('setting.name_ar')}} </label>
                        <input
                            id="generalName"
                            type="text"
                            name='site_name_ar'
                            class="form-control form-control-solid @error('site_name_ar') is-invalid @enderror"
                            value="{{ $setting['site_name_ar'] ?? ''}}">
                    </div>
                    <div class="form-group mb-4  col-md-6">  
                        <label for="generalName" class="form-label fw-bolder d-block text-capitalize">  {{trans('setting.name_en')}} </label>
                        <input
                            id="generalName"
                            type="text"
                            name='site_name_en'
                            class="form-control form-control-solid @error('site_name_en') is-invalid @enderror"
                            value="{{ $setting['site_name_en'] ?? ''}}">
                    </div>                               
               </div>
              
               <div class="row">
                <div class="form-group mb-4 col-md-6">
                    <label for="generalDesc" class="form-label fw-bolder d-block text-capitalize"> {{trans('setting.desc_ar')}}  </label>
                    <textarea name="site_desc_ar" class="form-control form-control-solid" id="generalDescAr" cols="30" rows="10">   {{ $setting['site_desc_ar'] ?? ''}}   </textarea>
                </div>
                <div class="form-group mb-4 col-md-6">
                    <label for="generalDesc" class="form-label fw-bolder d-block text-capitalize"> {{trans('setting.desc_en')}}  </label>
                    <textarea name="site_desc_en" class="form-control form-control-solid" id="generalDescEn" cols="30" rows="10">   {{ $setting['site_desc_en'] ?? ''}}   </textarea>
                </div>
               </div>
                
                <div class="form-group mb-4">
                    <label for="link_button" class="form-label fw-bolder d-block text-capitalize">  {{trans('setting.button_link')}}  </label>
                    <input
                        id="link_button"
                        type="text"
                        name='link_button'
                        class="form-control form-control-solid @error('link_button') is-invalid @enderror"
                        value="{{ $setting['link_button'] ?? ''}}" >
                </div>
                <div class="form-group mb-4">
                    <label for="link_button_end" class="form-label fw-bolder d-block text-capitalize">  {{trans('setting.link_button_end')}}  </label>
                    <input
                        id="link_button_end"
                        type="text"
                        name='link_button_end'
                        class="form-control form-control-solid @error('link_button_end') is-invalid @enderror"
                        value="{{ $setting['link_button_end'] ?? ''}}" >
                </div>

                <div class="form-group mb-4">
                    <label for="link_video" class="form-label fw-bolder d-block text-capitalize">  {{trans('setting.video_link')}} </label>
                    <input
                        id="link_video"
                        type="text"
                        name='link_video'
                        class="form-control form-control-solid @error('link_video') is-invalid @enderror"
                        value="{{ $setting['link_video'] ?? ''}}">
                </div>

                <div class="form-group mb-4">
                    <label for="taxes" class="form-label fw-bolder d-block text-capitalize">  {{trans('setting.taxes')}} </label>
                    <input
                        id="taxes"
                        type="number"
                        name='taxes'
                        class="form-control form-control-solid @error('taxes') is-invalid @enderror"
                        value="{{ $setting['taxes'] ?? ''}}">
                </div>

                <div class="row align-items-center mt-2 upload-img">
                    <div class="col-md-8">
                        <label for="formFile" class='d-block mb-1'> رفع شعار الموقع </label>
                        <input class="form-control" type="file" id="formFile" name="site_logo">
                    </div>
                    <div class="col-md-4 align-self-center">
                        @php
                            if(isset($setting['site_logo']))
                                $logo = asset('storage/uploads/setting') . '/' . $setting['site_logo'];
                        @endphp

                        <img src="{{ $logo  ??  asset('cp_files/assets/media/blank.svg')}}" class=' border rounded w-80px h-80px' style='object-fit: contain'>
                    </div>
                </div>


                <div class="text-end">
                    <button  class="px-20  mt-5 btn btn-primary btn-hover-rise me-5 fw-bolder">  حفظ  </button>
                </div>

            </form>


        </div>
    </div>
@endsection
