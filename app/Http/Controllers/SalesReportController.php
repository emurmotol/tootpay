<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use App\Http\Requests;

class SalesReportController extends Controller
{
    public function index() {
        return view('dashboard.admin.sales_report.index');
    }

    public function dailySales(Request $request) {
        if ($request->ajax()) {
            $merchandise_purchase = Merchandise::dailySales($request->get('date'));
            return (String) view('dashboard.admin.sales_report._partials.daily_sales', compact('merchandise_purchase'));
        }
    }

    public function monthlySales(Request $request) {
        if ($request->ajax()) {
            $merchandise_purchase = Merchandise::monthlySales($request->get('month'));
            return (String) view('dashboard.admin.sales_report._partials.monthly_sales', compact('merchandise_purchase'));
        }
    }

    public function yearlySales(Request $request) {
        if ($request->ajax()) {
            $merchandise_purchase = Merchandise::yearlySales($request->get('year'));
            return (String) view('dashboard.admin.sales_report._partials.yearly_sales', compact('merchandise_purchase'));
        }
    }
}
