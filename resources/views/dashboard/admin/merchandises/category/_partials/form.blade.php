<div class="row">
    @if(request()->has('redirect'))
        {!! Form::open([
            'route' => (Route::is('merchandise.categories.edit')) ? ['merchandise.categories.update', $category->id, 'redirect' => request()->get('redirect')] : ['merchandise.categories.store', 'redirect' => request()->get('redirect')],
            'class' => ''
        ]) !!}
    @else
        {!! Form::open([
            'route' => (Route::is('merchandise.categories.edit')) ? ['merchandise.categories.update', $category->id] : 'merchandise.categories.store',
            'class' => ''
        ]) !!}
    @endif

    @if(Route::is('merchandise.categories.edit'))
        {!! Form::hidden('_method', 'PUT') !!}
    @endif

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Category Name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ (Route::is('merchandise.categories.edit')) ? $category->name : old('name') }}">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" name="description"
                   value="{{ (Route::is('merchandise.categories.edit')) ? $category->description : old('description') }}">

            @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="{{ trans('loading.default') }}">
            {{ (Route::is('merchandise.categories.edit')) ? 'Update ' : 'Create ' }}category
        </button>
    </div>
    {!! Form::close() !!}
</div>