@if($sales->count())
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>
                        @if(filter_var($sale['item'], FILTER_VALIDATE_INT))
                            <a href="{{ route('merchandises.show', [$sale['item'], 'redirect' => Request::fullUrl()]) }}">
                                <strong>{{ \App\Models\Merchandise::find($sale['item'])->name }}</strong>
                            </a>
                        @else
                            <strong>{{ $sale['item'] }}</strong>
                        @endif
                    </td>
                    <td>{{ $sale['_quantity'] }}</td>
                    <td>P{{ number_format($sale['_total'], 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="text-right">
                    <strong>Net Total:</strong>
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
