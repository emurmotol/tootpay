<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Toot Card ID</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($toot_cards as $toot_card)
            <tr>
                <td>
                    <a href="{{ route('toot_cards.show', [$toot_card->id, 'redirect' => Request::fullUrl()]) }}">
                        <strong>{{ $toot_card->id }}</strong>
                    </a>
                </td>
                <td class="text-center">
                    {!! Form::open(['route' => ['toot_cards.destroy', $toot_card->id], 'class' => '']) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    <a href="{{ route('toot_cards.edit', $toot_card->id) }}" class="btn btn-default btn-xs">Edit</a>
                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="text-center">{{ $toot_cards->links() }}</div>