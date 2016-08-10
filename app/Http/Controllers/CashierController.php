<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    public function reloads() {
        return view('dashboard.cashier.reloads');
    }

    public function pendingReload(Request $request) {
        if ($request->ajax()) {
            $reloads = DB::table('reloads')->where('paid', null)->orderBy('created_at', 'asc')->get();

            if (!is_null($reloads)) {
                return (String) view('dashboard.cashier._partials.pending_reload', compact('reloads'));
            }
        }
    }

    public function paidReload(Request $request) {
        if ($request->ajax()) {
            DB::table('reloads')->where('id', $request->get('id'))->update(['paid' => true]);
            return response()->make('paid');
        }
    }

    public function cancelReload(Request $request) {
        if ($request->ajax()) {
            DB::table('reloads')->where('id', $request->get('id'))->update(['paid' => false]);
            return response()->make('canceled');
        }
    }

    public function queue() {
        return view('dashboard.cashier.queue');
    }
}
