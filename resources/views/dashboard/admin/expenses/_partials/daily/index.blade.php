@if($expenses->count())
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Amount</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->name }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>P{{ number_format($expense->amount, 2, '.', ',') }}</td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['expenses.destroy', $expense->id], 'class' => '']) !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-default btn-xs">Edit</a>
                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            <tr class="grand-total">
                <td></td>
                <td class="text-right">
                    <strong>Net Total:</strong>
                </td>
                <td>
                    <strong>P{{ number_format(collect($expenses)->pluck('amount')->sum(), 2, '.', ',') }}</strong>
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
@else
    @include('_partials.empty')
@endif
