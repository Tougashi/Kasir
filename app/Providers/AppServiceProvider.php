<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('customPassword', function ($attribute, $value, $parameters, $validator) {
            // Memeriksa apakah password memenuhi semua persyaratan
            return preg_match('/^(?=.*[A-Z])(?=.*[0-9!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,255}$/', $value);
        });
    
        // Menambahkan pesan kesalahan kustom
        Validator::replacer('customPassword', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Password harus memiliki panjang 8 dan memiliki Huruf Kapital dan setidaknya 1 Angka atau Simbol');
        });
    }
}
