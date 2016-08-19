<?php

namespace App\Http\Controllers;

use App\Models\OperationDay;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function daily() {
        return view('dashboard.admin.reports.daily');
    }

    public function weekly() {
        return view('dashboard.admin.reports.weekly');
    }

    public function monthly() {
        return view('dashboard.admin.reports.monthly');
    }

    public function yearly() {
        return view('dashboard.admin.reports.yearly');
    }
}
