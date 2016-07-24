<?php

namespace App\Http\Controllers\Merchandise;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use App\Models\Setting;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class MerchandiseController extends Controller
{
    public function index() {
        if (request()->has('sort')) {
            $merchandises = Merchandise::sort(request()->get('sort'))->paginate(intval(Setting::value('per_page')));
        } else {
            $merchandises = Merchandise::paginate(intval(Setting::value('per_page')));
        }
        $merchandises->appends(request()->except('page'));
        return view('dashboard.admin.merchandise.index', compact('merchandises'));
    }

    public function create() {
        return view('dashboard.admin.merchandise.create');
    }

    public function store(Requests\MerchandiseRequest $request) {
        $merchandise = Merchandise::create($request->all());

        if ($request->hasFile('image')) {
            $this->makeImage($request->file('image'), $merchandise);
        }
        flash()->success(trans('merchandise.created', ['name' => $request->input('name')]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect('merchandises');
    }

    public function show(Merchandise $merchandise) {
        return view('dashboard.admin.merchandise.show', compact('merchandise'));
    }

    public function edit(Merchandise $merchandise) {
        return view('dashboard.admin.merchandise.edit', compact('merchandise'));
    }

    public function update(Requests\MerchandiseRequest $request, Merchandise $merchandise) {
        $merchandise->update($request->all());

        if ($request->hasFile('image')) {
            $this->makeImage($request->file('image'), $merchandise);
        }
        flash()->success(trans('merchandise.updated', ['name' => $merchandise->name]));

        if ($request->has('redirect')) {
            return redirect()->to($request->get('redirect'));
        }
        return redirect('merchandises');
    }

    public function destroy(Merchandise $merchandise) {
        File::delete(public_path('img/merchandises/' . $merchandise->id . '.jpg'));
        $merchandise->delete();
        flash()->success(trans('merchandise.deleted', ['name' => $merchandise->name]));

        if (request()->has('redirect')) {
            return redirect()->to(request()->get('redirect'));
        }
        return redirect()->back();
    }

    public function available(Request $request, $merchandise_id) {
        $merchandise = Merchandise::findOrfail($merchandise_id);
        $merchandise->available = $request->input('available');
        $merchandise->save();

        if ($request->input('available') == 'on') {
            flash()->success(trans('merchandise.available', ['name' => $merchandise->name]));
        } else {
            flash()->success(trans('merchandise.unavailable', ['name' => $merchandise->name]));
        }

        return redirect()->back();
    }

    public function makeImage($image, $merchandise, $text = null) {
        $img = Image::make($image->getRealPath());
        $img->fit(300, 300);

        if (!is_null($text)) {
            $img->text($text, 150, 100, function ($font) {
                $font->file(4);
                $font->size(24);
                $font->align('center');
                $font->valign('center');
            });
        }
        $img->save(public_path('img/merchandises/') . $merchandise->id . '.jpg');

        if (!$merchandise->has_image) {
            $merchandise->has_image = true;
            $merchandise->save();
        }
    }

    public function showAvailable() {
        if (request()->has('sort')) {
            $merchandises = Merchandise::sort(request()->get('sort'), Merchandise::available())->paginate(intval(Setting::value('per_page')));
        } else {
            $merchandises = Merchandise::available()->paginate(intval(Setting::value('per_page')));
        }
        $merchandises->appends(request()->except('page'));
        return view('dashboard.admin.merchandise.available', compact('merchandises'));
    }

    public function showUnavailable() {
        if (request()->has('sort')) {
            $merchandises = Merchandise::sort(request()->get('sort'), Merchandise::unavailable())->paginate(intval(Setting::value('per_page')));
        } else {
            $merchandises = Merchandise::unavailable()->paginate(intval(Setting::value('per_page')));
        }
        $merchandises->appends(request()->except('page'));
        return view('dashboard.admin.merchandise.unavailable', compact('merchandises'));
    }
}
