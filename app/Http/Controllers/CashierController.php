<?php

namespace App\Http\Controllers;

use App\Models\StatusResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function transactionsCashier(Request $request) {
        if ($request->ajax()) {
            $transactions = Transaction::pendingAndCash();
            return (String)view('dashboard.cashier._partials.transactions', compact('transactions'));
        }
        return StatusResponse::find(17)->name;
    }

    public function transactionsCount(Request $request) {
        if ($request->ajax()) {
            return Transaction::pendingAndCash()->count();
        }
        return StatusResponse::find(17)->name;
    }

    public function transactionDone(Request $request) {
        if ($request->ajax()) {
            Transaction::setStatusResponse($request->get('transaction_id'), 11);
            return StatusResponse::def(11);
        }
        return StatusResponse::find(17)->name;
    }

    public function transactionCancel(Request $request) {
        if ($request->ajax()) {
            Transaction::setStatusResponse($request->get('transaction_id'), 7);
            return StatusResponse::def(7);
        }
        return StatusResponse::find(17)->name;
    }
}
