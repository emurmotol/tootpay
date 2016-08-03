@extends('layouts.app')

@section('title', 'Client Order')

@section('content')
    <div class="client-order">
        <div class="col-md-6">
            @include('dashboard.client._partials.orders', [
                'customer_name' => Auth::check() ? Auth::user()->name : 'Guest',
                'order_id' => rand(100, 999)
             ])
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">
                    <span class="pull-left">
                        <strong>Today's Menu</strong>
                    </span>
                    <span class="pull-right">
                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="panel-body merchandise-list" id="todays_menu"></div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        setTimeout(function () {
            window.location.href = '{{ route('client.idle') }}';
        }, 120000);

        $('#btn_cancel').on('click', function () {
            $(this).button('loading').delay(5000).queue(function() {
                $(this).button('reset');
                $(this).dequeue();
            });
            $.get('{{ url('logout') }}', function () {
                window.location.href = '{{ route('client.idle') }}';
            });
        });

        function todaysMenu() {
            $.post('todays_menu', function (response) {

                $('#todays_menu').html(response);
                setTimeout(todaysMenu, 60000);

                $('.modal-footer').on('click', 'button.btn-add-order', function () {
                    var name = $(this).data('name');
                    var price = $(this).data('price');
                    var id = $(this).data('id');
                    var qty = $('#' + id + ' .modal-dialog .modal-content .modal-body .col-md-6 span.qty').text();
                    addOrder(name, price, qty);
                });

                var modal_qty = $('.modal-body .row .col-md-6');
                modal_qty.on('click', 'button.plus', function () {
                    var qty = parseFloat($(this).prev('span.qty').text());
                    $(this).prev('span.qty').text(qty + 1);
                    compute();
                    return false;
                });
                modal_qty.on('click', 'button.minus', function () {
                    var qty = parseFloat($(this).next('span.qty').text());
                    $(this).next('span.qty').text(((qty - 1) < 1) ? 1 : qty - 1);
                    compute();
                    return false;
                });
            });
        }

        $(function () {
            todaysMenu();

            window.addOrder = (function (name, price, qty) {
                $('#table_orders').append(
                        '<tr class="row-order">' +
                        '<td><span class="name">' + name + '</span></td>' +
                        '<td class="text-center table-cell-qty">' +
                        '<button class="btn btn-default btn-sm minus"><i class="fa fa-minus"></i></button>' +
                        '<span class="qty">' + qty + '</span>' +
                        '<button class="btn btn-default btn-sm plus"><i class="fa fa-plus"></i></button>' +
                        '</td>' +
                        '<td>P<span class="each">' + price + '</span></td>' +
                        '<td>P<span class="total"></span></td>' +
                        '<td class="text-center"><button class="btn btn-danger btn-sm remove"><i class="fa fa-remove"></i></button></td>' +
                        '</tr>'
                );
                compute();

                var row_order = $('#table_orders tr.row-order');
                row_order.on('click', 'td button.plus', function () {
                    var qty = parseFloat($(this).prev('span.qty').text());
                    $(this).prev('span.qty').text(qty + 1);
                    compute();
                    return false;
                });
                row_order.on('click', 'td button.minus', function () {
                    var qty = parseFloat($(this).next('span.qty').text());
                    $(this).next('span.qty').text(((qty - 1) < 1) ? 1 : qty - 1);
                    compute();
                    return false;
                });
                row_order.on('click', 'button.remove', function () {
                    $(this).closest('tr').remove();
                    compute();
                    return false;
                });
            });

            window.compute = (function () {
                var grand_total = 0.00;
                var decimal_place = 2;
                var row_count = $('#table_orders tbody tr.row-order').length;
                var user = '{{ Auth::check() }}';

                if(user != '') {
                    var sub_total = 0.00;
                    $('tr.row-order').each(function () {
                        var qty = parseFloat($('span.qty', this).text());
                        var each_value = $('span.each', this);
                        var each = parseFloat(each_value.text());
                        each_value.text(each.toFixed(decimal_place));
                        var total = qty * each;
                        $('span.total', this).text(total.toFixed(decimal_place));
                        sub_total += total;
                    });
                    var discount_value = $('#discount');
                    var discount = parseFloat(discount_value.text());
                    discount_value.text(discount.toFixed(decimal_place));
                    $('#sub_total').text(sub_total.toFixed(decimal_place));
                    grand_total = sub_total - discount;
                    $("#grand_total").text(grand_total.toFixed(decimal_place));

                    if (row_count < 1) {
                        $('#btn_discount').attr('disabled', 'disabled');
                        $('#btn_pay').attr('disabled', 'disabled');
                    } else {
                        $('#btn_discount').removeAttr('disabled');
                        $('#btn_pay').removeAttr('disabled');
                    }
                } else {
                    $('tr.row-order').each(function () {
                        var qty = parseFloat($('span.qty', this).text());
                        var each_value = $('span.each', this);
                        var each = parseFloat(each_value.text());
                        each_value.text(each.toFixed(decimal_place));
                        var total = qty * each;
                        $('span.total', this).text(total.toFixed(decimal_place));
                        grand_total += total;
                    });
                    $("#grand_total").text(grand_total.toFixed(decimal_place));

                    if (row_count < 1) {
                        $('#btn_pay').attr('disabled', 'disabled');
                    } else {
                        $('#btn_pay').removeAttr('disabled');
                    }
                }
            });
        });
    </script>
@endsection