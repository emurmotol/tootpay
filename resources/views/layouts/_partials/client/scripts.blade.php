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
    var user_id = $('#user_id');

    // modal
    var _modal = $('.modal');
    var menu = $('#menu');
    var no_undone_orders = $('#no_undone_orders');
    var to_many_card_tap = $('#to_many_card_tap');
    var undone_orders = $('#undone_orders');
    var load_amount = $('#load_amount');
    var enter_load_amount = $('#enter_load_amount');
    var empty_load_amount = $('#empty_load_amount');
    var enter_pin = $('#enter_pin');
    var empty_pin = $('#empty_pin');
    var enter_user_id = $('#enter_user_id');
    var empty_user_id = $('#empty_user_id');
    var loading = $('#loading');
    var wrong_pin = $('#wrong_pin');
    var transaction_complete_with_queue_number = $('#transaction_complete_with_queue_number');
    var transaction_complete = $('#transaction_complete');
    var order_on_hold = $('#order_on_hold');
    var check_balance = $('#check_balance');
    var tap_card = $('#tap_card');
    var waiting_for_payment = $('#waiting_for_payment');

    // database values
    var queue_number_value = parseInt('{{ \App\Models\Merchandise::queueNumber() }}');
    var order_id = parseInt('{{ \App\Models\Merchandise::orderId() }}');

    // timer
    var timeout_long = 60000;
    var timeout_short = 1500;
    var _timer;

    // menu
    var menu_reload_toot_card = $('#menu_reload_toot_card');
    var menu_check_balance = $('#menu_check_balance');
    var menu_order_food = $('#menu_order_food');
    var menu_share_a_load = $('#menu_share_a_load');

    idleTapCardListener(0);

    enter_pin.on('hidden.bs.modal', function () {
        resetPinCodeValue();
    });
    _modal.on('hidden.bs.modal', function () {
        idleTapCardListener(0);
        clearTimer();
    });
    no_undone_orders.on('hidden.bs.modal', function () {
        resetUserOrderHtml();
    });
    to_many_card_tap.on('hidden.bs.modal', function () {
        resetUserOrderHtml();
    });
    check_balance.on('hidden.bs.modal', function () {
        resetTootCardDetailsHtml();
    });
    undone_orders.on('hidden.bs.modal', function () {
        resetUserOrderHtml();
    });
    order_on_hold.on('hidden.bs.modal', function () {
        goToIdle(0);
    });
    transaction_complete_with_queue_number.on('hidden.bs.modal', function () {
        goToIdle(0);
    });
    transaction_complete.on('hidden.bs.modal', function () {
        goToIdle(0);
    });

    tap_card.on('shown.bs.modal', function () {
        modalTapCardListener(0);
    });
    wrong_pin.on('shown.bs.modal', function () {
        resetPinCodeValue();
    });

    idle_toot_card_id.on('change', function () {
        if (parseInt($(this).val().length) === 10) {
            $.post('toot_card_check', {
                id: $(this).val()
            }, function (response) {
                if (response == '{{ config('static.status')[0] }}') {
                    $.post('toot_card_get_orders', {
                        id: idle_toot_card_id.val()
                    }, function (response) {
                        $('#user_order').html(response);
                    }).done(function (response) {
                        if (response == '{{ config('static.status')[12] }}') {
                            noUndoneOrders(timeout_short);
                        } else {
                            undoneOrders(timeout_long);
                        }
                        console.log('orders response is ' + response + '!');
                    });
                } else if (response == '{{ config('static.status')[1] }}') {
                    invalidCard(timeout_short);
                } else if (response == '{{ config('static.status')[13] }}') {
                    toManyCardTap(timeout_short);
                }
                console.log(idle_toot_card_id.val() + ' is ' + response + '!');
            }).done(function () {
                resetIdleTootCardIdValue();
            });
        }
    });
    toot_card_id.on('change', function () {
        if (parseInt($(this).val().length) === 10) {
            $.post('toot_card_check', {
                id: $(this).val()
            }, function (response) {
                tap_card.modal('hide');

                if (response == '{{ config('static.status')[0] }}') {
                    $('#id').val(toot_card_id.val());
                    enterPin(timeout_long);
                } else if (response == '{{ config('static.status')[1] }}') {
                    invalidCard(timeout_short);
                } else if (response == '{{ config('static.status')[13] }}') {
                    toManyCardTap(timeout_short);
                }
                console.log(toot_card_id.val() + ' is ' + response + '!');
            }).done(function () {
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
    $('#select_orders_help').on('click', function () {
        alert('select_orders_help gif');
    });
    $('#edit_orders_help').on('click', function () {
        alert('edit_orders_help gif');
    });
    $('#toot_idle').on('click', function () {
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
        console.log('last_resort set to 1!');
    });
    menu_check_balance.on('click', function () {
        menu.modal('hide');
        tapCard(timeout_long);
        last_resort.val(2);
        console.log('last_resort set to 2!');
    });
    menu_order_food.on('click', function () {
        menu.modal('hide');
        $('.modal-body p #loading_text').text('Loading menu items');
        loading.modal('show');
        goToIndex(500);
    });
    menu_share_a_load.on('click', function () {
        menu.modal('hide');
        resetLoadAmountValue();
        enterLoadAmount(timeout_long);
        last_resort.val(5);
        console.log('last_resort set to 5!');
    });
    btn_hold.on('click', function () {
        tapCard(timeout_long);
        last_resort.val(4);
        console.log('last_resort set to 4!');
    });
    btn_pay_using_toot_card.on('click', function () {
        tapCard(timeout_long);
        last_resort.val(3);
        console.log('last_resort set to 3!');
    });
    btn_pay_using_cash.on('click', function () {
        sendOrders('{{ config('static.status')[4] }}', '{{ config('static.payment_method')[0] }}');
    });
    $('.submit-check').on('click', function () {
        $(this).button('loading').delay(1500).queue(function () {
            $(this).button('reset');
            $(this).dequeue();
        });
        var last_resort_value = last_resort.val();

        if (enter_user_id.hasClass('in')) {
            if (parseInt(user_id.val().length) < 1) {
                emptyUserId(timeout_short);
            } else {
                tapCard(timeout_long);
            }
        }

        if (enter_pin.hasClass('in')) {
            if (parseInt(pin_code.val().length) < 1) {
                emptyPin(timeout_short);
            } else {
                tootCardAuthAttempt($('#id').val(), pin_code.val(), last_resort_value);
            }
        }

        if (enter_load_amount.hasClass('in')) {
            if (parseInt(load_amount.val().length) < 1) {
                emptyLoadAmount(timeout_short);
            } else {
                if (parseFloat(load_amount.val()) > parseFloat('{{ \App\Models\Setting::value('reload_limit') }}')) {
                    exceedReloadLimit(3000);
                } else {
                    enter_load_amount.modal('hide');
                    if (last_resort_value == 5) {
                        enterUserId(timeout_short);
                    } else {
                        tapCard(timeout_long);
                    }
                }
            }
        }
    });

    function tootCardCheckBalance(toot_card_id) {
        $.post('toot_card_check_balance', {
            id: toot_card_id
        }, function (response) {
            $('#toot_card_details').html(response);
        }).done(function () {
            checkBalance(timeout_long);
        });
    }

    function shareLoad() {
        alert('LAST_RESORT_SHARE_LOAD');
    }

    function reloadTootCard() {
        alert('LAST_RESORT_RELOAD_TOOT_CARD');
    }

    function tootCardAuthAttempt(toot_card_id, pin_code, last_resort_value) {
        $.post('toot_card_auth_attempt', {
            id: toot_card_id,
            pin_code: pin_code
        }, function (response) {
            if (response == '{{ config('static.status')[2] }}') {
                enter_pin.modal('hide');
                lastResort(last_resort_value);
            } else if (response == '{{ config('static.status')[3] }}') {
                wrongPin(timeout_short);
            }
            console.log('response is ' + response + ' pin!');
        });
    }

    function lastResort(last_resort_value) {
        switch(last_resort_value) {
            case 1:
                reloadTootCard();
                break;
            case 2:
                tootCardCheckBalance($('#id').val());
                break;
            case 3:
                sendOrders('{{ config('static.status')[9] }}', '{{ config('static.payment_method')[1] }}');
                break;
            case 4:
                sendOrders('{{ config('static.status')[11] }}', '{{ config('static.payment_method')[1] }}');
                break;
            case 5:
                shareLoad();
                break;
        }
        alert('last_resort_value is ' + last_resort_value + '!');
    }

    function goToIdle(timeout) {
        _timer = setTimeout(function () {
            window.location.href = '{{ route('client.idle') }}';
        }, timeout);
        console.log('route to idle!');
    }

    function goToIndex(timeout) {
        _timer = setTimeout(function () {
            window.location.replace('{{ route('client.index') }}/');
        }, timeout);
        console.log('route to index!');
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

    $(function () {
        todaysMenu();

        window.addOrder = (function (merchandise_id, name, price, qty) {
            var order_exist = false;

            $('tr.row-order').each(function () {
                if ($(this).data('merchandise_id') == merchandise_id) {
                    var _qty = parseInt($('span.qty', this).text());
                    $('span.qty', this).text(_qty + parseInt(qty));
                    order_exist = true;
                }
            });

            console.log('order exist on list? ' + order_exist);

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
            }
            compute();

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
        });

        window.compute = (function () {
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
        });
    });

    function clearTimer() {
        clearTimeout(_timer);
        console.log('_timer cleared!');
    }

    function reloadCurrentPage(timeout) {
        _timer = setTimeout(function () {
            location.reload();
        }, timeout);
        console.log('page reloading!');
    }

    function enterLoadAmount(timeout) {
        enter_load_amount.modal('show');
        console.log('showing enter_load_amount modal');
        _timer = setTimeout(function () {
            enter_load_amount.modal('hide');
        }, timeout);
    }

    function enterUserId(timeout) {
        enter_user_id.modal('show');
        console.log('showing enter_user_id modal');
        _timer = setTimeout(function () {
            enter_user_id.modal('hide');
        }, timeout);
    }

    function emptyUserId(timeout) {
        empty_user_id.modal('show');
        console.log('showing empty_user_id modal');
        _timer = setTimeout(function () {
            empty_user_id.modal('hide');
        }, timeout);
    }

    function idleTapCardListener(timeout) {
        idle_toot_card_id.focus();
        console.log('idle_toot_card_id is on focus!');
        _timer = setTimeout(function () {
            idle_toot_card_id.focus();
        }, timeout);
    }

    function modalTapCardListener(timeout) {
        toot_card_id.focus();
        console.log('toot_card_id is on focus!');
        toot_card_id.blur(function () {
            _timer = setTimeout(function () {
                toot_card_id.focus();
            }, timeout);
        });
    }

    function emptyLoadAmount(timeout) {
        empty_load_amount.modal({backdrop: false});
        console.log('showing empty_load_amount modal');
        _timer = setTimeout(function () {
            empty_load_amount.modal('hide');
        }, timeout);
    }

    function _menu(timeout) {
        menu.modal('show');
        console.log('showing menu modal');
        _timer = setTimeout(function () {
            menu.modal('hide');
        }, timeout);
    }

    function noUndoneOrders(timeout) {
        no_undone_orders.modal('show');
        console.log('showing no_undone_orders modal');
        _timer = setTimeout(function () {
            no_undone_orders.modal('hide');
        }, timeout);
    }

    function undoneOrders(timeout) {
        undone_orders.modal('show');
        console.log('showing undone_orders modal');
        _timer = setTimeout(function () {
            no_undone_orders.modal('hide');
        }, timeout);
    }

    function resetTootCardIdValue() {
        toot_card_id.val('');
        console.log('toot_card_id has been reset!');
    }

    function resetLoadAmountValue() {
        load_amount.val('');
        console.log('load_amount has been reset!');
    }

    function resetIdleTootCardIdValue() {
        idle_toot_card_id.val('');
        console.log('idle_toot_card_id has been reset!');
    }

    function resetTootCardDetailsHtml() {
        $('#toot_card_details').html('');
        console.log('toot_card_details has been reset!');
    }

    function resetUserOrderHtml() {
        $('#user_order').html('');
        console.log('user_order has been reset!');
    }

    function resetPinCodeValue() {
        pin_code.val('');
        console.log('pin_code has been reset!');
    }

    function toManyCardTap(timeout) {
        to_many_card_tap.modal('show');
        console.log('showing to_many_card_tap modal');
        _timer = setTimeout(function () {
            to_many_card_tap.modal('hide');
        }, timeout);
    }

    function invalidCard(timeout) {
        $('#invalid_card').modal('show');
        console.log('showing invalid_card modal');
        _timer = setTimeout(function () {
            $('#invalid_card').modal('hide');
        }, timeout);
    }

    function exceedReloadLimit(timeout) {
        $('#exceed_reload_limit').modal({backdrop: false});
        console.log('showing exceed_reload_limit modal');
        _timer = setTimeout(function () {
            $('#exceed_reload_limit').modal('hide');
        }, timeout);
    }

    function enterPin(timeout) {
        enter_pin.modal('show');
        console.log('showing enter_pin modal');
        _timer = setTimeout(function () {
            enter_pin.modal('hide');
        }, timeout);
    }

    function emptyPin(timeout) {
        empty_pin.modal({backdrop: false});
        console.log('showing empty_pin modal');
        _timer = setTimeout(function () {
            empty_pin.modal('hide');
        }, timeout);
    }

    function checkBalance(timeout) {
        check_balance.modal('show');
        console.log('showing check_balance modal');
        _timer = setTimeout(function () {
            check_balance.modal('hide');
        }, timeout);
    }

    function wrongPin(timeout) {
        wrong_pin.modal({backdrop: false});
        console.log('showing wrong_pin modal');
        _timer = setTimeout(function () {
            wrong_pin.modal('hide');
        }, timeout);
    }

    function tapCard(timeout) {
        tap_card.modal('show');
        console.log('showing tap_card modal');
        _timer = setTimeout(function () {
            tap_card.modal('hide');
        }, timeout);
    }

    function insufficientBalance(timeout) {
        $('#insufficient_balance').modal('show');
        console.log('showing insufficient_balance modal');
        _timer = setTimeout(function () {
            $('#insufficient_balance').modal('hide');
        }, timeout);
    }

    function transactionCompleteWithQueueNumber(timeout) {
        transaction_complete_with_queue_number.modal('show');
        console.log('showing transaction_complete_with_queue_number modal');
        _timer = setTimeout(function () {
            transaction_complete_with_queue_number.modal('hide');
        }, timeout);
    }

    function orderOnHold(timeout) {
        order_on_hold.modal('show');
        console.log('showing order_on_hold modal');
        _timer = setTimeout(function () {
            order_on_hold.modal('hide');
        }, timeout);
    }

    function transactionComplete(timeout) {
        transaction_complete.modal('show');
        console.log('showing transaction_complete modal');
        _timer = setTimeout(function () {
            transaction_complete.modal('hide');
        }, timeout);
    }

    function sendOrders(status, payment_method) {
        var orders = [];

        $('tr.row-order').each(function () {
            var qty = parseInt($('span.qty', this).text());
            var each_value = $('span.each', this);
            var each = parseFloat(each_value.text());
            var total = qty * each;
            var order = {};
            order['queue_number'] = queue_number_value;
            order['order_id'] = order_id;
            order['toot_card_id'] = $('#id').val();
            order['merchandise_id'] = $(this).data('merchandise_id');
            order['quantity'] = qty;
            order['total'] = total;
            order['status'] = status;
            order['payment_method'] = payment_method;
            orders.push(order);
        });

        $.post('merchandise_purchase', {
            orders: JSON.stringify(orders)
        }, function (response) {
            console.log('purchase response is ' + response + '!');
        }).done(function (response) {
            if (response == '{{ config('static.status')[7] }}') {
                insufficientBalance(3000);
            } else if (response == '{{ config('static.status')[8] }}') {

                if (payment_method == '{{ config('static.payment_method')[0] }}') {
                    transactionComplete(3000);
                    goToIdle(timeout_short);
                } else if (payment_method == '{{ config('static.payment_method')[1] }}') {
                    if (status == '{{ config('static.status')[11] }}') {
                        orderOnHold(4000);
                    } else {
                        $('#queue_number_huge').text(queue_number_value);
                        transactionCompleteWithQueueNumber(4000);
                    }
                    goToIdle(3000);
                }
            }
        });
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