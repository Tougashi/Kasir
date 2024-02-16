<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userController;

    public function __construct(UserController $userController){
        $this->userController = $userController;
    }

    public function index()
    {
        return view('Pages.Admin.Page.Transactions.index', [
            'title' => 'Transaksi',
            'transactions' => Transaction::with('orders', 'user')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Admin.Page.Transactions.create', [
            'title' => 'Buat Transaksi',
            'customers' => User::where('roles', 'Guest')->get(),
            'products' => Product::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, UserController $userController)
    {
        if($request->ajax()){
            $data = $request->all();

            $validate = Validator::make($data, [
                'totalProductArr' => 'required|json',
                'productCodeArr' => 'required|json',
                'totalPrice' => 'required'
            ]);

            if($validate->fails()){
                abort($validate->errors());
            }

            $productData = $validate->validated();

            $newTransaction = Transaction::create([
                'userId' => $this->userController->userId(),
            ]);

            $check = Product::whereIn('code', json_decode($productData['productCodeArr']))->get()->pluck('id')->toJson();

            $newOrder = [
                'transactionId' => $newTransaction->id,
                'productId' => $check,
                'userId' => $this->userController->userId(),
                'quantity' => $productData['totalProductArr'],
                'totalPrice' => $productData['totalPrice']
            ];

            try{
                Order::create($newOrder);
                return response('Data Transaksi berhasil di Record');
            }catch(\Exception $e){
                abort($e->getMessage());
            }

            // return response()->json(['data' => $data]);
        }else{
            abort(400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
