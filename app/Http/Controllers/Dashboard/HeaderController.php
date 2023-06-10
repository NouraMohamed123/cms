<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Header;
use Illuminate\Support\Str;
class HeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headers = Header::all();
      
        return view('dashboard.header.index',compact('headers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $headers = Header::all();
      
        // return view('dashboard.header.index',compact('headers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $headers = $request->kt_docs_repeater_basic;
        foreach ($headers as $header) {
            if (isset($header['uuid'])) {
                Header::updateOrCreate(
                    ['uuid' => $header['uuid']],
                    [
                        'name' => [
                            'ar' => $header['header_ar'],
                            'en' => $header['header_en'],
                        ],
                        'place' => $header['place'],
                        'url' => $header['url'],
                        'uuid' => Str::uuid(),
                    ]
                );
            } else {
                Header::Create([
                    'name' => [
                        'en' => $header['header_en'],
                        'ar' => $header['header_ar'],
                    ],
                    'place' => $header['place'],
                    'url' => $header['url'],
                    'uuid' => Str::uuid(),
                ]);
            }
        }
        return redirect()->route('dashboard.headers.index');
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
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $header = Header::find($id);

        $header->delete();

        return response()->json([
            'success' => 'header deleted successfully',
        ]);
    }
}
