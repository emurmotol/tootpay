<?php

namespace App\Http\Controllers;

use App\Models\MerchandiseCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class MerchandiseCategoryController extends Controller
{
    public function index()
    {
        $merchandise_categories = MerchandiseCategory::paginate(Setting::value('per_page'));
        return view('dashboard.admin.merchandise.category.index', compact('merchandise_categories'));
    }

    public function create()
    {
        return view('dashboard.admin.merchandise.category.create');
    }

    public function store(Requests\MerchandiseCategoryRequest $request)
    {
        MerchandiseCategory::create($request->only('name'));

        if ($request->has('redirect')) {
            return redirect($request->get('redirect'));
        }
        return redirect('categories');
    }

    public function show(MerchandiseCategory $merchandise_category)
    {
        //
    }

    public function edit(MerchandiseCategory $merchandise_category)
    {
        return view('dashboard.admin.merchandise.category.edit', compact('merchandise_category'));
    }

    public function update(Requests\MerchandiseCategoryRequest $request, MerchandiseCategory $merchandise_category)
    {
        $merchandise_category->update($request->only('name'));
        return redirect('categories');
    }

    public function destroy(MerchandiseCategory $merchandise_category)
    {
        $merchandise_category->delete();
        return redirect()->back(); // todo has 404
    }
}
