@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#daily_expenses_tab">Daily</a></li>
            <li><a data-toggle="tab" href="#monthly_expenses_tab">Monthly</a></li>
            <li><a data-toggle="tab" href="#yearly_expenses_tab">Yearly</a></li>
        </ul>

        <div class="tab-content">
            <div id="daily_expenses_tab" class="tab-pane fade in active">
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
                                {{--<button class="btn btn-success btn-xs" id="export_daily_expenses">Export</button>--}}
                                @include('_partials.create', ['url' => route('expenses.create'), 'what' => 'expense'])
                                <button class="btn btn-success" id="print_daily_expenses">Export to PDF</button>
                            </div>
                            <div id="daily_expenses"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="monthly_expenses_tab" class="tab-pane fade">
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
                                {{--<button class="btn btn-success btn-xs" id="export_monthly_expenses">Export</button>--}}
                                @include('_partials.create', ['url' => route('expenses.create'), 'what' => 'expense'])
                                <button class="btn btn-success" id="print_monthly_expenses">Export to PDF</button>
                            </div>
                            <div id="monthly_expenses"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="yearly_expenses_tab" class="tab-pane fade">
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
                                {{--<button class="btn btn-success btn-xs" id="export_yearly_expenses">Export</button>--}}
                                @include('_partials.create', ['url' => route('expenses.create'), 'what' => 'expense'])
                                <button class="btn btn-success" id="print_yearly_expenses">Export to PDF</button>
                            </div>
                            <div id="yearly_expenses"></div>
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

            $('#export_daily_expenses').on("click", function () {
                exportDailyExpenses(daily.data("DateTimePicker").date().format("YYYY-MM-DD"));
            });
            $('#export_monthly_expenses').on("click", function () {
                exportMonthlyExpenses(monthly.data("DateTimePicker").date().format("YYYY-MM"));
            });
            $('#export_yearly_expenses').on("click", function () {
                exportYearlyExpenses(yearly.data("DateTimePicker").date().format("YYYY"));
            });

            $('#print_daily_expenses').on("click", function () {
                window.open("{{ url('expenses/print/daily') }}/" + daily.data("DateTimePicker").date().format("YYYY-MM-DD"), '_blank');
            });
            $('#print_monthly_expenses').on("click", function () {
                window.open("{{ url('expenses/print/monthly') }}/" + monthly.data("DateTimePicker").date().format("YYYY-MM"), '_blank');
            });
            $('#print_yearly_expenses').on("click", function () {
                window.open("{{ url('expenses/print/yearly') }}/" + yearly.data("DateTimePicker").date().format("YYYY"), '_blank');
            });

            daily.on("dp.change", function (moment) {
                dailyExpenses(moment.date.format("YYYY-MM-DD"))
            });
            monthly.on("dp.change", function (moment) {
                monthlyExpenses(moment.date.format("YYYY-MM"))
            });
            yearly.on("dp.change", function (moment) {
                yearlyExpenses(moment.date.format("YYYY"))
            });

            dailyExpenses("{{ \Carbon\Carbon::now()->toDateString() }}")
            monthlyExpenses("{{ \Carbon\Carbon::now()->format('Y-m') }}")
            yearlyExpenses("{{ \Carbon\Carbon::now()->format('Y') }}")
        });

        function exportDailyExpenses(date) {
            $.post("expenses/export/daily", {
                date: date
            }, function (response) {
                window.open("{{ url('expenses/download/daily') }}/" + response, '_blank');
            });
        }

        function exportMonthlyExpenses(month) {
            $.post("expenses/export/monthly", {
                month: month
            }, function (response) {
                window.open("{{ url('expenses/download/monthly') }}/" + response, '_blank');
            });
        }

        function exportYearlyExpenses(year) {
            $.post("expenses/export/yearly", {
                year: year
            }, function (response) {
                window.open("{{ url('expenses/download/yearly') }}/" + response, '_blank');
            });
        }

        var loading_expenses = '<div class="text-center loading-expenses"><strong>' + '{!! trans('loading.default') !!}' + '</strong></div>';

        function dailyExpenses(date) {
            var d = new Date(date);
            $("#selected_date").text(d.toDateString());
            $("#daily_expenses").html(loading_expenses);

            $.post("expenses/daily", {
                date: date
            }, function (response) {
                $("#daily_expenses").html(response);
            });
        }

        function monthlyExpenses(month) {
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
            $("#monthly_expenses").html(loading_expenses);

            $.post("expenses/monthly", {
                month: month
            }, function (response) {
                $("#monthly_expenses").html(response);
            });
        }

        function yearlyExpenses(year) {
            $("#selected_year").text(year);
            $("#yearly_expenses").html(loading_expenses);

            $.post("expenses/yearly", {
                year: year
            }, function (response) {
                $("#yearly_expenses").html(response);
            });
        }
    </script>
@endsection