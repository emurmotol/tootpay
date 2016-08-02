{!! Form::open(['url' => Request::fullurl(), 'method' => 'GET', 'class' => 'form-inline', 'id' => 'search-form']) !!}
    <div class="input-group">
        <input type="text" id="search" name="search" class="form-control" placeholder="Search {!! $what !!}" value="{{ request()->get('search') }}">
        <div class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </div>
    </div>
{!! Form::close() !!}