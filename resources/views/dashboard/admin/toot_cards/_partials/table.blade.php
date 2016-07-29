<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>Toot Card ID</th>
            <th class="text-center">Cardholder</th>
            <th>Load</th>
            <th>Points</th>
            <th class="text-center">Active?</th>
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
                    @if(is_null($toot_card->users()->first()))
                        <strong>Not associated</strong>
                    @else
                        <a href="{{ route('users.show', [$toot_card->users()->first()->id, 'redirect' => Request::fullUrl()]) }}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </a>
                    @endif
                </td>
                <td>
                    P{{ number_format($toot_card->load, 2, '.', ',') }}
                </td>
                <td>
                    {{ number_format($toot_card->points, 2, '.', ',') }}
                </td>
                <td class="text-center">
                    {!! $toot_card->is_active ? '<strong class="text-success">Yes</strong>' : '<strong class="text-danger">No</strong>' !!}
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