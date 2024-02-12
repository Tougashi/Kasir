<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function userId(){
        if(auth()->check()){
            return auth()->user()->id;
        }else{
            abort(400);
        }
    }


    public function index()
    {
        return view('Pages.Admin.Page.Account.index', [
            'title' => 'Daftar Akun',
            'data' => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Admin.Page.Account.add', [
            'title' => 'Buat Akun',
            'data' => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'email' => 'required|email|unique:users|email:rfc',
             'username' => 'required|unique:users',
             'password' => 'required|customPassword',
             'roles' => 'required',
         ]);
         if ($validator->fails()) {
             return back()->withErrors($validator)->withInput();
         }

         $user = new User();
         $user->email = $request->email;
         $user->remember_token = Str::random(60);
         $user->email_verified_at = Carbon::now();
         $user->username = $request->username;
         $user->password = bcrypt($request->password);
         $user->roles = $request->roles;
         
         $user->save();
     
         return back()->with('success', 'User berhasil ditambahkan.');
     }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::where('id', $this->userId())->first();
        return view('Pages.Admin.Page.Account.profile', [
            'title' => 'Info Akun',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, string $id)
    {
        $user = User::find(decrypt($id));
        $user = User::find(decrypt($id));
        return view('Pages.Admin.Page.Account.show', [
            'title' => 'Info Akun',
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(string $id)
    {
        $user = User::find( decrypt($id) );
        User::destroy(decrypt($id));
        return back()->with('success','Telah Berhasil dihapus');
    }
}
