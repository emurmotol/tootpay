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

@if($expenses->count())
    <div class="section">
        <table>
            <tr>
                <th>Month</th>
                <th>Total</th>
            </tr>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ date('F', mktime(0, 0, 0, $expense->_month)) }}</td>
                    <td>{{ number_format($expense->_amount, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total Expenses:</td>
                <td>{{ number_format(collect($expenses)->pluck('_amount')->sum(), 2, '.', ',') }}</td>
            </tr>
        </table>
    </div>
@else
    <p>Empty</p>
@endif

</body>
</html>