<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;


class HistoryController extends Controller
{
    function transactions(){
        return view('Pages.Admin.Page.History.transaction', [
            'title' => 'Riwayat Transaksi',
            'transactions' => Order::with('user', 'customer', 'transaction')->get(),
        ]);
    }


}
