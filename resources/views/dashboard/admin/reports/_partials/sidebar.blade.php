<div class="panel panel-primary">
    <div class="panel-heading">Sales Report</div>

    <ul class="list-group">
        <a href="{{ route('sales_report.daily') }}" class="list-group-item {!! Route::is('sales_report.daily') ? 'active' : '' !!}">
            Daily Sales <span class="badge">{{ date("l", strtotime(\Carbon\Carbon::now())) }}</span>
        </a>
        <a href="{{ route('sales_report.weekly') }}" class="list-group-item {!! Route::is('sales_report.weekly') ? 'active' : '' !!}">
            Weekly Sales <span class="badge">{{ date("W", strtotime(\Carbon\Carbon::now())) }}</span>
        </a>
        <a href="{{ route('sales_report.monthly') }}" class="list-group-item {!! Route::is('sales_report.monthly') ? 'active' : '' !!}">
            Monthly Sales <span class="badge">{{ date("M", strtotime(\Carbon\Carbon::now())) }}</span>
        </a>
        <a href="{{ route('sales_report.yearly') }}" class="list-group-item {!! Route::is('sales_report.yearly') ? 'active' : '' !!}">
            Yearly Sales <span class="badge">{{ date("Y", strtotime(\Carbon\Carbon::now())) }}</span>
        </a>
    </ul>
</div>