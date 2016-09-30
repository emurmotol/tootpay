@if($sales->count())
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Count</th>
                <th>Type</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    @if(filter_var($sale['_item'], FILTER_VALIDATE_INT))
                        <td>
                            <strong>{{ \App\Models\Merchandise::find($sale['_item'])->name }}</strong>
                        </td>
                        <td>{{ $sale['_count'] }}</td>
                        <td>Order</td>
                    @else
                        <td><strong>{{ $sale['_item'] }}</strong></td>
                        <td>{{ $sale['_count'] }}</td>
                        <td>Transaction</td>
                    @endif
                    <td><strong>P{{ number_format($sale['_total'], 2, '.', ',') }}</strong></td>
                </tr>
            @endforeach
            <tr class="grand-total">
                <td></td>
                <td></td>
                <td class="text-right">
                    <strong>Total:</strong>
                </td>
                <td>
                    <strong>P{{ number_format(collect($sales)->pluck('_total')->sum(), 2, '.', ',') }}</strong>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@else
    @include('_partials.empty')
@endif
