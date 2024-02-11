<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')->get();
        if($request->ajax()){
            if(isset($produts[0])){
                foreach($products as $product){
                    $productArr[] = [
                        'name' => $product->name,
                        'categoryId' => $product->category->name,
                        'stock' => $product->stock,
                        'price' => $product->price,
                        'expiredDate' => Carbon::parse($product->expiredDate)->format('d F Y'),
                    ];
                }
            }else{
                $productArr = null;
            }
        }else{
            return view('Pages.Admin.Products.list', [
                'title' => 'Daftar Produk',
                'products' => $products,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Admin.Products.create', [
            'title' => 'Tambah Produk',
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
