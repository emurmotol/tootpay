<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\Order;
use App\Models\StatusResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests;

class SalesReportController extends Controller
{
    public function index() {
        return view('dashboard.admin.sales_report.index');
    }

    public function daily(Request $request) {
        if ($request->ajax()) {
            $sales = Transaction::dailySales($request->get('date'));
            return (String)view('dashboard.admin.sales_report._partials.daily', compact('sales'));
        }
        return StatusResponse::find(17)->name;
    }

    public function monthly(Request $request) {
        if ($request->ajax()) {
            $sales = Transaction::monthlySales($request->get('month'));
            return (String)view('dashboard.admin.sales_report._partials.monthly', compact('sales'));
        }
        return StatusResponse::find(17)->name;
    }

    public function yearly(Request $request) {
        if ($request->ajax()) {
            $sales = Transaction::yearlySales($request->get('year'));
            return (String)view('dashboard.admin.sales_report._partials.yearly', compact('sales'));
        }
        return StatusResponse::find(17)->name;
    }
}
