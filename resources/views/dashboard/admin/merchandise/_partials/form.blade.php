<div class="row">
    @if(request()->has('redirect'))
        {!! Form::open([
            'route' => (Route::is('merchandises.edit')) ? ['merchandises.update', $merchandise->id, 'redirect' => request()->get('redirect')] : ['merchandises.store', 'redirect' => request()->get('redirect')],
            'files' => true,
            'class' => ''
        ]) !!}
    @else
        {!! Form::open([
            'route' => (Route::is('merchandises.edit')) ? ['merchandises.update', $merchandise->id] : 'merchandises.store',
            'files' => true,
            'class' => ''
        ]) !!}
    @endif

    @if(Route::is('merchandises.edit'))
        {{ Form::hidden('_method', 'PUT') }}
    @endif

    <div class="col-md-3">
        <div class="img-merchandise">
            <a href="#">
                <img src="{{ \App\Models\Merchandise::image((Route::is('merchandises.edit')) ? $merchandise->id : 0) }}"
                     id="image-merchandise"
                     class="img-responsive img-rounded"
                     alt="{{ (Route::is('merchandises.edit')) ? $merchandise->name : 'Default Image' }}">
            </a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label for="image">Upload Image:</label>
            <input type="file" onchange="loadImage(this);" class="form-control" id="image" name="image">

            @if ($errors->has('image'))
                <span class="help-block">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ (Route::is('merchandises.edit')) ? $merchandise->name : old('name') }}">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('merchandise_category_id') ? ' has-error' : '' }}">
            <label for="merchandise_category_id">Category:</label>
                <span class="pull-right text-muted">Not listed?
                    <a href="{{ route('merchandise.categories.create', ['redirect' => Request::fullUrl()]) }}">
                        Create new category
                    </a>
                </span>
            <select id="merchandise_category_id" name="merchandise_category_id" class="form-control">
                @foreach(\App\Models\MerchandiseCategory::all() as $category)
                    <option value="{{ $category->id }}" {!! (Route::is('merchandises.edit')) ? ((is_null($merchandise->merchandiseCategory) ?: ($merchandise->merchandiseCategory->id == $category->id)) ? 'selected' : '') : ((old('merchandise_category_id') == $category->id) ? 'selected' : '') !!}>{{ $category->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('merchandise_category_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('merchandise_category_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            <label for="price">Price:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control" id="price" name="price"
                       value="{{ number_format((Route::is('merchandises.edit')) ? $merchandise->price : old('price'), 2, '.', ',') }}"
                       pattern="^\d+\.\d{2}$" placeholder="">
            </div>

            @if ($errors->has('price'))
                <span class="help-block">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="day">Available Every:</label>
            <div class="checkbox">
                <label><input type="checkbox" value="1" name="week_day[]" id="week_day">Monday</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="2" name="week_day[]" id="week_day">Tuesday</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="3" name="week_day[]" id="week_day">Wednesday</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="4" name="week_day[]" id="week_day">Thursday</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="5" name="week_day[]" id="week_day">Friday</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="6" name="week_day[]" id="week_day">Saturday</label>
            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="7" name="week_day[]" id="week_day">Sunday</label>
            </div>
        </div>
        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">
            {{ (Route::is('merchandises.edit')) ? 'Update ' . strtolower($merchandise->name) : 'Create merchandise' }}
        </button>
    </div>
    {!! Form::close() !!}
</div>

@section('image')
    <script>
        function loadImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image-merchandise').attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection