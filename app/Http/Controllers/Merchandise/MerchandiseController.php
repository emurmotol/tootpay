<?php

namespace App\Http\Controllers\Merchandise;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use App\Models\MerchandiseCategory;
use App\Models\OperationDay;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Mockery\CountValidator\Exception;

class MerchandiseController extends Controller
{
    public function index() {
        if (request()->has('search')) {
            $results = Merchandise::searchFor(request()->get('search'));

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
                $sorted = Merchandise::sort(request()->get('sort'));

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $merchandises = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $merchandises = Merchandise::paginate(intval(Setting::value('per_page')));
            }
        }
        $merchandises->appends(request()->except('page'));
        return view('dashboard.admin.merchandises.index', compact('merchandises'));
    }

    public function create() {
        $operation_days = OperationDay::all();
        return view('dashboard.admin.merchandises.create', compact('operation_days'));
    }

    public function store(Requests\MerchandiseRequest $request) {
        $merchandise = Merchandise::create($request->except('day'));

        if ($request->has('day')) {
            $merchandise->operationDays()->sync($request->get('day'));
        }

        if ($request->hasFile('image')) {
            $this->makeImage($request->file('image'), $merchandise);
        }
        flash()->success(trans('merchandise.created', ['name' => $merchandise->name]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('merchandises.index');
    }

    public function show(Merchandise $merchandise) {
        $operation_days = OperationDay::all();
        return view('dashboard.admin.merchandises.show', compact('merchandise', 'operation_days'));
    }

    public function edit(Merchandise $merchandise) {
        $operation_days = OperationDay::all();
        return view('dashboard.admin.merchandises.edit', compact('merchandise', 'operation_days'));
    }

    public function update(Requests\MerchandiseRequest $request, Merchandise $merchandise) {
        $merchandise->update($request->except('day'));

        if ($request->has('day')) {
            $merchandise->operationDays()->sync($request->get('day'));
        } else {
            $merchandise->operationDays()->detach($merchandise->operationDays()->getRelatedIds()->all());
        }

        if ($request->hasFile('image')) {
            $this->makeImage($request->file('image'), $merchandise);
        }
        flash()->success(trans('merchandise.updated', ['name' => $merchandise->name]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect()->route('merchandises.index');
    }

    public function destroy(Merchandise $merchandise) {
        File::delete(public_path('img/merchandises/' . str_slug($merchandise->name) . '.jpg'));
        $merchandise->operationDays()->detach($merchandise->operationDays()->getRelatedIds()->all());
        $merchandise->delete();
        flash()->success(trans('merchandise.deleted', ['name' => $merchandise->name]));

        if (request()->has('redirect')) {
            return redirect()->to(request()->get('redirect'));
        }
        return redirect()->back();
    }

    public function available(Request $request, Merchandise $merchandise) {
        $now = strtotime(Carbon::now());
        $int_day = date("w", $now);
        $day = date("l", $now);

        if ($request->input('available') == 'on') {
            $merchandise->operationDays()->attach($int_day);
            flash()->success(trans('merchandise.available', ['name' => $merchandise->name, 'day' => $day]));
        } else {
            $merchandise->operationDays()->detach($int_day);
            flash()->success(trans('merchandise.unavailable', ['name' => $merchandise->name, 'day' => $day]));
        }
        $merchandise->touch();
        return redirect()->back();
    }

    public function makeImage($image, $merchandise, $text = null) {
        if (is_string($image)) {
            $img = Image::make($image);
        } else {
            $img = Image::make($image->getRealPath());
        }
        $img->fit(300, 300);

        if (!is_null($text)) {
            $img->text($text, 150, 100, function ($font) {
                $font->file(4);
                $font->size(24);
                $font->align('center');
                $font->valign('center');
            });
        }
        $img->save(public_path('img/merchandises/') . str_slug($merchandise->name) . '.jpg');

        if (!$merchandise->has_image) {
            $merchandise->has_image = true;
            $merchandise->save();
        }
    }

    public function showAvailable() {
        $available_merchandises = Merchandise::available();

        if (request()->has('search')) {
            $results = Merchandise::searchFor(request()->get('search'), $available_merchandises);

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
                $sorted = Merchandise::sort(request()->get('sort'), $available_merchandises);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $merchandises = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $merchandises = $available_merchandises->paginate(intval(Setting::value('per_page')));
            }
        }
        $merchandises->appends(request()->except('page'));
        return view('dashboard.admin.merchandises.available', compact('merchandises'));
    }

    public function showUnavailable() {
        $unavailable_merchandises = Merchandise::unavailable();

        if (request()->has('search')) {
            $results = Merchandise::searchFor(request()->get('search'), $unavailable_merchandises);

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
                $sorted = Merchandise::sort(request()->get('sort'), $unavailable_merchandises);

                if (is_null($sorted)) {
                    return redirect()->back();
                }
                $merchandises = $sorted->paginate(intval(Setting::value('per_page')));
            } else {
                $merchandises = $unavailable_merchandises->paginate(intval(Setting::value('per_page')));
            }
        }
        $merchandises->appends(request()->except('page'));
        return view('dashboard.admin.merchandises.unavailable', compact('merchandises'));
    }

    public function showMenu() {
        $merchandise_categories = MerchandiseCategory::all();
        $operation_days = OperationDay::all();
        return view('dashboard.admin.merchandises.daily_menu', compact('operation_days', 'merchandise_categories'));
    }
}
