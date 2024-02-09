<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        $validator = Validator::make($data, [
            'email' => 'required|email:rfc',
            'username' => 'required|unique:users',
            'password' => 'required|customPassword', 
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->errors());
        }

        $validated = $validator->validated();

        User::create($validated);

        return redirect(url()->current())->with('success', 'Data User berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::where('id', $this->userId())->first();
        return view('Pages.Admin.Page.Account.show', [
            'title' => 'Info Akun',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
