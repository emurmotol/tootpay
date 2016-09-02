<li {!! ((Route::is('sales_report.index') || Request::is('sales_report/*')) ? 'class="active"' : '') !!}>
    <a href="{{ route('sales_report.index') }}">Sales Report</a>
</li>