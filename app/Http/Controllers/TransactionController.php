<?php
// filepath: app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // List transaksi user
    public function index()
    {
        $transactions = auth()->user()->transactions()
                              ->with('details.product')
                              ->latest()
                              ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    // Detail transaksi
    public function show(Transaction $transaction)
    {
        // Pastikan user hanya bisa akses transaksinya sendiri
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load('details.product');

        return view('transactions.show', compact('transaction'));
    }
}