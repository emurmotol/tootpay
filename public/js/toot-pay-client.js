var loading = $('#loading');

$('#toot_idle').on('click', function () {
    $('#menu').modal('show');
    console.log('showing menu modal');
});

$('#enter_pin').on('hidden.bs.modal', function () {
    // console.log('page reloading!');
    // location.reload();
});
$('#check_balance').on('hidden.bs.modal', function () {
    console.log('page reloading!');
    location.reload();
});
$('#invalid_card').on('hidden.bs.modal', function () {
    console.log('page reloading!');
    location.reload();
});

var pin_code = $('#pin_code');
var load_amount = $('#load_amount');
var enter_load_amount = $('#enter_load_amount');
$('.backspace').click(function () {

    if ($('#enter_pin').hasClass('in')) {
        pin_code.val(function (index, value) {
            return value.substr(0, value.length - 1);
        });
    }

    if (enter_load_amount.hasClass('in')) {
        load_amount.val(function (index, value) {
            return value.substr(0, value.length - 1);
        });
    }
});
$('.key').on('click', function () {

    if ($('#enter_pin').hasClass('in')) {
        pin_code.val((pin_code.val()) + (this.value));
    }

    if (enter_load_amount.hasClass('in')) {
        load_amount.val((load_amount.val()) + (this.value));
    }
});

var menu_id = $('#menu_id');
$('#menu_reload').on('click', function () {
    $('#menu').modal('toggle');
    $('#enter_load_amount').modal('show');
    console.log('showing enter_load_amount modal');
    menu_id.val(1);
    console.log('menu_id set to 1!');
});
$('#menu_balance').on('click', function () {
    $('#menu').modal('toggle');
    $('#tap_card').modal('show');
    console.log('showing tap_card modal');
    menu_id.val(2);
    console.log('menu_id set to 2!');
});
$('#menu_order').on('click', function () {
    $('.modal-body p #loading_text').text('Loading yummy food options');
    $('#loading').modal('show');
    console.log('showing loading modal');
    $('#menu').modal('toggle');
    console.log('route to order!');
    window.location.replace('http://toot.pay/client/');
});

var toot_card_id = $('#toot_card_id');
toot_card_id.focus();
toot_card_id.blur(function () {
    setTimeout(function () {
        toot_card_id.focus();
    }, 0);
});
toot_card_id.change(function () {

    if ($(this).val().length == 10) {

        $.post('check_toot_card', {
            toot_card: $(this).val()
        }, function (response) {
            $('#tap_card').modal('toggle');

            if (response == 'valid') {
                $('#id').val(toot_card_id.val());
                $('#enter_pin').modal('show');
                console.log('showing enter_pin modal');
            } else {
                setTimeout(function () {
                    console.log('page reloading!');
                    location.reload();
                }, 2000);
                $('#invalid_card').modal('show');
                console.log('showing invalid_card modal');
            }
            console.log(toot_card_id.val() + ' is ' + response + '!');
        });
    }
});

$('#tap_card').on('shown.bs.modal', function () {
    toot_card_id.focus();
    console.log('toot_card_id is on focus!');
});

