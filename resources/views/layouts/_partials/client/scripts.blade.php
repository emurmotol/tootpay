<script>
    var waiting_for_payment = $('#waiting_for_payment');
    var enter_pin = $('#enter_pin');
    var tap_card = $('#tap_card');
    var pin_code = $('#pin_code');
    var load_amount = $('#load_amount');
    var enter_load_amount = $('#enter_load_amount');
    var toot_card_id = $('#toot_card_id');
    var loading = $('#loading');
    var _modal = $('.modal');
    var no_undone_orders = $('#no_undone_orders');
    var to_many_card_tap = $('#to_many_card_tap');
    var undone_orders = $('#undone_orders');
    var destination_id = $('#destination_id');
    var idle_toot_card_id = $('#idle_toot_card_id');
    var transaction_complete_with_queue_number = $('#transaction_complete_with_queue_number');
    var transaction_complete = $('#transaction_complete');
    var order_on_hold = $('#order_on_hold');
    var queue_number_value = parseInt('{{ \App\Models\Merchandise::queueNumber() }}');

    idleTapCardListener(0);

    enter_pin.on('hidden.bs.modal', function () {
        $(this).find('#pin_code').val('');
    });
    $('#check_balance').on('hidden.bs.modal', function () {
        reloadPage(0);
    });
    _modal.on('hidden.bs.modal', function () {
        idleTapCardListener(0);
    });
    no_undone_orders.on('hidden.bs.modal', function () {
        resetUserOrderHtml();
    });
    to_many_card_tap.on('hidden.bs.modal', function () {
        resetUserOrderHtml();
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
        toot_card_id.focus();
        console.log('toot_card_id is on focus!');
        toot_card_id.blur(function () {
            setTimeout(function () {
                toot_card_id.focus();
            }, 0);
        });
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
                            noUndoneOrders(2000);
                        } else {
                            undoneOrders(0);
                        }
                        console.log('orders response is ' + response + '!');
                    });
                } else if (response == '{{ config('static.status')[1] }}') {
                    invalidCard(2000);
                } else if (response == '{{ config('static.status')[13] }}') {
                    toManyCardTap(2000);
                }
                console.log(idle_toot_card_id.val() + ' is ' + response + '!');
            }).done(function () {
                resetTootCardIdValue();
            });
        }
    });
    toot_card_id.on('change', function () {
        if (parseInt($(this).val().length) === 10) {
            $.post('toot_card_check', {
                id: $(this).val()
            }, function (response) {
                tap_card.modal('toggle');

                if (response == '{{ config('static.status')[0] }}') {
                    $('#id').val(toot_card_id.val());
                    enterPin(0);
                } else if (response == '{{ config('static.status')[1] }}') {
                    invalidCard(2000);
                } else if (response == '{{ config('static.status')[13] }}') {
                    toManyCardTap(2000);
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
        $('#menu').modal('show');
        console.log('showing menu modal');
    });
    $('.key').on('click', function () {
        if (enter_pin.hasClass('in')) {
            pin_code.val((pin_code.val()) + (this.value));
        }

        if (enter_load_amount.hasClass('in')) {
            load_amount.val((load_amount.val()) + (this.value));
        }
    });
    $('#menu_reload').on('click', function () {
        $('#load_amount').val('');
        $('#menu').modal('toggle');
        $('#enter_load_amount').modal('show');
        console.log('showing enter_load_amount modal');
        destination_id.val(1);
        console.log('destination_id set to 1!');
    });
    $('#menu_balance').on('click', function () {
        $('#menu').modal('toggle');
        tap_card.modal('show');
        console.log('showing tap_card modal');
        destination_id.val(2);
        console.log('destination_id set to 2!');
    });
    $('#menu_order').on('click', function () {
        $('.modal-body p #loading_text').text('Loading menu items');
        $('#loading').modal('show');
        console.log('showing loading modal');
        $('#menu').modal('toggle');
        console.log('route to order!');
        window.location.replace('{{ route('client.index') }}/');
    });
    $('#btn_cancel').on('click', function () {
        goToIdle(500);
        $(this).button('loading').delay(2000).queue(function () {
            $(this).button('reset');
            $(this).dequeue();
        });
    });
    $('#btn_hold').on('click', function () {
        tap_card.modal('show');
        destination_id.val(4);
        console.log('destination_id set to 4!');
    });
    $('#btn_pay_using_toot_card').on('click', function () {
        tap_card.modal('show');
        destination_id.val(3);
        console.log('destination_id set to 3!');
    });
    $('#btn_pay_using_cash').on('click', function () {
        sendMerchandisePurchase('{{ config('static.status')[4] }}', '{{ config('static.payment_method')[0] }}');
    });
    $('.submit-check').on('click', function () {
        $(this).button('loading').delay(1000).queue(function () {
            $(this).button('reset');
            $(this).dequeue();
        });

        if (enter_pin.hasClass('in')) {
            if (pin_code.val().length < 1) {
                emptyPin(2000);
            } else {
                $.post('toot_card_authentication', {
                    id: $('#id').val(),
                    pin_code: pin_code.val()
                }, function (response) {
                    if (response == '{{ config('static.status')[2] }}') {
                        enter_pin.modal('toggle');

                        if (destination_id.val() == 1) {
                            $('.modal-body p #loading_text').text('Processing load request. Please wait');
                            $('#loading').modal('show');

                            $.post('toot_card_reload_pending', {
                                id: $('#id').val(),
                                amount: load_amount.val()
                            }, function (response) {
                                if (response != null) {
                                    console.log('reload_id is ' + response + '!');

                                    var interval = setInterval(function () {
                                        $.post('toot_card_reload_status', {
                                            id: $('#id').val(),
                                            reload_id: response
                                        }, function (response) {
                                            if (response == '{{ config('static.status')[4] }}') {

                                                if (!waiting_for_payment.hasClass('in')) {
                                                    $('#loading').modal('toggle');
                                                    $('#_amount').text(load_amount.val());
                                                    console.log('_amount is set to ' + load_amount.val() + '!');

                                                    reloadPage(120000);
                                                    waiting_for_payment.modal({backdrop: 'static'});
                                                    console.log('showing waiting_for_payment modal');
                                                }
                                            } else {
                                                waiting_for_payment.modal('toggle');
                                                clearInterval(interval);

                                                if (response == '{{ config('static.status')[5] }}') {
                                                    $('#reload_paid').modal('show');
                                                    console.log('showing reload_paid modal');

                                                    $.post('toot_card_check_balance', {id: $('#id').val()}, function (response) {
                                                        $('#toot_card_details').html(response);
                                                    }).done(function () {
                                                        reloadPage(30000);

                                                        $('#reload_paid').modal('toggle');
                                                        $('#check_balance').modal('show');
                                                        console.log('showing check_balance modal');
                                                    });
                                                } else if (response == '{{ config('static.status')[6] }}') {
                                                    reloadPage(5000);
                                                    $('#reload_canceled').modal('show');
                                                    console.log('showing reload_canceled modal');
                                                }
                                            }
                                            console.log('reload status is ' + response + '!');
                                        });
                                    }, 3000);
                                }
                            });
                        } else if (destination_id.val() == 2) {
                            $.post('toot_card_check_balance', {id: $('#id').val()}, function (response) {
                                $('#toot_card_details').html(response);
                            }).done(function () {
                                reloadPage(30000);
                                checkBalance(0);
                            });
                        } else if (destination_id.val() == 3) {
                            sendMerchandisePurchase('{{ config('static.status')[9] }}', '{{ config('static.payment_method')[1] }}');
                        } else if (destination_id.val() == 4) {
                            sendMerchandisePurchase('{{ config('static.status')[11] }}', '{{ config('static.payment_method')[1] }}');
                        }
                    } else if (response == '{{ config('static.status')[3] }}') {
                        wrongPin(2000);
                    }
                    console.log('response is ' + response + ' pin!');
                });
            }
        }

        if (enter_load_amount.hasClass('in')) {
            if (load_amount.val().length < 1) {
                emptyLoadAmount(2000);
            } else {
                if (parseFloat(load_amount.val()) > parseFloat('{{ \App\Models\Setting::value('reload_limit') }}')) {
                    exceedReloadLimit(3000);
                } else {
                    enter_load_amount.modal('toggle');
                    tapCard(0);
                }
            }
        }
    });

    function goToIdle(timeout) {
        setTimeout(function () {
            window.location.href = '{{ route('client.idle') }}';
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
            var row_count = $('#table_orders tbody tr.row-order').length;

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
                $('#btn_hold').attr('disabled', 'disabled');
                $('#btn_pay_using_toot_card').attr('disabled', 'disabled');
                $('#btn_pay_using_cash').attr('disabled', 'disabled');
            } else {
                $('#btn_hold').removeAttr('disabled');
                $('#btn_pay_using_toot_card').removeAttr('disabled');
                $('#btn_pay_using_cash').removeAttr('disabled');
            }
        });
    });

    function reloadPage(timeout) {
        setTimeout(function () {
            console.log('page reloading!');
            location.reload();
        }, timeout);
    }

    function idleTapCardListener(timeout) {
        idle_toot_card_id.focus();
        console.log('idle_toot_card_id is on focus!');
        setTimeout(function () {
            idle_toot_card_id.focus();
        }, timeout);
    }

    function emptyLoadAmount(timeout) {
        setTimeout(function () {
            $('#empty_load_amount').modal('toggle');
        }, timeout);
        $('#empty_load_amount').modal({backdrop: false});
        console.log('showing empty_load_amount modal');
    }

    function noUndoneOrders(timeout) {
        setTimeout(function () {
            no_undone_orders.modal('toggle');
        }, timeout);
        no_undone_orders.modal('show');
        console.log('showing no_undone_orders modal');
    }

    function undoneOrders(timeout) {
        setTimeout(function () {
            no_undone_orders.modal('toggle');
        }, timeout);
        undone_orders.modal('show');
        console.log('showing undone_orders modal');
    }

    function resetTootCardIdValue() {
        idle_toot_card_id.val('');
        console.log('idle_toot_card_id has been reset!');
    }

    function resetUserOrderHtml() {
        $('#user_order').html('');
        console.log('user_order has been reset!');
    }

    function toManyCardTap(timeout) {
        setTimeout(function () {
            to_many_card_tap.modal('toggle');
        }, timeout);
        to_many_card_tap.modal('show');
        console.log('showing to_many_card_tap modal');
    }

    function invalidCard(timeout) {
        setTimeout(function () {
            $('#invalid_card').modal('toggle');
        }, timeout);
        $('#invalid_card').modal('show');
        console.log('showing invalid_card modal');
    }

    function exceedReloadLimit(timeout) {
        setTimeout(function () {
            $('#exceed_reload_limit').modal('toggle');
        }, timeout);
        $('#exceed_reload_limit').modal({backdrop: false});
        console.log('showing exceed_reload_limit modal');
    }

    function enterPin(timeout) {
        setTimeout(function () {
            enter_pin.modal('toggle');
        }, timeout);
        enter_pin.modal('show');
        console.log('showing enter_pin modal');
    }

    function emptyPin(timeout) {
        setTimeout(function () {
            $('#empty_pin').modal('toggle');
        }, timeout);
        $('#empty_pin').modal({backdrop: false});
        console.log('showing empty_pin modal');
    }

    function checkBalance(timeout) {
        setTimeout(function () {
            $('#check_balance').modal('toggle');
        }, timeout);
        $('#check_balance').modal('show');
        console.log('showing check_balance modal');
    }

    function wrongPin(timeout) {
        setTimeout(function () {
            $('#wrong_pin').modal('toggle');
        }, timeout);
        $('#wrong_pin').modal({backdrop: false});
        console.log('showing wrong_pin modal');
    }

    function tapCard(timeout) {
        setTimeout(function () {
            tap_card.modal('toggle');
        }, timeout);
        tap_card.modal('show');
        console.log('showing tap_card modal');
    }

    function insufficientBalance(timeout) {
        setTimeout(function () {
            $('#insufficient_balance').modal('toggle');
        }, timeout);
        $('#insufficient_balance').modal('show');
        console.log('showing insufficient_balance modal');
    }

    function transactionCompleteWithQueueNumber(timeout) {
        setTimeout(function () {
            transaction_complete_with_queue_number.modal('toggle');
        }, timeout);
        transaction_complete_with_queue_number.modal('show');
        console.log('showing transaction_complete_with_queue_number modal');
    }

    function orderOnHold(timeout) {
        setTimeout(function () {
            order_on_hold.modal('toggle');
        }, timeout);
        order_on_hold.modal('show');
        console.log('showing order_on_hold modal');
    }

    function transactionComplete(timeout) {
        setTimeout(function () {
            transaction_complete.modal('toggle');
        }, timeout);
        transaction_complete.modal('show');
        console.log('showing transaction_complete modal');
    }

    function sendMerchandisePurchase(status, payment_method) {
        var orders = [];

        $('tr.row-order').each(function () {
            var qty = parseFloat($('span.qty', this).text());
            var each_value = $('span.each', this);
            var each = parseFloat(each_value.text());
            var total = qty * each;
            var order = {};
            order['queue_number'] = queue_number_value;
            order['order_id'] = parseInt($('#order_id').text());
            order['toot_card_id'] = $('#id').val();
            order['merchandise_id'] = $(this).data('merchandise_id');
            order['quantity'] = qty;
            order['total'] = total;
            order['status'] = status;
            order['payment_method'] = payment_method;
            orders.push(order);
        });

        $.post('merchandise_purchase',
                {orders: JSON.stringify(orders)},
                function (response) {
                    console.log(response);

                    if (response == '{{ config('static.status')[7] }}') {
                        insufficientBalance(3000);
                    } else if (response == '{{ config('static.status')[8] }}') {

                        if (payment_method == '{{ config('static.payment_method')[0] }}') {
                            transactionComplete(3000);
                            goToIdle(2000);
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
            var options = $.extend(defaults, options);
            return $(this).each(function (idx, itm) {
                setInterval(function () {
                    if ($(itm).css('visibility') === 'visible') {
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
</script>