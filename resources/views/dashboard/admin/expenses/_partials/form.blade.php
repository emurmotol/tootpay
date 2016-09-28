<div class="row">
    @if(request()->has('redirect'))
        {!! Form::open([
            'route' => (Route::is('expenses.edit')) ? ['expenses.update', $expense->id, 'redirect' => request()->get('redirect')] : ['expenses.store', 'redirect' => request()->get('redirect')],
            'class' => ''
        ]) !!}
    @else
        {!! Form::open([
            'route' => (Route::is('expenses.edit')) ? ['expenses.update', $expense->id] : 'expenses.store',
            'class' => ''
        ]) !!}
    @endif

    @if(Route::is('expenses.edit'))
        {!! Form::hidden('_method', 'PUT') !!}
    @endif

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Expense Name:</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ (Route::is('expenses.edit')) ? $expense->name : old('name') }}">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            <label for="amount">Amount:</label>

            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control" id="amount" name="amount"
                       value="{{ (Route::is('expenses.edit')) ? $expense->amount : old('amount') }}" placeholder="">
            </div>

            @if ($errors->has('amount'))
                <span class="help-block">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            <label for="description">Description (optional):</label>
            <textarea class="form-control" name="description" rows="3" id="description">{{ (Route::is('expenses.edit')) ? $expense->description : old('description') }}</textarea>

            @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary"
                data-loading-text="{{ trans('loading.default') }}">
            {{ (Route::is('expenses.edit')) ? 'Update ' : 'Create ' }}expense
        </button>
        @include('_partials.cancel', ['url' => route('expenses.index')])
    </div>
    {!! Form::close() !!}
</div>