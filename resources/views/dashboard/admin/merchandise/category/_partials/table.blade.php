<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Count</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($merchandise_categories as $merchandise_category)
            <tr>
                <td>{{ $merchandise_category->id }}</td>
                <td><a href="{{ route('merchandises.categories.show', $merchandise_category->id) }}">{{ $merchandise_category->name }}</a></td>
                <td>{{ count(\App\Models\Merchandise::byCategory($merchandise_category->id)->get()) }}</td>
                <td>
                    {!! Form::open(['route' => ['merchandises.categories.destroy', $merchandise_category->id], 'class' => '']) !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        <a href="{{ route('merchandises.categories.edit', $merchandise_category->id) }}" class="btn btn-default btn-xs">Edit</a>
                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">{{ $merchandise_categories->links() }}</div>