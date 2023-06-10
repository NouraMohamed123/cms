<?php

namespace App\DTO;

use Illuminate\Support\Facades\Request;

class productDto
{
    public function __construct(
        protected   string  $name,
        protected  string $name_en,
        protected  int $price,
    )
    {
    }

    public function create(Request $request)
    {
        return new self(
             name: $request->name,
             name_en:$request->name_en,
             price:$request->price
        );
      
    }
}