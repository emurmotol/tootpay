<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\StatusResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class ExpenseController extends Controller
{
    public function index() {
        return view('dashboard.admin.expenses.index');
    }

    public function daily(Request $request) {
        if ($request->ajax()) {
            $expenses = Expense::daily($request->get('date'));
            return (String)view('dashboard.admin.expenses._partials.daily.index', compact('expenses'));
        }
        return StatusResponse::find(17)->name;
    }

    public function monthly(Request $request) {
        if ($request->ajax()) {
            $expenses = Expense::monthly($request->get('month'));
            return (String)view('dashboard.admin.expenses._partials.monthly.index', compact('expenses'));
        }
        return StatusResponse::find(17)->name;
    }

    public function yearly(Request $request) {
        if ($request->ajax()) {
            $expenses = Expense::yearly($request->get('year'));
            return (String)view('dashboard.admin.expenses._partials.yearly.index', compact('expenses'));
        }
        return StatusResponse::find(17)->name;
    }

    public function downloadDaily($file_name) {
        $file = storage_path('exports/expenses/daily/') . $file_name;

        if (file_exists($file)) {
            return response()->download($file, $file_name);
        }
        return response()->make(trans('file.not_found'));
    }

    public function downloadMonthly($file_name) {
        $file = storage_path('exports/expenses/monthly/') . $file_name;

        if (file_exists($file)) {
            return response()->download($file, $file_name);
        }
        return response()->make(trans('file.not_found'));
    }

    public function downloadYearly($file_name) {
        $file = storage_path('exports/expenses/yearly/') . $file_name;

        if (file_exists($file)) {
            return response()->download($file, $file_name);
        }
        return response()->make(trans('file.not_found'));
    }

    public function exportDaily(Request $request) {
        if ($request->ajax()) {
            $date = $request->get('date');
            $file_type = 'csv';
            $file_name = strtolower(config('static.app.name')) . '-expenses-' . $date;
            $path = storage_path('exports/expenses/daily');

            Excel::create($file_name, function ($excel) use ($date) {
                $excel->sheet($date, function ($sheet) use ($date) {
                    $sheet->row(1, array('Toot Daily Expenses (' . $date . ')'));
                    $sheet->row(2, array(config('static.app.company')));
                    $sheet->appendRow(['Name', 'Amount', 'Description']);

                    $expenses = Expense::daily($date);

                    foreach ($expenses as $expense) {
                        $sheet->appendRow([$expense->name, $expense->amount, $expense->description]);
                    }
                    $sheet->appendRow([null, 'Net Total', collect($expenses)->pluck('amount')->sum()]);
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
            $file_name = strtolower(config('static.app.name')) . '-expenses-' . $month;
            $path = storage_path('exports/expenses/monthly');

            Excel::create($file_name, function ($excel) use ($month) {
                $excel->sheet($month, function ($sheet) use ($month) {
                    $sheet->row(1, array('Toot Monthly Expenses (' . $month . ')'));
                    $sheet->row(2, array(config('static.app.company')));
                    $sheet->appendRow(['Date', 'Total']);

                    $expenses = Expense::monthly($month);

                    foreach ($expenses as $expense) {
                        $sheet->appendRow($expense);
                    }
                    $sheet->appendRow(['Net Total', collect($expenses)->pluck('_amount')->sum()]);
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
            $file_name = strtolower(config('static.app.name')) . '-expenses-' . $year;
            $path = storage_path('exports/expenses/yearly');

            Excel::create($file_name, function ($excel) use ($year) {
                $excel->sheet($year, function ($sheet) use ($year) {
                    $sheet->row(1, array('Toot Yearly Expenses (' . $year . ')'));
                    $sheet->row(2, array(config('static.app.company')));
                    $sheet->appendRow(['Month', 'Total']);

                    $expenses = Expense::yearly($year);

                    foreach ($expenses as $expense) {
                        $sheet->appendRow($expense);
                    }
                    $sheet->appendRow(['Net Total', collect($expenses)->pluck('_amount')->sum()]);
                });
            })->store($file_type, $path);
            return response()->make($file_name . '.' . $file_type);
        }
        return StatusResponse::find(17)->name;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
