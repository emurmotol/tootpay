<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Role</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>
                    <strong>{{ $user->id }}</strong>
                </td>
                <td>
                    <a href="{{ route('users.show', [$user->id, 'redirect' => Request::fullUrl()]) }}">
                        <strong>{{ $user->name }}</strong>
                    </a>
                </td>
                <td>
                    {{ $user->roles()->first()->name }}
                </td>
                <td class="text-center">
                    {!! Form::open(['route' => ['users.destroy', $user->id], 'class' => '']) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-default btn-xs">Edit</a>
                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">{{ $users->links() }}</div>