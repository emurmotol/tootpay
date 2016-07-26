<div class="row">
    @if(request()->has('redirect'))
        {!! Form::open([
            'route' => (Route::is('merchandise.categories.edit')) ? ['merchandise.categories.update', $merchandise_category->id, 'redirect' => request()->get('redirect')] : ['merchandise.categories.store', 'redirect' => request()->get('redirect')],
            'class' => ''
        ]) !!}
    @else
        {!! Form::open([
            'route' => (Route::is('merchandise.categories.edit')) ? ['merchandise.categories.update', $merchandise_category->id] : 'merchandise.categories.store',
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
                   value="{{ (Route::is('merchandise.categories.edit')) ? $merchandise_category->name : old('name') }}">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">
            {{ (Route::is('merchandise.categories.edit')) ? 'Update ' : 'Create ' }}category
        </button>
    </div>
    {!! Form::close() !!}
</div>