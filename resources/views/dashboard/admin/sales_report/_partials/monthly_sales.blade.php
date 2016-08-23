@if(count($merchandise_purchase))
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merchandise_purchase as $purchase)
                <tr>
                    <td>{{ date('F d Y', strtotime($purchase->date)) }}</td>
                    <td>P{{ number_format($purchase->sales, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-right">
                    <strong>Net Total:</strong>
                </td>
                <td>
                    <strong>P{{ number_format(collect($merchandise_purchase)->pluck('sales')->sum(), 2, '.', ',') }}</strong>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@else
    @include('_partials.empty')
@endif
