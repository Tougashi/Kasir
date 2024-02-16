<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login()
    {
        return view('Pages.Auth.index', [
            'title' => 'Login'
        ]);
    }

    public function registrasi()
    {
        return view('Pages.Auth.Registration.index', [
            'title' => 'Registrasi'
        ]);
    }

    public function auth(Request $request): RedirectResponse
    {

        $request->flashOnly('username');
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            if($user->roles == 'Admin') {
                return redirect('admin/dashboard')->with(['success', 'Berhasil Login Admin']);
            }elseif($user->roles == 'Cashier') {
                return redirect('cashier/dashboard')->with(['success', 'Berhasil Login Kasir']);
            }elseif($user->roles == 'Guest') {
                return redirect('/beranda')->with(['success', 'Berhasil Login Pelanggan']);
            }else{
                return redirect('/')->with(['Gagal untuk login']);
            }
        }

        return back()->with('username' , 'Masukkan Username atau Password dengan benar')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
