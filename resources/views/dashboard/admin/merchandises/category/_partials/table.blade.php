<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th class="text-center">Manage Inventory?</th>
            <th class="text-center"># Of Entries</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>
                    <a href="{{ route('merchandise.categories.show', $category->id) }}">
                        <strong>{{ $category->name }}</strong>
                    </a>
                </td>
                <td>{{ $category->description }}</td>
                <td class="text-center">
                    {!! $category->manage_inventory ? '<strong class="text-success">Yes</strong>' : '<strong class="text-danger">No</strong>' !!}
                </td>
                <td class="text-center">{{ \App\Models\Merchandise::byCategory($category->id)->get()->count() }}</td>
                <td class="text-center">
                    {!! Form::open(['route' => ['merchandise.categories.destroy', $category->id], 'class' => '']) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    <a href="{{ route('merchandise.categories.edit', $category->id) }}" class="btn btn-default btn-xs">Edit</a>
                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">{{ $categories->links() }}</div>