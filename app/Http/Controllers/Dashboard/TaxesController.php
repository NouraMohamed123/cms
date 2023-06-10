<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tax;

class TaxesController extends Controller
{
    public function index()
    {
        $taxes = Tax::all();
        return view('dashboard.taxes.index', compact('taxes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rate' => 'required',
          
        ]);
        $tax = new Tax();
        $tax->name = $request->input('name');
        $tax->rate = $request->input('rate');
        $tax->save();
        session()->flash('success', 'Data Added Successfully');
        return redirect()->route('dashboard.taxes.index');
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'rate' => 'required',
          
        ]);
        $id = $request->input('id');
        $tax = Tax::findOrFail($id);
        $tax->name = $request->input('name');
        $tax->rate = $request->input('rate');
        $tax->save();
        session()->flash('success', 'Data Updated Successfully');
        return redirect()->route('dashboard.taxes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();
        session()->flash('success', 'Data Deleted Successfully');
        return redirect()->route('dashboard.taxes.index');
    }
}
