<script>
    // button
    var btn_cancel = $('#btn_cancel');
    var btn_hold = $('#btn_hold');
    var btn_pay_using_toot_card = $('#btn_pay_using_toot_card');
    var btn_pay_using_cash = $('#btn_pay_using_cash');

    // input
    var last_resort = $('#last_resort');
    var idle_toot_card_id = $('#idle_toot_card_id');
    var pin_code = $('#pin_code');
    var toot_card_id = $('#toot_card_id');
    var _toot_card_id = $('#_toot_card_id');
    var user_id = $('#user_id');

    // div
    var validation_content = $('#validation_content');

    // modal
    var _validation = $('#validation');
    var _modal = $('.modal');
    var menu = $('#menu');
    var undone_orders = $('#undone_orders');
    var load_amount = $('#load_amount');
    var enter_load_amount = $('#enter_load_amount');
    var enter_pin = $('#enter_pin');
    var enter_user_id = $('#enter_user_id');
    var loading = $('#loading');
    var transaction_complete_with_queue_number = $('#transaction_complete_with_queue_number');
    var check_balance = $('#check_balance');
    var tap_card = $('#tap_card');

    // database values
    var _transaction_id = parseInt('{{ Request::has('transaction_id') ? Request::get('transaction_id') : 0  }}');

    // timer
    var timeout_long = 60000;
    var timeout_short = 1500;
    var _timer;

    // menu
    var menu_reload_toot_card = $('#menu_reload_toot_card');
    var menu_check_balance = $('#menu_check_balance');
    var menu_order_food = $('#menu_order_food');
    var menu_share_a_load = $('#menu_share_a_load');

    // idle touch
    var toot_idle = $('#toot_idle');

    // help
    var edit_orders_help = $('#edit_orders_help');
    var select_orders_help = $('#select_orders_help');

    enter_pin.on('hidden.bs.modal', function () {
        resetPinCodeValue();
    });
    _modal.on('hidden.bs.modal', function () {
        idleTapCardListener(0);
        clearTimer();
    });
    check_balance.on('hidden.bs.modal', function () {
        resetTootCardDetailsHtml();
    });
    undone_orders.on('hidden.bs.modal', function () {
        resetUserOrderHtml();
    });

    tap_card.on('shown.bs.modal', function () {
        modalTapCardListener(0);
    });

    idle_toot_card_id.on('change', function () {
        if (parseInt($(this).val().length) === 10) {
            $.post('toot_card_check', {
                toot_card_id: $(this).val()
            }, function (response) {
                if (response == 1) {
                    $.post('toot_card_get_orders', {
                        toot_card_id: idle_toot_card_id.val()
                    }, function (response) {
                        $('#user_order').html(response);
                    }).done(function (response) {
                        if (response == 14) {
                            validation(true, timeout_short, '{!! trans('toot_card.to_many_card_tap') !!}');
                        } else {
                            if (response == 13) {
                                validation(true, timeout_short, '{!! trans('toot_card.no_undone_orders') !!}');
                            } else {
                                undoneOrders(timeout_long);
                            }
                        }
                        console.log(response);
                    });
                } else if (response == 2) {
                    validation(true, timeout_short, '{!! trans('toot_card.invalid_card') !!}');
                } else if (response == 14) {
                    validation(true, timeout_short, '{!! trans('toot_card.to_many_card_tap') !!}');
                }
                console.log(response);
                resetIdleTootCardIdValue();
            });
        }
    });
    toot_card_id.on('change', function () {
        if (parseInt($(this).val().length) === 10) {
            $.post('toot_card_check', {
                toot_card_id: $(this).val()
            }, function (response) {
                tap_card.modal('hide');

                if (response == 1) {
                    _toot_card_id.val(toot_card_id.val());
                    enterPin(timeout_long);
                } else if (response == 2) {
                    validation(true, timeout_short, '{!! trans('toot_card.invalid_card') !!}');
                } else if (response == 14) {
                    validation(true, timeout_short, '{!! trans('toot_card.to_many_card_tap') !!}');
                }
                console.log(response);
                resetTootCardIdValue();
            });
        }
    });

    $('.backspace').on('click', function () {
        if (enter_pin.hasClass('in')) {
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
    select_orders_help.on('click', function () {
        alert('select_orders_help gif');
    });
    edit_orders_help.on('click', function () {
        alert('edit_orders_help gif');
    });
    toot_idle.on('click', function () {
        _menu(timeout_long);
    });
    $('.key').on('click', function () {
        if (enter_pin.hasClass('in')) {
            pin_code.val((pin_code.val()) + (this.value));
        }

        if (enter_load_amount.hasClass('in')) {
            load_amount.val((load_amount.val()) + (this.value));
        }
    });
    btn_cancel.on('click', function () {
        goToIdle(500);
        $(this).button('loading').delay(timeout_short).queue(function () {
            $(this).button('reset');
            $(this).dequeue();
        });
    });
    menu_reload_toot_card.on('click', function () {
        menu.modal('hide');
        resetLoadAmountValue();
        enterLoadAmount(timeout_long);
        last_resort.val(1);
    });
    menu_check_balance.on('click', function () {
        menu.modal('hide');
        tapCard(timeout_long);
        last_resort.val(2);
    });
    menu_order_food.on('click', function () {
        menu.modal('hide');
        loading.modal('static');
        goToIndex(500);
    });
    menu_share_a_load.on('click', function () {
        menu.modal('hide');
        resetLoadAmountValue();
        enterLoadAmount(timeout_long);
        last_resort.val(5);
    });
    btn_hold.on('click', function () {
        tapCard(timeout_long);
        last_resort.val(4);
    });
    btn_pay_using_toot_card.on('click', function () {
        tapCard(timeout_long);
        last_resort.val(3);
    });
    btn_pay_using_cash.on('click', function () {
        sendOrders(5, 1);
    });
    $('.submit-check').on('click', function () {
        $(this).button('loading').delay(1500).queue(function () {
            $(this).button('reset');
            $(this).dequeue();
        });

        if (enter_user_id.hasClass('in')) {
            if (parseInt(user_id.val().length) < 1) {
                validation(false, timeout_short, '{!! trans('toot_card.empty_user_id') !!}');
            } else {
                tapCard(timeout_long);
            }
        }

        if (enter_pin.hasClass('in')) {
            if (parseInt(pin_code.val().length) < 1) {
                validation(false, timeout_short, '{!! trans('toot_card.empty_pin') !!}');
            } else {
                tootCardAuthAttempt(_toot_card_id.val(), pin_code.val());
            }
        }

        if (enter_load_amount.hasClass('in')) {
            if (parseInt(load_amount.val().length) < 1 || parseInt(load_amount.val()) < 1) {
                validation(false, timeout_short, '{!! trans('toot_card.empty_load_amount') !!}');
            } else {
                validateLoadAmount(load_amount.val());
            }
        }
    });

    function validateLoadAmount(load_amount_value) {
        if (parseFloat(load_amount_value) > parseFloat('{{ \App\Models\Setting::value('reload_limit') }}')) {
            validation(false, 3000, '{!! trans('toot_card.exceed_reload_limit') !!}');
        } else {
            enter_load_amount.modal('hide');
            if (last_resort.val() == 5) {
                enterUserId(timeout_short);
            } else {
                tapCard(timeout_long);
            }
        }
    }

    function tootCardCheckBalance(toot_card_id) {
        $.post('toot_card_check_balance', {
            toot_card_id: toot_card_id
        }, function (response) {
            $('#toot_card_details').html(response);
            console.log(response);
        }).done(function () {
            checkBalance(timeout_long);
        });
    }

    function shareLoad(toot_card_id, user_id, load_amount) {
        // todo
    }

    function reloadTootCard(toot_card_id, load_amount) {
        // todo
    }

    function tootCardAuthAttempt(toot_card_id, pin_code) {
        $.post('toot_card_auth_attempt', {
            toot_card_id: toot_card_id,
            pin_code: pin_code
        }, function (response) {
            if (response == 3) {
                enter_pin.modal('hide');
                lastResort(last_resort.val());
            } else if (response == 4) {
                resetPinCodeValue();
                validation(false, timeout_short, '{!! trans('toot_card.wrong_pin') !!}');
            }
            console.log(response);
        });
    }

    function lastResort(last_resort_value) {
        switch(parseInt(last_resort_value)) {
            case 1:
                reloadTootCard(_toot_card_id.val(), load_amount.val());
                console.log('LAST_RESORT_RELOAD_TOOT_CARD');
                break;
            case 2:
                tootCardCheckBalance(_toot_card_id.val());
                console.log('LAST_RESORT_CHECK_BALANCE');
                break;
            case 3:
                sendOrders(10, 2);
                console.log('LAST_RESORT_QUEUED_ORDER');
                break;
            case 4:
                sendOrders(12, 2);
                console.log('LAST_RESORT_HOLD_ORDER');
                break;
            case 5:
                shareLoad(_toot_card_id.val(), user_id.val(), load_amount.val());
                console.log('LAST_RESORT_SHARE_LOAD');
                break;
        }
        resetLastResortValue();
    }

    function goToIdle(timeout) {
        _timer = setTimeout(function () {
            window.location.href = '{{ route('client.idle') }}';
        }, timeout);
    }

    function goToIndex(timeout) {
        _timer = setTimeout(function () {
            window.location.replace('{{ route('client.index') }}/');
        }, timeout);
    }

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

            _modal.on('hidden.bs.modal', function () {
                $(this).find('span.qty').text(1);
            });

            var modal_qty = $('.modal-body .row .col-md-6');
            modal_qty.on('click', 'button.plus', function () {
                var qty = parseInt($(this).prev('span.qty').text());
                var new_qty = qty + 1;
                $(this).prev('span.qty').text(new_qty);
                compute();
            });
            modal_qty.on('click', 'button.minus', function () {
                var qty = parseInt($(this).next('span.qty').text());
                var new_qty = ((qty - 1) < 1) ? 1 : qty - 1;
                $(this).next('span.qty').text(new_qty);
                compute();
            });
        });
    }

    function loadOrders(transaction_id) {
        console.log('transaction_id is ' + transaction_id);

        $.post('load_orders', {
            transaction_id: transaction_id
        }, function (response) {
            var orders = JSON.parse(response);

            $.each(orders, function(key, order) {
                getOrder(order.id, order.merchandise_id, order.name, order.price, order.qty);
            });
            console.log(orders);
        });
    }

    $(function () {
        idleTapCardListener(0);

        if (_transaction_id > 0) {
            loadOrders(_transaction_id);
        }
        todaysMenu();
    });

    function getOrders() {
        var orders = [];

        $('tr.row-order').each(function () {
            var qty = parseInt($('span.qty', this).text());
            var each_value = $('span.each', this);
            var each = parseFloat(each_value.text());
            var total = qty * each;
            var order_id = parseInt($(this).data('order_id'));
            var merchandise_id = $(this).data('merchandise_id');
            var order = {};

            if (order_id > 0) {
                order['id'] = order_id;
            }
            order['transaction_id'] = _transaction_id;
            order['merchandise_id'] = merchandise_id;
            order['quantity'] = qty;
            order['total'] = total;
            orders.push(order);
        });
        console.log(orders);
        return JSON.stringify(orders);
    }

    function sendOrders(status_response_id, payment_method_id) {
        var transaction = {};
        transaction['payment_method_id'] = payment_method_id;
        transaction['status_response_id'] = status_response_id;

        $.post('merchandise_purchase', {
            orders: getOrders(),
            transaction: JSON.stringify(transaction),
            toot_card_id: _toot_card_id.val()
        }, function (response) {
            if (response.status == '{{ \App\Models\StatusResponse::find(8)->name }}') {
                validation(true, 3000, '{!! trans('toot_card.insufficient_balance') !!}');
            } else {
                if (response.status == '{{ \App\Models\StatusResponse::find(5)->name }}' && response.payment_method == '{{ \App\Models\PaymentMethod::find(1)->name }}') {
                    validation('static', 3000, '{!! trans('toot_card.transaction_complete') !!}');
                } else if (response.payment_method == '{{ \App\Models\PaymentMethod::find(2)->name }}') {
                    if (response.status == '{{ \App\Models\StatusResponse::find(12)->name }}') {
                        validation('static', 4000, '{!! trans('toot_card.order_on_hold') !!}');
                    } else if (response.status == '{{ \App\Models\StatusResponse::find(10)->name }}') {
                        $('#queue_number').text(response.queue_number);
                        transactionCompleteWithQueueNumber(4000);
                    }
                }
                goToIdle(timeout_short);
            }
            console.log(response);
        }, 'json');
    }

    function orderRowActions(merchandise_id) {
        var order_qty = $('#merchandise_' + merchandise_id + '');
        order_qty.on('click', 'td button.plus', function () {
            var qty = parseInt($(this).prev('span.qty').text());
            var new_qty = qty + 1;
            $(this).prev('span.qty').text(new_qty);
            compute();
        });
        order_qty.on('click', 'td button.minus', function () {
            var qty = parseInt($(this).next('span.qty').text());
            var new_qty = ((qty - 1) < 1) ? 1 : qty - 1;
            $(this).next('span.qty').text(new_qty);
            compute();
        });
        $('td button.remove').on('click', function () {
            $(this).closest('tr').remove();
            compute();
        });
    }

    function getOrder(id, merchandise_id, name, price, qty) {
        var order_exist = false;

        $('tr.row-order').each(function () {
            if ($(this).data('merchandise_id') == merchandise_id) {
                var _qty = parseInt($('span.qty', this).text());
                $('span.qty', this).text(_qty + parseInt(qty));
                order_exist = true;
            }
        });

        console.log(order_exist);

        if (!order_exist) {
            $('#table_orders tbody').append(
                    '<tr class="row-order" data-order_id="' + id + '" id="merchandise_' + merchandise_id + '" data-merchandise_id="' + merchandise_id + '">' +
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
            orderRowActions(merchandise_id);
        }
        compute();
    }

    function addOrder(merchandise_id, name, price, qty) {
        var order_exist = false;

        $('tr.row-order').each(function () {
            if ($(this).data('merchandise_id') == merchandise_id) {
                var _qty = parseInt($('span.qty', this).text());
                $('span.qty', this).text(_qty + parseInt(qty));
                order_exist = true;
            }
        });

        console.log(order_exist);

        if (!order_exist) {
            $('#table_orders tbody').append(
                    '<tr class="row-order" id="merchandise_' + merchandise_id + '" data-merchandise_id="' + merchandise_id + '">' +
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
            orderRowActions(merchandise_id);
        }
        compute();
    }

    function compute() {
        var grand_total = 0;
        var decimal_place = 2;
        var row_count = parseInt($('#table_orders tbody tr.row-order').length);

        $('tr.row-order').each(function () {
            var qty = parseInt($('span.qty', this).text());
            var each_value = $('span.each', this);
            var each = parseFloat(each_value.text());
            each_value.text(each.toFixed(decimal_place));
            var total = qty * each;
            $('span.total', this).text(total.toFixed(decimal_place));
            grand_total += total;
        });

        $("#grand_total").text(grand_total.toFixed(decimal_place));

        if (row_count < 1) {
            btn_hold.attr('disabled', 'disabled');
            btn_pay_using_toot_card.attr('disabled', 'disabled');
            btn_pay_using_cash.attr('disabled', 'disabled');
        } else {
            btn_hold.removeAttr('disabled');
            btn_pay_using_toot_card.removeAttr('disabled');
            btn_pay_using_cash.removeAttr('disabled');
        }
    }

    function clearTimer() {
        clearTimeout(_timer);
        console.log('_timer cleared!');
    }

    function refreshPage(timeout) {
        _timer = setTimeout(function () {
            location.reload();
        }, timeout);
        console.log('page reloading!');
    }

    function validation(backdrop, timeout, content) {
        _validation.find('#validation_content').html(content);

        switch (backdrop) {
            case true:
                if (_modal.hasClass('in')) {
                    _modal.modal('hide');
                }
                _validation.modal({backdrop: backdrop});
                break;
            case false:
                _validation.modal({backdrop: backdrop});
                break;
            case 'static':
                _validation.modal({backdrop: backdrop});
                break;
            default:
        }
        _timer = setTimeout(function () {
            _validation.modal('hide');
        }, timeout);
    }

    function enterLoadAmount(timeout) {
        enter_load_amount.modal('show');
        _timer = setTimeout(function () {
            enter_load_amount.modal('hide');
        }, timeout);
    }

    function enterUserId(timeout) {
        enter_user_id.modal('show');
        _timer = setTimeout(function () {
            enter_user_id.modal('hide');
        }, timeout);
    }

    function idleTapCardListener(timeout) {
        idle_toot_card_id.focus();
        _timer = setTimeout(function () {
            idle_toot_card_id.focus();
        }, timeout);
    }

    function modalTapCardListener(timeout) {
        toot_card_id.focus();
        toot_card_id.blur(function () {
            _timer = setTimeout(function () {
                toot_card_id.focus();
            }, timeout);
        });
    }

    function _menu(timeout) {
        menu.modal('show');
        _timer = setTimeout(function () {
            menu.modal('hide');
        }, timeout);
    }

    function undoneOrders(timeout) {
        undone_orders.modal('show');
        _timer = setTimeout(function () {
            undone_orders.modal('hide');
        }, timeout);
    }

    function resetTootCardIdValue() {
        toot_card_id.val('');
    }

    function resetValidationContentHtml() {
        validation_content.html('');
    }

    function resetLoadAmountValue() {
        load_amount.val('');
    }

    function resetLastResortValue() {
        last_resort.val('');
    }

    function resetUserIdValue() {
        user_id.val('');
    }

    function resetIdleTootCardIdValue() {
        idle_toot_card_id.val('');
    }

    function resetTootCardDetailsHtml() {
        $('#toot_card_details').html('');
    }

    function resetUserOrderHtml() {
        $('#user_order').html('');
    }

    function resetPinCodeValue() {
        pin_code.val('');
    }

    function enterPin(timeout) {
        enter_pin.modal('show');
        _timer = setTimeout(function () {
            enter_pin.modal('hide');
        }, timeout);
    }

    function checkBalance(timeout) {
        check_balance.modal('show');
        _timer = setTimeout(function () {
            check_balance.modal('hide');
        }, timeout);
    }

    function tapCard(timeout) {
        tap_card.modal('show');
        _timer = setTimeout(function () {
            tap_card.modal('hide');
        }, timeout);
    }

    function transactionCompleteWithQueueNumber(timeout) {
        transaction_complete_with_queue_number.modal({backdrop: 'static'});
        _timer = setTimeout(function () {
            transaction_complete_with_queue_number.modal('hide');
        }, timeout);
    }

    (function ($) {
        $.fn.blink = function (options) {
            var defaults = {delay: 500};
            var _options = $.extend(defaults, options);
            return $(this).each(function (idx, itm) {
                setInterval(function () {
                    if ($(itm).css('visibility') === 'visible') {
                        $(itm).css('visibility', 'hidden');
                    }
                    else {
                        $(itm).css('visibility', 'visible');
                    }
                }, _options.delay);
            });
        }
    }(jQuery));

    $('#touch').blink();
</script>