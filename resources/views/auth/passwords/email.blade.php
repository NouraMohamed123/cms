@extends('layouts.frontend.app')

@section('content')
<div class='page register pt-md-3 pt-0'>

    <div class="container mt-5 pt-5">
        <div class='row justify-content-center'>
    <div class="container mt-5 pt-5">
        <div class='row justify-content-center'>
        <div class="col-md-8">
          
                

             
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-2">
                            <label for="" class='text-muted'>  {{ trans('register.email') }}  <span class='text-danger'>*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>  
                        <button type="submit" class="btn bg-main text-white d-block w-100 btn-danger mt-3 btn-register">
                            <svg class='me-2'  width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M1.86111 0.5C1.02225 0.5 0.39548 1.20419 0.337689 2.04033L0.333333 2.16667V13.8333C0.333333 14.6812 0.920161 15.4258 1.73692 15.4948L1.86111 15.5H8.80556C9.64441 15.5 10.2712 14.7958 10.329 13.9597L10.3333 13.8333V11.8095C10.3333 11.3493 9.96024 10.9762 9.5 10.9762C9.07264 10.9762 8.72041 11.2979 8.67227 11.7123L8.66667 11.8095V13.8333H2V2.16667H8.66667V4.19048C8.66667 4.65071 9.03976 5.02381 9.5 5.02381C9.92736 5.02381 10.2796 4.70211 10.3277 4.28766L10.3333 4.19048V2.16667C10.3333 1.31877 9.7465 0.574199 8.92975 0.50521L8.80556 0.5H1.86111ZM7.11905 5.61265C6.99258 5.61265 6.86838 5.64622 6.75914 5.70995L3.89102 7.38301C3.55027 7.58179 3.43517 8.01916 3.63394 8.35991C3.69603 8.46634 3.78459 8.5549 3.89102 8.61698L6.75914 10.2901C7.09989 10.4888 7.53726 10.3737 7.73603 10.033C7.79976 9.92374 7.83333 9.79954 7.83333 9.67307V8.83333H13.6667C14.1269 8.83333 14.5 8.46024 14.5 8C14.5 7.53976 14.1269 7.16667 13.6667 7.16667H7.83333V6.32693C7.83333 5.93244 7.51354 5.61265 7.11905 5.61265Z" fill="white"/> </svg>
                            {{ trans('register.Send_Reset_Link') }} 
                         </button>

                    </form>
                </div>
            </div>
   
   
</div>
</div>
    </div>
</div>
@endsection
