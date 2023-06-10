@extends('layouts.dashboard.app')

    @push('css')
      <style>

.form-group {
    margin-bottom: 1.5rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 0.5rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    border: 1px solid #ced4da;
}

button[type="submit"] {
    margin-top: 1rem;
}
      </style>

    @endpush
@section('content')
    <div class="container">
        <h1>{{ trans('coupon.create_coupon') }}</h1>

        <form method="POST" action="{{ route('dashboard.coupons.store') }}">
            @csrf

            <div class="form-group">
                <label for="code">{{ trans('coupon.code') }}</label>
                <input type="text" name="code" id="code" class="form-control" placeholder="Enter coupon code">
            </div>
            <div class="form-group">
                <label for="type">{{ trans('coupon.Coupon_Type') }} </label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">Select a type</option>
                    <option value="fixed">Fixed</option>
                    <option value="percent">Percentage</option>
                </select>
            </div>
            <div class="form-group">
                <label for="discount">{{ trans('coupon.amount') }} </label>
                <input type="number" name="value" id="discount" class="form-control" placeholder="Enter discount percentage">
            </div>
            <div class="form-group">
                <label for="usage_limit">{{ trans('coupon.usage_limit') }} </label>
                <input type="number" name="usage_limit" id="usage_limit" class="form-control" placeholder="Enter discount percentage">
            </div>

             <div class="form-group">
                 <label for="expire_date">{{ trans('coupon.start_date') }}</label>
            <input type="date" id="expire_date" class="form-control"  name="start_date"
                value="{{ old('start_date') }}">
            </div>
          

              <div class="form-group">
                 <label for="expire_date">{{ trans('coupon.end_date') }}</label>
            <input type="date" id="expire_date" class="form-control"  name="end_date"
                value="{{ old('end_date') }}">
            </div>

            <button type="submit" class="btn btn-primary">{{ trans('coupon.create') }}</button>
        </form>
    </div>
@endsection
