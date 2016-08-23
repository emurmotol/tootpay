@if(count($merchandise_purchase))
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Sellouts</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($merchandise_purchase as $purchase)
                <tr>
                    <td>
                        <a href="{{ route('merchandises.show', [$purchase->merchandise, 'redirect' => Request::fullUrl()]) }}">
                            <strong>{{ \App\Models\Merchandise::find($purchase->merchandise)->name }}</strong>
                        </a>
                    </td>
                    <td>{{ $purchase->qty }}</td>
                    <td>P{{ number_format($purchase->sales, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
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
