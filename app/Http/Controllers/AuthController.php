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
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            if($user->roles == 'Admin') {
                return redirect('admin/dashboard')->with(['success', 'Berhasil Login Admin']);
            }elseif($user->roles == 'Cashier') {
                return redirect('kasir/dashboard')->with(['success', 'Berhasil Login Kasir']);
            }elseif($user->roles == 'Guest') {
                return redirect('/beranda')->with(['success', 'Berhasil Login Pelanggan']);
            }else{
                return redirect('/')->with(['?']);
            }
        }

        return back()->with(['gagal']);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8|max:255'
        ]);
        $user = new user();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->roles = 'Guest';
        $user->save();
        return back()->with('success', 'Berhasil Registrasi');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
