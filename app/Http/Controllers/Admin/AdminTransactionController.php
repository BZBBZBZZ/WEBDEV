<?php
// filepath: app/Http/Controllers/Admin/AdminTransactionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'details.product']);

        // ✅ Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ✅ Search by order ID or customer name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('transaction_code', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->latest()->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product']);

        return view('admin.transactions.show', compact('transaction'));
    }

    // ✅ Update transaction status
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $transaction->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Transaction status updated successfully!');
    }
}