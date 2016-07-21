<?php

namespace App\Http\Controllers;

use App\Models\MerchandiseCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;

class MerchandiseCategoryController extends Controller
{
    public function index()
    {
        $merchandise_categories = MerchandiseCategory::paginate(Setting::value('per_page'));
        return view('dashboard.common.merchandise.category.index', compact('merchandise_categories'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(MerchandiseCategory $merchandise_category)
    {
        //
    }
    public function edit(MerchandiseCategory $merchandise_category)
    {
        //
    }
    public function update(Request $request, MerchandiseCategory $merchandise_category)
    {
        //
    }
    public function destroy(MerchandiseCategory $merchandise_category)
    {
        //
    }
}
