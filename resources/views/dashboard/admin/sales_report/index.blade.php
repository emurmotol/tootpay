@extends('layouts.app')

@section('title', 'Sales Report')

@section('content')
    <div class="container">
        <div class="page-header">
            <h3>Daily Sales</h3>
        </div>
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
                        <span class="pull-right">
                            <button class="btn btn-success btn-xs">Export</button>
                        </span>
                    </div>
                    <div id="daily_sales"></div>
                </div>
            </div>
        </div>
        <div class="page-header">
            <h3>Monthly Sales</h3>
        </div>
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
                        <span class="pull-right">
                            <button class="btn btn-success btn-xs">Export</button>
                        </span>
                    </div>
                    <div id="monthly_sales"></div>
                </div>
            </div>
        </div>
        <div class="page-header">
            <h3>Yearly Sales</h3>
        </div>
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
                        <span class="pull-right">
                            <button class="btn btn-success btn-xs">Export</button>
                        </span>
                    </div>
                    <div id="yearly_sales"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('date')
    <script>
        $(function () {
            // Daily sales
            var daily = $("#daily");
            daily.datetimepicker({
                format: "YYYY-MM-DD",
                inline: true
            });

            daily.on("dp.change", function (moment) {
                dailySales(moment.date.format("YYYY-MM-DD"))
            });

            dailySales("{{ \Carbon\Carbon::now()->toDateString() }}")

            // Monthly sales
            var monthly = $("#monthly");
            monthly.datetimepicker({
                format: "YYYY-MM",
                inline: true
            });

            monthly.on("dp.change", function (moment) {
                monthlySales(moment.date.format("YYYY-MM"))
            });

            monthlySales("{{ \Carbon\Carbon::now()->format('Y-m') }}")

            // Yearly sales
            var yearly = $("#yearly");
            yearly.datetimepicker({
                format: "YYYY",
                inline: true
            });

            yearly.on("dp.change", function (moment) {
                yearlySales(moment.date.format("YYYY"))
            });

            yearlySales("{{ \Carbon\Carbon::now()->format('Y') }}")
        });

        var loading_sales = '<div class="text-center loading-sales">' + '{!! trans('loading.default') !!}' + '</div>';

        function yearlySales(year) {
            $("#selected_year").text(year);
            $("#yearly_sales").html(loading_sales);
            console.log(year);
            $.post("yearly_sales", {
                year: year
            }, function (response) {
                $("#yearly_sales").html(response);
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
            console.log(month);
            $.post("monthly_sales", {
                month: month
            }, function (response) {
                $("#monthly_sales").html(response);
            });
        }

        function dailySales(date) {
            var d = new Date(date);
            $("#selected_date").text(d.toDateString());
            $("#daily_sales").html(loading_sales);
            console.log(date);
            $.post("daily_sales", {
                date: date
            }, function (response) {
                $("#daily_sales").html(response);
            });
        }
    </script>
@endsection