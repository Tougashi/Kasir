<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id');
    }
}
