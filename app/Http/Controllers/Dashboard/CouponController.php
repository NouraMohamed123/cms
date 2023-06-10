<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::WhenSearch(request()->search)->paginate();

        return view('dashboard.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'value' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'usage_limit'=>'required'
        ]);

        $Coupon = Coupon::create($request->all());

        session()->flash('success', 'Data Added Successfully');

        return redirect()->route('dashboard.coupons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('dashboard.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($request->all());

        session()->flash('success', 'Data Updated Successfully');

        return redirect()->route('dashboard.coupons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        session()->flash('success', 'Data Deleted Successfully');
        return redirect()->route('dashboard.coupons.index');
    }

    public function checkcoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $ProductId = $request->input('ProductId');
        $product = Product::find($ProductId);
        $price = $product->price_new;
        $coupon = Coupon::where('code', $couponCode)->first();

        $todayDate = \Carbon\Carbon::now();

        $startDate = \Carbon\Carbon::parse($coupon->start_date);
        $endDate = \Carbon\Carbon::parse($coupon->end_date);
        if($coupon->usage_count <= $coupon->usage_limit ){
        if ($coupon->end_date && $todayDate->between($startDate, $endDate)) {
            if ($coupon->type === 'fixed') {
                $price = $price - $coupon->value;
                $value = '-'.$coupon->value.'$';
            } elseif ($coupon->type === 'percent') {
                $discount = $price *($coupon->value / 100);
                $price = $price - $discount ;
                $value = '-'.$discount .'$';
            }
            $coupon->increment('usage_count');
            $coupon->save();

            return response()->json(['valid' => true, 'price' => $price ,'value'=>$value]);
        } else {
            return response()->json(['valid' => false, 'price' => $price]);
        }
    }else{
        return response()->json(['valid' => false, 'price' => $price ,'limit'=>'maximum']);
    }
    }
}
