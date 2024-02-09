<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Pages.Admin.Page.Categories.index', [
            'title' => 'Daftar Kategori'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Admin.Page.Categories.create', [
            'title' => 'Tambah Kategori'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->flashOnly(['name', 'description']);
        $data = $request->all();
        $data['slug'] = Str::slug(strtolower($request->name));

        $validate = Validator::make($data, [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required'
        ]);

        if($validate->fails()){
            return back()->with('errors', $validate->errors());
        }

        $validated = $validate->validated();
        try{
            Category::create($validated);
            return back()->with('success', 'Kategori baru berhasil ditambahkan');
        }catch(\Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
