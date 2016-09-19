@if($expenses->count())
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Month</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ date('F', mktime(0, 0, 0, $expense->_month)) }}</td>
                    <td>P{{ number_format($expense->_amount, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr class="grand-total">
                <td class="text-right">
                    <strong>Net Total:</strong>
                </td>
                <td>
                    <strong>P{{ number_format(collect($expenses)->pluck('_amount')->sum(), 2, '.', ',') }}</strong>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@else
    @include('_partials.empty')
@endif
