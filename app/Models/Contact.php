<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'contact_type', 'body'];

    // Scope
    public function scopeWhenSearch($query, $search)
    {
        return $query->when( $search, function ($q) use ($search) {
            return $q->where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%");
        });
    }    

}
