{!! Form::open(['url' => Request::fullurl(), 'method' => 'GET', 'class' => 'form-inline', 'id' => 'search-form']) !!}
    <div class="form-group">
        <input type="text" id="search" name="search" class="form-control" placeholder="Search {!! $what !!}" value="{{ request()->get('search') }}">
    </div>
    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
{!! Form::close() !!}