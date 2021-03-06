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
                <img src="{{ (new \App\Models\Merchandise())->image((Route::is('merchandises.edit')) ? $merchandise->id : 0) }}"
                     id="image-merchandise"
                     class="img-responsive img-rounded"
                     alt="{{ (Route::is('merchandises.edit')) ? $merchandise->name : 'Default Merchandise Image' }}">
            </a>
        </div>
    </div>
    <div class="col-md-6">
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

        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
            <label for="category_id">Category:</label>
                <span class="pull-right text-muted">Not listed?
                    <a href="{{ route('merchandise.categories.create', ['redirect' => Request::fullUrl()]) }}">
                        Create new category
                    </a>
                </span>
            <select id="category_id" name="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {!! (Route::is('merchandises.edit')) ? ((is_null($merchandise->category) ?: ($merchandise->category->id == $category->id)) ? 'selected' : '') : ((old('category_id') == $category->id) ? 'selected' : '') !!}>{{ $category->name }}</option>
                @endforeach
            </select>

            @if ($errors->has('category_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
            <label for="price">Price:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control" id="price" name="price"
                       value="{{ (Route::is('merchandises.edit')) ? $merchandise->price : old('price') }}" placeholder="">
            </div>

            @if ($errors->has('price'))
                <span class="help-block">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="day">Available Every:</label>

            @if (Route::is('merchandises.edit'))
                @foreach($operation_days as $day)
                    <div class="checkbox">
                        <label><input type="checkbox" value="{{ $day->id }}" name="day[]" id="day"
                                    {{ in_array($day->id, $merchandise->operationDays()->getRelatedIds()->all()) ? 'checked' : '' }}>{{ $day->day }}
                        </label>
                    </div>
                @endforeach
            @else
                @foreach($operation_days as $day)
                    <div class="checkbox">
                        <label><input type="checkbox" value="{{ $day->id }}" name="day[]" id="day"
                                    {{ !is_null(old('day')) ? (in_array($day->id, old('day')) ? 'checked' : '') : '' }}>{{ $day->day }}
                        </label>
                    </div>
                @endforeach
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="{{ trans('loading.default') }}">
            {{ (Route::is('merchandises.edit')) ? 'Update' : 'Create' }} merchandise
        </button>
        @include('_partials.cancel', ['url' => route('merchandises.index')])
    </div>
    {!! Form::close() !!}
</div>

@section('image')
    <script>
        function loadImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#image-merchandise").attr("src", e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection