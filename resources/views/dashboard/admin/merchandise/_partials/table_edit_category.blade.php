<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($merchandises as $merchandise)
            <tr>
                <td>
                    <a href="{{ route('merchandises.show', [$merchandise->id, 'redirect' => Request::fullUrl()]) }}">
                        {{ $merchandise->name }}
                    </a>
                </td>
                <td class="text-center">
                    {!! Form::open(['route' => ['merchandises.category', $merchandise->id], 'class' => '']) !!}
                    {!! Form::hidden('_method', 'PUT') !!}
                    <button type="submit" class="btn btn-warning btn-xs">Remove</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">{{ $merchandises->links() }}</div>