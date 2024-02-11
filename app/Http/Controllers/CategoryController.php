<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        if(isset($categories[0])){
            foreach($categories as $item){
                $categoriesArr[] = [
                    'name' => $item->name,
                    'slug' => $item->slug,
                    'description' => $item->description,
                    'created_at' => Carbon::parse($item->created_at)->format('d F Y H:i')
                ];
            }
        }else{
            $categoriesArr = null;
        }
        
        if($request->ajax()){
            return response()->json(['data' => $categoriesArr]);
        }else{
            return view('Pages.Admin.Page.Categories.index', [
                'title' => 'Daftar Kategori',
                'categories' => $categories
            ]);
        }
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
        $data = $request->all();
        $data['slug'] = Str::slug(strtolower($request->name));

        $validate = Validator::make($data, [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required'
        ]);

        if($validate->fails()){
            $request->flashOnly(['name', 'description']);
            return back()->withErrors($validate->errors());
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
    public function edit($slug, Request $request)
    {
        if($request->ajax()){
            $data = Category::where('slug', $slug)->first();
            return response()->json(['data' => $data]);
        }else{
            abort(400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($slug, Request $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug(strtolower($request->name));

        $validate = Validator::make($data, [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required'
        ]);

        if($validate->fails()){
            return back()->withErrors($validate->errors());
        }

        $validated = $validate->validated();
        try{
            Category::where('slug', $slug)->update([
                'name' => $validated['name'],
                'slug' => $validated['description'],
                'description' => $validated['description']
            ]);
            return back()->with('success', 'Data berhasil diperbarui');
        }catch(\Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug, Request $request)
    {
        if($request->ajax()){
            // abort(200);
            Category::where('slug', $slug)->delete();
            return response()->json(['message' => 'Data Kategori berhasil dihapus']);
        }else{
            abort(400);
        }
    }
}
