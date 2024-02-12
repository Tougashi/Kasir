<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function store(): void
    {
        //
    }

    
    public function boot()
    {
        // Menambahkan aturan validasi kustom untuk password
        Validator::extend('customPassword', function ($attribute, $value, $parameters, $validator) {
            // Validasi apakah password dimulai dengan huruf kapital dan mengandung setidaknya satu angka atau simbol
            return preg_match('/^(?=.*[A-Z])(?=.*[0-9\W]).+$/', $value);
        });

        // Pesan validasi kustom untuk aturan validasi kustom password
        Validator::replacer('customPassword', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Password harus memiliki panjang 8 dan memiliki Huruf Kapital dan setidaknya 1 Angka atau Simbol');
        });
    }
}
