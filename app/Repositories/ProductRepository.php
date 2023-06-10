<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Request;

class ProductRepository
{
    public function __construct()
    {
    }

    public function create($input)
    {
        $Product = new Product();
        if ($request->is_applied_tax) {
            $Product->is_applied_tax = true;
        }
        $Product->name = [
            'en' => $input['name_en'],
            'ar' => $input['name'],
        ];

        $Product->desc = [
            'en' => $input['desc_en'],
            'ar' => $input['desc'],
        ];

        $Product->descLong = [
            'en' => $input['descLong_en'],
            'ar' => $input['descLong'],
        ];
        $Product->price_new = $input['price'];
        $Product->avatar = $input['avatar'];

        return $Product->save();
    }
}