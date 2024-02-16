<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
         $validator = Validator::make($request->all(), [
             'email' => 'required|email|unique:users|email:rfc',
             'username' => 'required|unique:users',
             'password' => 'required|customPassword',
             'image' => 'required|file|image|max:10290',
             'roles' => 'required',
         ]);
         if ($validator->fails()) {
             return back()->withErrors($validator)->withInput();
         }

        if ($request->hasFile('image')) {
            $path = 'image/' . time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $path);
            $validated['image'] = $path;
        }

         $user = new User();
         $user->email = $request->email;
         $user->remember_token = Str::random(60);
         $user->email_verified_at = Carbon::now();
         $user->username = $request->username;
         $user->password = bcrypt($request->password);
         $user->image = $request->image;
         $user->roles = $request->roles;

         $user->save();

         return back()->with('success', 'User berhasil ditambahkan.');
     }



    public function show(User $user)
    {
        $user = User::where('id', $this->userId())->first();
        return view('Pages.Admin.Page.Account.profile', [
            'title' => 'Info Akun',
            'user' => $user
        ]);
    }

    public function edit($id)
    {
        $user = User::find(decrypt($id));
        return view('Pages.Admin.Page.Account.show', [
            'title' => 'Detail Akun',
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail(decrypt($id));

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|unique:users,username,' . $user->id,
            'password' => 'nullable|customPassword',
            'image' => 'nullable|file|image|max:10290',
            'roles' => 'required' . $user->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete($user->image);
            }
            $path = 'image/' . time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $path);
            $user->image = $path;
        }
        $user->email = $request->email;
        $user->username = $request->username;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->roles = $request->roles;

        $user->save();

        return back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::find( decrypt($id) );
        User::destroy(decrypt($id));
        return back()->with('success','Telah Berhasil dihapus');
    }
}
