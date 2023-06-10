<?php

namespace App\Http\Controllers\Dashboard;

use DB;

use App\Models\Tax;
use App\Models\Tag;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Advantage;
use Illuminate\Http\Request;
use App\services\services\Services;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\services\contracts\ProductContract;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('tags')->get();
        $taxes = Tax::all();

        return view('dashboard.products.index', compact('products', 'taxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taxes = Tax::all();
        return view('dashboard.products.create', compact('taxes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request, Services $Services)
    // {
    //     return $Services->create($request);
    // }
    public function store(Request $request, ProductContract $ProductContract)
    {
        return $ProductContract->create($request);
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
    public function edit(Product $product)
    {
        $advantages = $product->advantages;
        $taxes = Tax::all();
        return view(
            'dashboard.products.edit',
            compact('product', 'advantages', 'taxes')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request,
        Product $product,
        ProductContract $ProductContract
    ) {
        return $ProductContract->update($request, $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductContract $ProductContract)
    {
        return $ProductContract->delete($product);
    }
    public function delteAdvantage($id)
    {
        $advantage = Advantage::find($id);
        $advantage->delete();
        return response()->json([
            'success' => 'Advantage deleted successfully',
        ]);
    }
    public function applytaxes(Request $request)
    {
        $price = $request->input('price');
        $setting = Setting::select('key', 'value')
            ->pluck('value', 'key')
            ->toArray();

        $taxId = $setting['taxes'] ?? null;
        if (!empty($taxId)) {
            $taxAmount = $price + ($taxId);
            $price = $taxAmount;
            return response()->json(['valid' => true, 'data' => $price]);
        } else {
            return response()->json(['valid' => false, 'data' => $price]);
        }
    }
}
