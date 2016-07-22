<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;
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

        flash()->success(trans('category.created', ['name' => $request->input('name')]));
        if ($request->has('redirect')) {
            return redirect($request->get('redirect'));
        }
        return redirect('categories');
    }

    public function show(MerchandiseCategory $merchandise_category)
    {
        $merchandises = paginator(Merchandise::byCategory($merchandise_category->id));
        return view('dashboard.admin.merchandise.category.show', compact('merchandises'), compact('merchandise_category'));
    }

    public function edit(MerchandiseCategory $merchandise_category)
    {
        return view('dashboard.admin.merchandise.category.edit', compact('merchandise_category'));
    }

    public function update(Requests\MerchandiseCategoryRequest $request, MerchandiseCategory $merchandise_category)
    {
        $merchandise_category->update($request->only('name'));
        flash()->success(trans('category.updated', ['name' => $merchandise_category->name]));
        return redirect('categories');
    }

    public function destroy(MerchandiseCategory $merchandise_category)
    {
        if (count($merchandise_category->merchandises)) {
            flash()->error(trans('category.not_empty', ['name' => $merchandise_category->name]));
        } else {
            $merchandise_category->delete();
            flash()->success(trans('category.deleted', ['name' => $merchandise_category->name]));
        }
        return redirect()->back();
    }
}
