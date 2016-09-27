<html>
<head>
    <title>{{ $title }}</title>
    <style>
        .header, p {
            text-align: center;
        }

        .section {
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="header">
    <h3>{{ config('static.app.company') . ' - ' . ucfirst(config('static.app.name')) }}</h3>
    <h3>{{ config('static.app.meta.description') }}</h3>
    <h3>{{ $title }}</h3>
</div>

@if($sales->count())
    <div class="section">
        <table>
            <caption>Sales</caption>
            <tr>
                <th>Date</th>
                <th>Total</th>
            </tr>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ date('F d Y', strtotime($sale['_date'])) }}</td>
                    <td>{{ number_format($sale['_total'], 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Total Sales:</strong></td>
                <td><strong>{{ number_format(collect($sales)->pluck('_total')->sum(), 2, '.', ',') }}</strong></td>
            </tr>
        </table>
    </div>
@endif

@if($expenses->count())
    <div class="section">
        <table>
            <caption>Expenses</caption>
            <tr>
                <th>Date</th>
                <th>Total</th>
            </tr>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ date('F d Y', strtotime($expense->_date)) }}</td>
                    <td>{{ number_format($expense->_amount, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Total Expenses:</strong></td>
                <td><strong>{{ number_format(collect($expenses)->pluck('_amount')->sum(), 2, '.', ',') }}</strong></td>
            </tr>
        </table>
    </div>
@endif

@if($sales->count() || $expenses->count())
    <div class="section">
        <table>
            <caption>Total</caption>
            <tr>
                <th>Name</th>
                <th>Total</th>
            </tr>
            @if($sales->count())
                <tr>
                    <td>Sales</td>
                    <td>{{ number_format(collect($sales)->pluck('_total')->sum(), 2, '.', ',') }}</td>
                </tr>
            @endif

            @if($expenses->count())
                <tr>
                    <td>Expenses</td>
                    <td>{{ number_format(collect($expenses)->pluck('_amount')->sum(), 2, '.', ',') }}</td>
                </tr>
            @endif
            <tr>
                <td><strong>Total:</strong></td>
                <td><strong>{{ number_format(collect($sales)->pluck('_total')->sum() - collect($expenses)->pluck('_amount')->sum(), 2, '.', ',') }}</strong></td>
            </tr>
        </table>
    </div>
@else
    <p>Empty.</p>
@endif

</body>
</html>