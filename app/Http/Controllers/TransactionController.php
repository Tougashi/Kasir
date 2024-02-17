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
        $orders = Order::with('user')->get();

        $newTransactions = [];

        foreach($orders as $order){
            $newTransactions[] = [
                'transactionId' => $order->id,
                'custName' => $order->customer->username,
                'products' => Product::whereIn('id', json_decode($order->productId))->get()->pluck('name'),
                'totalPrice' => $order->totalPrice,
                'qty' => json_decode($order->quantity),
                'total' => $order->totalPrice,
                'adminName' => $order->user->username,
                'transactionDate' => $order->created_at->format('d F Y H:i')
            ];
        }

        return view('Pages.Admin.Page.Transactions.index', [
            'title' => 'Transaksi',
            'transactions' => $newTransactions,
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
                'totalPrice' => 'required',
                'custId' => 'required'
            ]);

            if($validate->fails()){
                abort($validate->errors());
            }

            $productData = $validate->validated();

            $newTransaction = Transaction::create([
                'userId' => $this->userController->userId(),
                'custId' => $productData['custId']
            ]);

            $check = Product::whereIn('code', json_decode($data['productCodeArr']))->get();
            $toNewOrder = $check->pluck('id')->toArray();

            $newOrder = [
                'transactionId' => $newTransaction->id,
                'productId' => json_encode($toNewOrder),
                'custId' => $productData['custId'],
                'userId' => $this->userController->userId(),
                'quantity' => $productData['totalProductArr'],
                'totalPrice' => $productData['totalPrice']
            ];

            // $updateStock;
            foreach($check as $key => $product){
                if(intval($product->stock) < intval(json_decode($productData['totalProductArr'])[$key])){
                    return response("Stok produk kode ".$product->code." tidak mencukupi", 403);

                }else{
                    $currentStock = $product->stock;
                    $newStock = intval(json_decode($productData['totalProductArr'])[$key]);
                    $updateStock = intval($currentStock) - intval($newStock);
                    try{
                        Product::where('code', $product->code)->update([
                            'stock' => $updateStock
                        ]);
                    }catch(\Exception $e){
                        return response('Kesalahan saat memperbarui Stok produk', 500);
                    }
                }
            }

            try{
                Order::create($newOrder);
                return response('Data Transaksi berhasil di Record');

            }catch(\Exception $e){
                abort($e->getMessage());
            }

            return response()->json(['data' => $updateStock]);
        }else{
            abort(400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $req)
    {
        $transaction = Order::with('user')->findOrFail(decrypt($id));
        $transactionArr = [];
        $transactionArr[] = [
            'transactionId' => $transaction->id,
            'products' => Product::whereIn('id', json_decode($transaction['productId']))->get(),
            'totalQty' => json_decode($transaction->quantity),
            'totalPrice' => $transaction->totalPrice,
            'admin' => $transaction->user->username,
            'customer' => $transaction->customer->username,
            'transactionDate' => $transaction->created_at->format('d F Y H:i')
        ];

        if($req === 'print'){
            return view('Pages.Admin.Page.Transactions.print', [
                'title' => 'Print Page',
                'transaction' => $transactionArr
            ]);
        }else{
            return view('Pages.Admin.Page.Transactions.details', [
                'title' => 'Detail Transaksi',
                'transaction' => $transactionArr
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function print($id)
    {
    }


    public function edit($id)
    {

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
