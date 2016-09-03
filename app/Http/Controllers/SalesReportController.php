<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\Order;
use App\Models\StatusResponse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

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

    public function downloadDaily($file_name) {
        $file = storage_path('exports/sales/daily/') . $file_name;

        if (file_exists($file)) {
            return response()->download($file, $file_name);
        }
        return response()->make(trans('file.not_found'));
    }

    public function downloadMonthly($file_name) {
        $file = storage_path('exports/sales/monthly/') . $file_name;

        if (file_exists($file)) {
            return response()->download($file, $file_name);
        }
        return response()->make(trans('file.not_found'));
    }

    public function downloadYearly($file_name) {
        $file = storage_path('exports/sales/yearly/') . $file_name;

        if (file_exists($file)) {
            return response()->download($file, $file_name);
        }
        return response()->make(trans('file.not_found'));
    }

    public function exportDaily(Request $request) {
        if ($request->ajax()) {
            $date = $request->get('date');
            $file_type = 'csv';
            $file_name = strtolower(config('static.app.name')) . '-sales-report-' . $date;
            $path = storage_path('exports/sales/daily');

            Excel::create($file_name, function ($excel) use ($date) {
                $excel->sheet($date, function ($sheet) use ($date) {
                    $sheet->row(1, array('Toot Daily Sales Report (' . $date . ')'));
                    $sheet->row(2, array(config('static.app.company')));
                    $sheet->appendRow(['Name', 'Count', 'Unit', 'Total']);

                    $sales = Transaction::dailySales($date);

                    foreach ($sales as $sale) {
                        if (filter_var($sale['_item'], FILTER_VALIDATE_INT)) {
                            $sheet->appendRow([Merchandise::find($sale['_item'])->name, $sale['_count'], 'order', $sale['_total']]);
                        } else {
                            $sheet->appendRow([$sale['_item'], $sale['_count'], 'transaction', $sale['_total']]);
                        }
                    }
                    $sheet->appendRow([null, null, 'Net Total', collect($sales)->pluck('_total')->sum()]);
                });
            })->store($file_type, $path);
            return response()->make($file_name . '.' . $file_type);
        }
        return StatusResponse::find(17)->name;
    }

    public function exportMonthly(Request $request) {
        if ($request->ajax()) {
            $month = $request->get('month');
            $file_type = 'csv';
            $file_name = strtolower(config('static.app.name')) . '-sales-report-' . $month;
            $path = storage_path('exports/sales/monthly');

            Excel::create($file_name, function ($excel) use ($month) {
                $excel->sheet($month, function ($sheet) use ($month) {
                    $sheet->row(1, array('Toot Monthly Sales Report (' . $month . ')'));
                    $sheet->row(2, array(config('static.app.company')));
                    $sheet->appendRow(['Date', 'Total']);

                    $sales = Transaction::monthlySales($month);

                    foreach ($sales as $sale) {
                        $sheet->appendRow($sale);
                    }
                    $sheet->appendRow(['Net Total', collect($sales)->pluck('_total')->sum()]);
                });
            })->store($file_type, $path);
            return response()->make($file_name . '.' . $file_type);
        }
        return StatusResponse::find(17)->name;
    }

    public function exportYearly(Request $request) {
        if ($request->ajax()) {
            $year = $request->get('year');
            $file_type = 'csv';
            $file_name = strtolower(config('static.app.name')) . '-sales-report-' . $year;
            $path = storage_path('exports/sales/yearly');

            Excel::create($file_name, function ($excel) use ($year) {
                $excel->sheet($year, function ($sheet) use ($year) {
                    $sheet->row(1, array('Toot Yearly Sales Report (' . $year . ')'));
                    $sheet->row(2, array(config('static.app.company')));
                    $sheet->appendRow(['Month', 'Total']);

                    $sales = Transaction::yearlySales($year);

                    foreach ($sales as $sale) {
                        $sheet->appendRow($sale);
                    }
                    $sheet->appendRow(['Net Total', collect($sales)->pluck('_total')->sum()]);
                });
            })->store($file_type, $path);
            return response()->make($file_name . '.' . $file_type);
        }
        return StatusResponse::find(17)->name;
    }
}
