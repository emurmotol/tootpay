<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th class="text-center"># of Entries</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($merchandise_categories as $merchandise_category)
            <tr>
                <td>
                    <a href="{{ route('merchandise.categories.show', $merchandise_category->id) }}">
                        <strong>{{ $merchandise_category->name }}</strong>
                    </a>
                </td>
                <td class="text-center">{{ $merchandise_category->number_of_entries }}</td>
                <td class="text-center">
                    {!! Form::open(['route' => ['merchandise.categories.destroy', $merchandise_category->id], 'class' => '']) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    <a href="{{ route('merchandise.categories.edit', $merchandise_category->id) }}" class="btn btn-default btn-xs">Edit</a>
                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">{{ $merchandise_categories->links() }}</div>