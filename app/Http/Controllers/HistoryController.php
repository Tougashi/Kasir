<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RecordStock;
use App\Models\Transaction;
use Illuminate\Http\Request;


class HistoryController extends Controller
{
    function transactions(Request $request)
    {
        $allTransactions = Order::with('user', 'customer', 'transaction')->get();

        return view('Pages.Admin.Page.History.transaction', [
            'title' => 'Riwayat Transaksi',
            'transactions' => $allTransactions,
        ]);
    }

    function stockIn(Request $request)
    {
        $allRecords = RecordStock::with('product', 'user')->get();
        return view('Pages.Admin.Page.History.stock-in', [
            'title' => 'Riwayat Stock-in',
            'products' => $allRecords
        ]);
    }


}
