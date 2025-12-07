<?php
// filepath: app/Http/Controllers/Admin/AdminTransactionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'payment'])
                                    ->latest()
                                    ->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product', 'payment']);

        return view('admin.transactions.show', compact('transaction'));
    }

    // Update status transaksi (shipped, completed)
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled,shipped,completed',
        ]);

        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Transaction status updated!');
    }
}