@if($expenses->count())
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->name }}</td>
                    <td>P{{ number_format($expense->amount, 2, '.', ',') }}</td>
                    <td>{{ $expense->description }}</td>
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
            </tr>
            </tbody>
        </table>
    </div>
@else
    @include('_partials.empty')
@endif
