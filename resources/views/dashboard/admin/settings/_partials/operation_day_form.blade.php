<div class="row">
    {!! Form::open(['route' => 'settings.update_operation_day', 'class' => '']) !!}
    {{ Form::hidden('_method', 'PUT') }}

    <div class="col-md-6">
        <div class="form-group">
            <label for="day">Has operation every:</label>

            @foreach(\App\Models\OperationDay::all() as $day)
                <div class="checkbox">
                    <label><input type="checkbox" value="{{ $day->id }}" name="day[]" id="day" {{ $day->has_operation ? 'checked' : '' }}>{{ $day->day }}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" id="btn-submit" class="btn btn-primary" data-loading-text="{{ trans('loading.default') }}">Save</button>
    </div>
    {!! Form::close() !!}
</div>