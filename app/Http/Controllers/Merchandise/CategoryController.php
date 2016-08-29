<?php

namespace App\Http\Controllers\Merchandise;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    public function index() {
        $category_with_number_of_entries = Category::withNumberOfEntries();

        if (request()->has('search')) {
            $results = Merchandise::searchFor(request()->get('search'), $category_with_number_of_entries);

            if (!$results->count()) {
                flash()->error(trans('search.empty', ['search' => request()->get('search')]))->important();
            }

            if (request()->has('sort')) {
                $sorted_results = Merchandise::sort(request()->get('sort'), $results);

                if (is_null($sorted_results)) {
                    return redirect()->back();
                }
                $categories = $sorted_results->paginate(intval(Setting::value('per_page')));
            } else {
                $categories = $results->paginate(intval(Setting::value('per_page')));
            }
        } else {
            if (request()->has('sort')) {
                $sorted = Category::sort(request()->get('sort'), $category_with_number_of_entries);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $categories = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $categories = $category_with_number_of_entries->paginate(intval(Setting::value('per_page')));
            }
        }
        $categories->appends(request()->except('page'));
        return view('dashboard.admin.merchandises.category.index', compact('categories'));
    }

    public function create() {
        return view('dashboard.admin.merchandises.category.create');
    }

    public function store(Requests\CategoryRequest $request) {
        $category = Category::create($request->all());
        flash()->success(trans('category.created', ['name' => $category->name]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('merchandise.categories.index');
    }

    public function show(Category $category) {
        $merchandise_by_category = Merchandise::byCategory($category->id);

        if (request()->has('search')) {
            $results = Merchandise::searchFor(request()->get('search'), $merchandise_by_category);

            if (!$results->count()) {
                flash()->error(trans('search.empty', ['search' => request()->get('search')]))->important();
            }

            if (request()->has('sort')) {
                $sorted_results = Merchandise::sort(request()->get('sort'), $results);

                if (is_null($sorted_results)) {
                    return redirect()->back();
                }
                $merchandises = $sorted_results->paginate(intval(Setting::value('per_page')));
            } else {
                $merchandises = $results->paginate(intval(Setting::value('per_page')));
            }
        } else {
            if (request()->has('sort')) {
                $sorted = Merchandise::sort(request()->get('sort'), $merchandise_by_category);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $merchandises = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $merchandises = $merchandise_by_category->paginate(intval(Setting::value('per_page')));
            }
        }
        $merchandises->appends(request()->except('page'));
        return view('dashboard.admin.merchandises.category.show', compact('merchandises', 'category'));
    }

    public function edit(Category $category) {
        return view('dashboard.admin.merchandises.category.edit', compact('category'));
    }

    public function update(Requests\CategoryRequest $request, Category $category) {
        $category->update($request->all());
        flash()->success(trans('category.updated', ['name' => $category->name]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('merchandise.categories.index');
    }

    public function destroy(Category $category) {
        if (count($category->merchandises)) {
            flash()->error(trans('category.not_empty', ['name' => $category->name]))->important();
        } else {
            $category->delete();
            flash()->success(trans('category.deleted', ['name' => $category->name]));
        }

        if (request()->has('redirect')) {
            return redirect()->to(request()->get('redirect'));
        }
        return redirect()->back();
    }
}
