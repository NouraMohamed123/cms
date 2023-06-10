@extends('layouts.dashboard.app')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <ol class="breadcrumb breadcrumb-dot text-muted fs-6 fw-semibold">
            <li class="breadcrumb-item pe-3 "><a href="#" class="pe-3 text-muted">الرئيسية</a></li>
            <li class="breadcrumb-item pe-3"><a href="{{ route('dashboard.products.index') }}" class="pe-3 text-muted">الاعضاء</a></li>
            <li class="breadcrumb-item pe-3 text-primary"> التعديل  </li>
        </ol>
    </div>
    <div class="card">
        <div class="card-body fs-6 p-5 text-gray-700">

            <form action="{{ route('dashboard.products.update', $product->id)  }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('dashboard.partials._errors')
                <div class="row">
                    <div class="form-group mb-4 col-md-6">
                        <label for="roleName" class="form-label fw-bolder d-block">  {{ trans('product_dasboard.name_ar') }}</label>
                        <input type="text" name='name' value="{{old('name',$product->getTranslation('name','ar')) }}" id="roleName" class="form-control form-control-solid" value="{{ old('name') }}">
                    </div>  
                    <div class="form-group mb-4 col-md-6">
                        <label for="roleName" class="form-label fw-bolder d-block">  {{ trans('product_dasboard.name_en') }}</label>
                        <input type="text" name='name_en' value="{{old('name_en', $product->getTranslation('name','en')) }}" id="roleName" class="form-control form-control-solid" value="{{ old('name') }}">
                    </div>                                    
               </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="roleName" class="form-label fw-bolder d-block">   {{ trans('product_dasboard.desc_ar') }} </label>
                        <textarea name="desc" id="desc"  cols="30" rows="3" class="form-control form-control-solid">{{old('desc', $product->getTranslation('desc','ar'))}}</textarea>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="roleName" class="form-label fw-bolder d-block"> {{ trans('product_dasboard.desc_en') }}   </label>
                        <textarea name="desc_en" id="desc_en"  cols="30" rows="3" class="form-control form-control-solid">{{ old('desc_en',$product->getTranslation('desc','en'))}}</textarea>
                    </div>                    
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="roleName" class="form-label fw-bolder d-block">   {{ trans('product_dasboard.desclong_ar') }}  </label>
                        <textarea name="descLong"  id="" cols="30" rows="4" class="form-control form-control-solid">{{ old('descLong',$product->getTranslation('descLong','ar'))}}</textarea>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="roleName" class="form-label fw-bolder d-block">   {{ trans('product_dasboard.desclong_en') }}  </label>
                        <textarea name="descLong_en" id="" cols="30" rows="4" class="form-control form-control-solid">{{ old('descLong_en',$product->getTranslation('descLong','en'))}}</textarea>
                    </div>                    
                </div>   
                
                <div class="row">
                    
                    <div class="col-md-6 mb-4">
                     
                        <label for="roleName" class="form-label fw-bolder d-block">   {{ trans('product_dasboard.tags_ar') }}  </label>
                        <input class="form-control" name="tags" value="{{old('tags',$product->tags->pluck('name')->implode(','))}}"  id="kt_tagify_1"/>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="roleName" class="form-label fw-bolder d-block">    {{ trans('product_dasboard.tags_en') }}  </label>
                        <input class="form-control" name="tags_en"  value="{{ old('tags_en',$product->tags->pluck('name')->implode(','))}}" id="kt_tagify_2"/>
                    </div>                  
                </div>        
                <!--begin::Repeater-->
                <br>
                <label for="roleName" class="form-label fw-bolder d-block mt-3">  {{ trans('product_dasboard.advantage') }}  </label>
               
                <div id="kt_docs_repeater_basic" class="repeater">
                    <!--begin::Form group-->
                
                    <div class="form-group">
                   
                        <div data-repeater-list="kt_docs_repeater_basic">
                            
                          @foreach($product->advantages as $index=>$item)
                            <div data-repeater-item>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                           <input type="hidden" name="uuid" value="{{ $item->uuid}}">
                                            <input type="text" name="advantage" value="{{$item->getTranslation('advantage','ar')}}" class="form-control mb-1" placeholder=" {{ trans('product_dasboard.advantage_name_ar') }}" />
                                            <input type="text"  name="advantage_en"  value="{{$item->getTranslation('advantage','en')}}"  class="form-control mb-1" placeholder="{{ trans('product_dasboard.advantage_name_en') }} " />
                                        </div>
                                        <div class="col-md-3">
                                            <textarea type="text"  name="desc_advantage"   rows="3" class="form-control mb-2 mb-md-0" placeholder=" {{ trans('product_dasboard.advantage_desc_ar') }}">{{$item->getTranslation('desc_advantage','ar')}}</textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <textarea type="text"  name="desc_advantage_en"  rows="3" class="form-control mb-2 mb-md-0" placeholder="{{ trans('product_dasboard.advantage_desc_en') }} ">{{$item->getTranslation('desc_advantage','en')}}</textarea>
                                        </div>                                    
                                        
                                        <div class="col-md-3">
                                          <button type="button" id="delete-resource" data-id="{{ $item->id }}" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8"> <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>   {{ trans('product_dasboard.delete') }}</button>
                                        
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                           
                         
                       @endforeach  
                        </div>  
                        </div>
                   
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group mt-5">
                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i>
                                {{ trans('product_dasboard.add') }}
                        </a>
                    </div>
                    <!--end::Form group-->
                </div>
                
                <!--end::Repeater-->
                <div class="mt-6">
                    <div class="form-group mb-4">
                        <label for="roleName" class="form-label fw-bolder d-block">   {{ trans('product_dasboard.price') }} </label>
                        <input type="number" id="price_new" name="price_new"   step="any"  value="{{old('price_new',$product->price_new)}}"  class="form-control form-control-solid" required>
                    </div>  
                    <label>{{ trans('product_dasboard.is_applied_tax') }} </label> 
                        <input type="checkbox" name="is_applied_tax" value="1" {{ $product->is_applied_tax ? 'checked' : '' }}>                                                    
                 </div>

               <div class="mt-6">
                {{-- <div class="form-group mb-4">
                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                </div>    --}}
                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ asset('cp_files/assets/media/blank.svg')  }})">
                    <!--begin::Image preview wrapper-->
                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{asset('storage/uploads/products'.'/'. $product->avatar )}})"></div>
                    <!--end::Image preview wrapper-->
                    <!--begin::Edit button-->
                    <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Change avatar">
                        <i class="bi bi-pencil-fill fs-7"><span class="path1"></span><span class="path2"></span></i>
                        <!--begin::Inputs-->
                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg"   />
                        {{-- <input type="hidden" name="avatar_remove" /> --}}
                        <!--end::Inputs-->
                    </label>
                    <!--end::Edit button-->
                    <!--begin::Cancel button-->
                    <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Cancel avatar">
                        <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--begin::Remove button-->
                    <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove"
                        data-bs-toggle="tooltip"
                        data-bs-dismiss="click"
                        title="Remove avatar">
                        <i class="bi bi-x fs-2"></i>
                    </span>
                    <!--end::Remove button-->
                </div>
        
              
                <div class="form-group text-end">
                    <button class="btn btn-primary">    {{ trans('product_dasboard.edit') }}  </button>
                </div>
            </form>

        </div>
    </div>


@endsection

@push('js')
    <script>
$(document).on('click', '#delete-resource', function(e) {
    e.preventDefault();

    var resource_id = $(this).data('id');

    $.ajax({
        
        url: '/dashboard/delte_advantage/' + resource_id,
        type: 'DELETE',
        data: {
            '_token': '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log(66);
            // Handle the successful deletion of the resource
        },
        error: function(xhr) {
             console.log(55);
            // Handle the error
        }
    });
});
</script>
@endpush
