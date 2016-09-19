<!doctype html>
<html>
<head>
    <title>Document</title>
    <style>
        .header {
            text-align: center;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        #total_text {
            text-align: right;
        }
    </style>
</head>
<body>

<div class="header">
    <h3>{{ config('static.app.company') . ' - ' . ucfirst(config('static.app.name')) }}</h3>
    <h3>{{ config('static.app.meta.description') }}</h3>
    <h3>Sales Report</h3>
</div>

<table>
    <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Age</th>
    </tr>
    <tr>
        <td>Jill</td>
        <td>Smith</td>
        <td>50</td>
    </tr>
    <tr>
        <td>Eve</td>
        <td>Jackson</td>
        <td>94</td>
    </tr>
    <tr>
        <td>John</td>
        <td>Doe</td>
        <td>80</td>
    </tr>
    <tr>
        <td colspan="2" id="total_text">Total:</td>
        <td>P90.00</td>
    </tr>
</table>

</body>
</html>