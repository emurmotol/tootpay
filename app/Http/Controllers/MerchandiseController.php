<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $merchandises = Merchandise::paginate(Setting::value('per_page'));
        return view('dashboard.admin.merchandise.index', compact('merchandises'));
    }

    public function create()
    {
        return view('dashboard.admin.merchandise.create');
    }

    public function store(Requests\MerchandiseRequest $request)
    {
        $merchandise = Merchandise::create($request->all());

        if ($request->hasFile('image')) {
            $this->makeImage($request->file('image'), $merchandise);
        }
        return redirect()->back();
    }

    public function show(Merchandise $merchandise)
    {
        return view('dashboard.admin.merchandise.show', compact('merchandise'));
    }

    public function edit(Merchandise $merchandise)
    {
        return view('dashboard.admin.merchandise.edit', compact('merchandise'));
    }

    public function update(Requests\MerchandiseRequest $request, Merchandise $merchandise)
    {
        $merchandise->update($request->all());

        if ($request->hasFile('image')) {
            $this->makeImage($request->file('image'), $merchandise);
        }
        return redirect()->back();
    }

    public function destroy(Merchandise $merchandise)
    {
        File::delete(public_path('img/merchandises/' . $merchandise->id . '.jpg'));
        $merchandise->delete();
        return redirect()->back(); // todo has 404
    }

    public function available(Request $request, $merchandise_id)
    {
        $merchandise = Merchandise::findOrfail($merchandise_id);
        $merchandise->available = $request->input('available');
        $merchandise->save();
        return redirect()->back();
    }

    public function makeImage($image, $merchandise, $text = null) {
        $img = Image::make($image->getRealPath());
        $img->fit(300, 300);

        if (!is_null($text)) {
            $img->text($text, 150, 100, function($font) {
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
        return view('dashboard.admin.merchandise.available', compact('merchandises'));
    }

    public function showUnavailable() {
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
        return view('dashboard.admin.merchandise.unavailable', compact('merchandises'));
    }
}
