<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class MerchandiseController extends Controller
{
    public function index()
    {
        $merchandises = Merchandise::paginate(Setting::value('per_page'));
        return view('dashboard.common.merchandise.index', compact('merchandises'));
    }

    public function create()
    {
        return view('dashboard.common.merchandise.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Merchandise $merchandise)
    {
        return view('dashboard.common.merchandise.show', compact('merchandise'));
    }

    public function edit(Merchandise $merchandise)
    {
        return view('dashboard.common.merchandise.edit', compact('merchandise'));
    }

    public function update(Request $request, Merchandise $merchandise)
    {
        //
    }

    public function destroy($merchandise_id)
    {
        //
    }

    public function available(Request $request, Merchandise $merchandise)
    {
        //
    }

    public function showAvailable()
    {
        $array = Merchandise::available();
        $total = count($array);
        $per_page = intval(Setting::value('per_page'));
        $page = Input::get('page', 1);
        $offset = ($page * $per_page) - $per_page;
        $items = array_slice($array, $offset, $per_page, true);
        $merchandises = (new LengthAwarePaginator($items, $total, $per_page, $page, [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        ));
        return view('dashboard.common.merchandise.available', compact('merchandises'));
    }

    public function showUnavailable()
    {
        $array = Merchandise::unavailable();
        $total = count($array);
        $per_page = intval(Setting::value('per_page'));
        $page = Input::get('page', 1);
        $offset = ($page * $per_page) - $per_page;
        $items = array_slice($array, $offset, $per_page, true);
        $merchandises = (new LengthAwarePaginator($items, $total, $per_page, $page, [
                'path'  => request()->url(),
                'query' => request()->query(),
            ]
        ));
        return view('dashboard.common.merchandise.unavailable', compact('merchandises'));
    }
}
