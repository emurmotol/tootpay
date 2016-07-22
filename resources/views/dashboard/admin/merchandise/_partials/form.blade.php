<div class="row">
    {!! Form::open(['route' => (Route::is('merchandises.edit')) ? ['merchandises.update', $merchandise->id] : 'merchandises.store', 'files' => true, 'class' => '']) !!}
        @if(Route::is('merchandises.edit'))
            {{ Form::hidden('_method', 'PUT') }}
        @endif

        <div class="col-md-3">
            <div class="img-merchandise">
                <a href="#">
                    <img src="{{ \App\Models\Merchandise::image((Route::is('merchandises.edit')) ? $merchandise->id : 0) }}" id="image-merchandise"
                         class="img-responsive img-rounded" alt="{{ (Route::is('merchandises.edit')) ? $merchandise->name : 'Default Image' }}">
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                <label for="image">Upload Image:</label>
                <input type="file" onchange="readImageUrl(this);" class="form-control" id="image" name="image">

                @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ (Route::is('merchandises.edit')) ? $merchandise->name : old('name') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('merchandise_category_id') ? ' has-error' : '' }}">
                <label for="merchandise_category_id">Category:</label>
                <span class="pull-right text-muted">
                    Not listed? <a href="{{ route('merchandises.categories.create', ['redirect' => (Route::is('merchandises.edit')) ? route('merchandises.edit', $merchandise->id) : route('merchandises.create')]) }}">Create new category</a>
                </span>
                <select id="merchandise_category_id" name="merchandise_category_id" class="form-control">
                    @foreach(\App\Models\MerchandiseCategory::all() as $category)
                        <option value="{{ $category->id }}" {!! (Route::is('merchandises.edit')) ? (($merchandise->merchandiseCategory->id == $category->id) ? 'selected' : '') : ((old('merchandise_category_id') == $category->id) ? 'selected' : '') !!}>{{ $category->name }}</option>
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
                    <input type="text" class="form-control" id="price" name="price" value="{{ number_format((Route::is('merchandises.edit')) ? $merchandise->price : old('price'), 2, '.', ',') }}"
                           pattern="^\d+\.\d{2}$" placeholder="">
                </div>

                @if ($errors->has('price'))
                    <span class="help-block">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="available">{{ (Route::is('merchandises.edit')) ? 'Available' : 'Make available on create' }}?</label>
                @if(Route::is('merchandises.edit'))
                    <input type="hidden" name="available" value="off">
                @endif
                <input type="checkbox" {{ (Route::is('merchandises.edit')) ? (($merchandise->available) ? 'checked' : '') : (old('available') ?  'checked' : '') }} id="available" name="available"
                       data-toggle="toggle" data-on="Yes" data-off="No" data-onstyle="success" data-offstyle="default"
                       data-size="mini">
            </div>
            <button type="submit" class="btn btn-primary">
                {{ (Route::is('merchandises.edit')) ? 'Update ' : 'Create ' }}merchandise
            </button>
        </div>
    {!! Form::close() !!}
</div>