$('.submit-check').on('click', function () {
    $(this).button('loading').delay(1000).queue(function () {
        $(this).button('reset');
        $(this).dequeue();
    });

    if ($('#enter_pin').hasClass('in')) {

        if (pin_code.val().length < 1) {
            $('#empty_pin').modal({backdrop: false});
            console.log('showing empty_pin modal');
        } else {
            $.post('auth_toot_card', {
                id: $('#id').val(),
                pin_code: pin_code.val()
            }, function (response) {

                if (response == 'correct') {
                    console.log('correct pin!');
                    $('#enter_pin').modal('toggle');

                    if (menu_id.val() == 1) {
                        $('.modal-body p #loading_text').text('Please wait');
                        $('#loading').modal('show');

                        $.post('reload_pending', {
                            id: $('#id').val(),
                            amount: load_amount.val()
                        }, function (response) {

                            if (response != null) {
                                console.log('reload_id is ' + response + '!');
                                var waiting_for_payment = $('#waiting_for_payment');

                                var interval = setInterval(function () {
                                    $.post('reload_status', {
                                        id: $('#id').val(),
                                        reload_id: response
                                    }, function (response) {

                                        if (response == 'pending') {

                                            if (!waiting_for_payment.hasClass('in')) {
                                                $('#loading').modal('toggle');
                                                $('#_amount').text(load_amount.val());
                                                console.log('_amount is set to ' + load_amount.val() + '!');

                                                setTimeout(function () {
                                                    console.log('page reloading!');
                                                    location.reload();
                                                }, 60000);
                                                waiting_for_payment.modal({backdrop: 'static'});
                                                console.log('showing waiting_for_payment modal');
                                            }
                                        } else {
                                            $('#waiting_for_payment').modal('toggle');
                                            clearInterval(interval);

                                            if (response == 'paid') {
                                                $('#reload_paid').modal('show');
                                                console.log('showing reload_paid modal');

                                                $.post('check_balance', {id: $('#id').val()}, function (response) {
                                                    $('#toot_card_details').html(response);
                                                }).done(function () {
                                                    setTimeout(function () {
                                                        console.log('page reloading!');
                                                        location.reload();
                                                    }, 30000);

                                                    $('#reload_paid').modal('toggle');
                                                    $('#check_balance').modal('show');
                                                    console.log('showing check_balance modal');
                                                });
                                            } else if (response == 'canceled') {
                                                setTimeout(function () {
                                                    console.log('page reloading!');
                                                    location.reload();
                                                }, 5000);

                                                $('#reload_canceled').modal('show');
                                                console.log('showing reload_canceled modal');
                                            }
                                        }
                                        console.log('reload status is ' + response + '!');
                                    });
                                }, 1000);
                            }
                        });
                    } else if (menu_id.val() == 2) {
                        $.post('check_balance', {id: $('#id').val()}, function (response) {
                            $('#toot_card_details').html(response);
                        }).done(function () {
                            setTimeout(function () {
                                console.log('page reloading!');
                                location.reload();
                            }, 30000);

                            $('#check_balance').modal('show');
                            console.log('showing check_balance modal');
                        });
                    } else if (menu_id.val() == 3) {
                        var table_data = [];

                        $('tr.row-order').each(function () {
                            var qty = parseFloat($('span.qty', this).text());
                            var each_value = $('span.each', this);
                            var each = parseFloat(each_value.text());
                            var total = qty * each;
                            var item = {};
                            item['toot_card_id'] = $('#id').val();
                            item['merchandise_id'] = $(this).data('merchandise_id');
                            item['quantity'] = qty;
                            item['total'] = total;

                            table_data.push(item);
                        });

                        console.log(JSON.stringify(table_data));

                        $.post('purchase',
                            { table_data: JSON.stringify(table_data) },
                            function (response) {
                                console.log(response);
                            });
                    }
                } else if (response == 'incorrect') {
                    console.log('incorrect pin!');
                    $('#wrong_pin').modal({backdrop: false});
                    console.log('showing wrong_pin modal');
                }
            });
        }
    }

    if (enter_load_amount.hasClass('in')) {

        if (load_amount.val().length < 1) {
            $('#empty_load_amount').modal('show');
            console.log('showing empty_load_amount modal');
        } else {
            enter_load_amount.modal('toggle');
            $('#tap_card').modal('show');
            console.log('showing tap_card modal');
        }
    }
});

$('#btn_cancel').on('click', function () {
    $(this).button('loading').delay(2000).queue(function () {
        $(this).button('reset');
        $(this).dequeue();
    });
    window.location.href = 'http://toot.pay/client/idle';
});
$('#btn_pay_using_toot_card').on('click', function () {
    menu_id.val(3);
    console.log('menu_id set to 3!');
    $('#tap_card').modal('show');
});
$('#btn_pay_using_cash').on('click', function () {
    alert('cash');
});

function todaysMenu() {
    $.post('todays_menu', function (response) {
        $('#todays_menu').html(response);

        $('.modal-footer').on('click', 'button.btn-add-order', function () {
            var merchandise_id = $(this).data('merchandise_id');
            var name = $(this).data('name');
            var price = $(this).data('price');
            var id = $(this).data('id');
            var qty = $('#' + id + ' .modal-dialog .modal-content .modal-body .col-md-6 span.qty').text();
            addOrder(merchandise_id, name, price, qty);
        });

        var modal_qty = $('.modal-body .row .col-md-6');
        modal_qty.on('click', 'button.plus', function () {
            var qty = parseInt($(this).prev('span.qty').text());
            $(this).prev('span.qty').text(qty + 1);
            compute();
            return false;
        });
        modal_qty.on('click', 'button.minus', function () {
            var qty = parseInt($(this).next('span.qty').text());
            $(this).next('span.qty').text(((qty - 1) < 1) ? 1 : qty - 1);
            compute();
            return false;
        });
    });
}

$(function () {
    todaysMenu();

    window.addOrder = (function (merchandise_id, name, price, qty) {
        $('#table_orders').append(
            '<tr class="row-order" data-merchandise_id="'+ merchandise_id + '">' +
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
            var qty = parseInt($(this).prev('span.qty').text());
            $(this).prev('span.qty').text(qty + 1);
            compute();
            return false;
        });
        row_order.on('click', 'td button.minus', function () {
            var qty = parseInt($(this).next('span.qty').text());
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
            $('#btn_pay_using_toot_card').attr('disabled', 'disabled');
            $('#btn_pay_using_cash').attr('disabled', 'disabled');
        } else {
            $('#btn_pay_using_toot_card').removeAttr('disabled');
            $('#btn_pay_using_cash').removeAttr('disabled');
        }
    });
});

(function ($) {
    $.fn.blink = function (options) {
        var defaults = {delay: 500};
        var options = $.extend(defaults, options);
        return $(this).each(function (idx, itm) {
            setInterval(function () {
                if ($(itm).css("visibility") === "visible") {
                    $(itm).css('visibility', 'hidden');
                }
                else {
                    $(itm).css('visibility', 'visible');
                }
            }, options.delay);
        });
    }
}(jQuery));

$('#touch').blink();