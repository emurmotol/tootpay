@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#daily_sales_tab">Daily</a></li>
            <li><a data-toggle="tab" href="#monthly_sales_tab">Monthly</a></li>
            <li><a data-toggle="tab" href="#yearly_sales_tab">Yearly</a></li>
        </ul>

        <div class="tab-content">
            <div id="daily_sales_tab" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-3">
                        <div id="daily" class="calendar">
                            <input type="hidden">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                <span class="pull-left" id="selected_date"></span>
                                <span class="pull-right"></span>
                            </div>
                            <div class="panel-body">
                                {{--<button class="btn btn-success btn-xs" id="export_daily_sales">Export</button>--}}
                                <button class="btn btn-success" id="print_daily_sales">Generate sales report</button>
                            </div>
                            <div id="daily_sales"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="monthly_sales_tab" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-3">
                        <div id="monthly" class="calendar">
                            <input type="hidden">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                <span class="pull-left" id="selected_month"></span>
                                <span class="pull-right"></span>
                            </div>
                            <div class="panel-body">
                                {{--<button class="btn btn-success btn-xs" id="export_monthly_sales">Export</button>--}}
                                <button class="btn btn-success" id="print_monthly_sales">Generate sales report</button>
                            </div>
                            <div id="monthly_sales"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="yearly_sales_tab" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-3">
                        <div id="yearly" class="calendar">
                            <input type="hidden">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="panel panel-primary">
                            <div class="panel-heading clearfix">
                                <span class="pull-left" id="selected_year"></span>
                                <span class="pull-right"></span>
                            </div>
                            <div class="panel-body">
                                {{--<button class="btn btn-success btn-xs" id="export_yearly_sales">Export</button>--}}
                                <button class="btn btn-success" id="print_yearly_sales">Generate sales report</button>
                            </div>
                            <div id="yearly_sales"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('date')
    <script>
        $(function () {
            var daily = $("#daily");
            daily.datetimepicker({
                format: "YYYY-MM-DD",
                inline: true
            });
            var monthly = $("#monthly");
            monthly.datetimepicker({
                format: "YYYY-MM",
                inline: true
            });
            var yearly = $("#yearly");
            yearly.datetimepicker({
                format: "YYYY",
                inline: true
            });

            $('#export_daily_sales').on("click", function () {
                exportDailySales(daily.data("DateTimePicker").date().format("YYYY-MM-DD"));
            });
            $('#export_monthly_sales').on("click", function () {
                exportMonthlySales(monthly.data("DateTimePicker").date().format("YYYY-MM"));
            });
            $('#export_yearly_sales').on("click", function () {
                exportYearlySales(yearly.data("DateTimePicker").date().format("YYYY"));
            });

            $('#print_daily_sales').on("click", function () {
                window.open("{{ url('sales_report/print/daily') }}/" + daily.data("DateTimePicker").date().format("YYYY-MM-DD"), '_blank');
            });
            $('#print_monthly_sales').on("click", function () {
                window.open("{{ url('sales_report/print/monthly') }}/" + monthly.data("DateTimePicker").date().format("YYYY-MM"), '_blank');
            });
            $('#print_yearly_sales').on("click", function () {
                window.open("{{ url('sales_report/print/yearly') }}/" + yearly.data("DateTimePicker").date().format("YYYY"), '_blank');
            });

            daily.on("dp.change", function (moment) {
                dailySales(moment.date.format("YYYY-MM-DD"))
            });
            monthly.on("dp.change", function (moment) {
                monthlySales(moment.date.format("YYYY-MM"))
            });
            yearly.on("dp.change", function (moment) {
                yearlySales(moment.date.format("YYYY"))
            });

            dailySales("{{ \Carbon\Carbon::now()->toDateString() }}")
            monthlySales("{{ \Carbon\Carbon::now()->format('Y-m') }}")
            yearlySales("{{ \Carbon\Carbon::now()->format('Y') }}")
        });

        function exportDailySales(date) {
            $.post("sales_report/export/daily", {
                date: date
            }, function (response) {
                window.open("{{ url('sales_report/download/daily') }}/" + response, '_blank');
            });
        }

        function exportMonthlySales(month) {
            $.post("sales_report/export/monthly", {
                month: month
            }, function (response) {
                window.open("{{ url('sales_report/download/monthly') }}/" + response, '_blank');
            });
        }

        function exportYearlySales(year) {
            $.post("sales_report/export/yearly", {
                year: year
            }, function (response) {
                window.open("{{ url('sales_report/download/yearly') }}/" + response, '_blank');
            });
        }

        var loading_sales = '<div class="text-center loading-sales"><strong>' + '{!! trans('loading.default') !!}' + '</strong></div>';

        function dailySales(date) {
            var d = new Date(date);
            $("#selected_date").text(d.toDateString());
            $("#daily_sales").html(loading_sales);

            $.post("sales_report/daily", {
                date: date
            }, function (response) {
                $("#daily_sales").html(response);
            });
        }

        function monthlySales(month) {
            var d = new Date(month);
            var months = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ];
            var selected_month = months[d.getMonth()];

            $("#selected_month").text(selected_month);
            $("#monthly_sales").html(loading_sales);

            $.post("sales_report/monthly", {
                month: month
            }, function (response) {
                $("#monthly_sales").html(response);
            });
        }

        function yearlySales(year) {
            $("#selected_year").text(year);
            $("#yearly_sales").html(loading_sales);

            $.post("sales_report/yearly", {
                year: year
            }, function (response) {
                $("#yearly_sales").html(response);
            });
        }
    </script>
@endsection