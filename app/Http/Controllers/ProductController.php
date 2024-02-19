<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\RecordStock;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userController;

    public function __construct(UserController $userController){
        $this->userController = $userController;
    }


    public function index(Request $request)
    {
        $products = Product::with('category', 'supplier')->get();
        if ($request->ajax()) {
            if (isset($products[0])) {
                foreach ($products as $product) {
                    $productArr[] = [
                        'name' => $product->name,
                        'categoryId' => $product->category->name,
                        'stock' => $product->stock,
                        'price' => $product->price,
                        'code' => $product->code,
                        'entryDate' => Carbon::parse($product->entryDate)->format('d F Y'),
                        'expiredDate' => Carbon::parse($product->expiredDate)->format('d F Y'),
                    ];
                }
            } else {
                $productArr = null;
            }
            return response()->json(['data' => $products]);
        } else {
            return view('Pages.Admin.Page.Products.list', [
                'title' => 'Daftar Produk',
                'products' => $products,
            ]);
        }
    }


    public function search(Request $request)
    {
        $searchText = $request->input('searchText');
    
        $products = Product::with('category')->where('name', 'like', "%$searchText%")
            ->orWhere('code', 'like', "%$searchText%")
            ->get();
    
        return response()->json(['data' => $products]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Admin.Page.Products.create', [
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
        $validate = $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required|unique:products',
            'categoryId' => 'required',
            'supplierId' => 'required',
            'price' => 'required',
            'description' => 'required',
            'expiredDate' => 'required',
            'stock' => 'required',
            'image' => 'nullable|image|max:5000', 
        ]);
    
        if($request->hasFile('image')) {
            $imagePath = 'images/products/' . time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images/products', $imagePath);
            $validate['image'] = $imagePath;
        }
    
        try {
            Product::create($validate);
            return back()->with('success', 'Data Produk berhasil disimpan');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code, Request $request)
    {
        if($request->ajax()){
            $product['product'] = Product::where('code', $code)->first();
            $product['categories'] = Category::all();
            $product['suppliers'] = Supplier::all();
            return response()->json(['data' => $product]);
        }else{
            abort(400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($code, Request $request)
    {
        $validate = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'categoryId' => 'required',
            'supplierId' => 'required',
            'price' => 'required',
            'description' => 'required',
            'expiredDate' => 'required',
            'stock' => 'required',
            'image' => 'nullable|file|image|max:5000', 
        ]);

        if ($request->hasFile('image')) {
            $imagePath = 'images/products/' . time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $imagePath);
            $validate['image'] = $imagePath;
        }
        try {
            $product = Product::where('code', $code)->first();
            $product->update($validate);

            return back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code, Request $request)
    {
        if($request->ajax()){
            Product::where('code', $code)->delete();
            return back()->with('success', 'Data Produk berhasil dihapus');
        }else{
            abort(400);
        }
    }


    public function stockIn(){
        return view('Pages.Admin.Page.Products.stock-in', [
            'title' => 'Stock-in Produk',
        ]);
    }

    public function getProductData(Request $request, $code){
        $products = Product::where('code',$code)->first();
        if($request->ajax()){
            if(isset($products)){
                return response()->json(['data' => $products, 'status' => 200]);
            }else{
                return response("Tidak ditemukan data produk $code", 404);
            }
        }else{
            abort(400);
        }
    }

    public function updateStock(Request $request){
        if($request->ajax()){
            $validating = Validator::make($request->all(), [
                'code' => 'required',
            'stock' => 'required',
                'expiredDate' => 'required|after:today'
            ]);

            if($validating->fails()){
                return response($validating->errors(), 500);
            }

            $validate = $validating->validated();

            $dataProduct = Product::where('code', $validate['code'])->first();
            $qtyForRecord = $validate['stock'];
            $validate['stock'] = intval($dataProduct->stock) + intval($validate['stock']);

            if($validate){
                try{
                    Product::where('code', $validate['code'])->update($validate);
                    RecordStock::create([
                        'productId' => $dataProduct->id,
                        'userId' => $this->userController->userId(),
                        'qty' => $qtyForRecord
                    ]);
                    return response('Stok produk berhasil diperbarui');
                }catch(\Exception $e){
                    return abort(500);
                }
            }else{
                abort(400);
            }

        }else{
            abort(400);
        }
    }

    public function expired(Request $request){
        $productExpired = Product::where('expiredDate', '<=', now())->get();

        return view('Pages.Admin.Page.Products.expired', [
            'title' => 'Produk Kadaluarsa',
            'products' => $productExpired
        ]);
    }
}
