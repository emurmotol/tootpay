<li {!! ((Route::is('sales_report.daily') || Request::is('sales_report/daily/*')) ? 'class="active"' : '') !!}>
    <a href="{{ route('sales_report.daily') }}">Sales Report</a>
</li>