<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordStock extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product(){
        return $this->belongsTo(\App\Models\Product::class, 'productId');
    }

    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'userId');
    }
}
