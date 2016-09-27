@if($expenses->count())
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ date('F d Y', strtotime($expense->_date)) }}</td>
                    <td>P{{ number_format($expense->_amount, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr class="grand-total">
                <td class="text-right">
                    <strong>Total:</strong>
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
