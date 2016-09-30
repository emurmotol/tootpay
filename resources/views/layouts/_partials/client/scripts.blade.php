<script>
    // button
    var btn_cancel = $("#btn_cancel");
    var btn_hold = $("#btn_hold");
    var btn_pay_using_toot_card = $("#btn_pay_using_toot_card");
    var btn_pay_using_toot_points = $("#btn_pay_using_toot_points");
    var btn_pay_using_cash = $("#btn_pay_using_cash");

    // input
    var last_resort = $("#last_resort");
    var pin_code = $("#pin_code");
    var toot_card_id = $("#toot_card_id");
    var user_id = $("#user_id");
    var load_amount = $("#load_amount");

    // div
    var validation_content = $("#validation_content");
    var toot_card_balance = $("#toot_card_balance");

    // modal
    var _validation = $("#validation");
    var _modal = $("._modal");
    var menu = $("#menu");
    var user_orders = $("#user_orders");
    var enter_load_amount = $("#enter_load_amount");
    var enter_pin = $("#enter_pin");
    var enter_user_id = $("#enter_user_id");
    var loading = $("#loading");
    var transaction_complete_with_queue_number = $("#transaction_complete_with_queue_number");
    var toot_card_details = $("#toot_card_details");
    var tap_card = $("#tap_card");

    // timer
    var timeout_long = 60000;
    var timeout_short = 2000;
    var _timer;
    var _interval;

    // menu
    var menu_reload_toot_card = $("#menu_reload_toot_card");
    var menu_check_balance = $("#menu_check_balance");
    var menu_order_food = $("#menu_order_food");
    var menu_share_a_load = $("#menu_share_a_load");

    // idle touch
    var toot_idle = $("#toot_idle");

    // help
    var edit_orders_help = $("#edit_orders_help");

    enter_pin.on("hidden.bs.modal", function () {
        resetPinCodeValue();
    });
    _modal.on("hidden.bs.modal", function () {
        clearTimeout(_timer);
        console.log("Timer cleared...");
    });
    tap_card.on("hidden.bs.modal", function () {
        ready(0);
        clearInterval(_interval);
        console.log("Not listening on card tap...");
    });
    toot_card_details.on("hidden.bs.modal", function () {
        resetTootCardBalanceHtml();
    });

    $(".backspace").on("click", function () {
        if (enter_pin.hasClass("in")) {
            pin_code.val(function (index, value) {
                return value.substr(0, value.length - 1);
            });
        }

        if (enter_user_id.hasClass("in")) {
            user_id.val(function (index, value) {
                return value.substr(0, value.length - 1);
            });
        }

        if (enter_load_amount.hasClass("in")) {
            load_amount.val(function (index, value) {
                return value.substr(0, value.length - 1);
            });
        }
    });
    $("#forgot").on("click", function() {
        $.playSound("{{ asset('speech/please_login_to_your_account_to_reset_your_pin_code') }}");
        validation(true, 10000, 'Please login to your account to reset your pin code. ' + '<span class="text-primary">{{ url('login') }}</span>');
    });
    edit_orders_help.on("click", function () {
        $("#orders_help").modal("show");
    });
    toot_idle.on("click", function () {
        _menu(timeout_long);
    });
    $(".key").on("click", function () {
        if (enter_pin.hasClass("in")) {
            pin_code.val((pin_code.val()) + (this.value));
        }

        if (enter_load_amount.hasClass("in")) {
            load_amount.val((load_amount.val()) + (this.value));
        }

        if (enter_user_id.hasClass("in")) {
            user_id.val((user_id.val()) + (this.value));
        }
    });
    btn_cancel.on("click", function () {
        routeToIdle(500);
        $.playSound("{{ asset('speech/transaction_canceled') }}");
        $(this).button("loading").delay(timeout_short).queue(function () {
            $(this).button("reset");
            $(this).dequeue();
        });
    });
    $("#yes").on("click", function () {
        $("#ask_for_cash").modal("hide");
        sendOrders(5, 6);
    });
    menu_reload_toot_card.on("click", function () {
        menu.modal("hide");
        resetLoadAmountValue();
        enterLoadAmount(timeout_long);
        last_resort.val(1);
        console.log("Last resort is set to 1...");
    });
    menu_check_balance.on("click", function () {
        menu.modal("hide");
        ready(1);
        last_resort.val(2);
        console.log("Last resort is set to 2...");
    });
    menu_order_food.on("click", function () {
        menu.modal("hide");
        $.playSound("{{ asset('speech/loading_menu_items') }}");
        loading.modal({backdrop: "static"});
        window.location.replace("{{ route('order.order') }}");
    });
    menu_share_a_load.on("click", function () {
        menu.modal("hide");
        resetLoadAmountValue();
        enterLoadAmount(timeout_long);
        resetUserIdValue();
        last_resort.val(5);
        console.log("Last resort is set to 5...");
    });
    btn_pay_using_toot_card.on("click", function () {
        ready(1);
        last_resort.val(3);
        console.log("Last resort is set to 3...");
    });
    btn_pay_using_toot_points.on("click", function () {
        ready(1);
        last_resort.val(6);
        console.log("Last resort is set to 6...");
    });
    btn_pay_using_cash.on("click", function () {
        sendOrders(5, 1);
    });
    $(".submit-check").on("click", function () {
        $(this).button("loading").delay(1500).queue(function () {
            $(this).button("reset");
            $(this).dequeue();
        });

        if (enter_user_id.hasClass("in")) {
            if (parseInt(user_id.val().length) < 1) {
                $.playSound("{{ asset('speech/the_user_id_field_is_required') }}");
                validation(false, timeout_short, '{!! trans('user.empty_user_id') !!}');
            } else {
                validateUserId(user_id.val());
            }
        }

        if (enter_pin.hasClass("in")) {
            if (parseInt(pin_code.val().length) < 1) {
                $.playSound("{{ asset('speech/the_pin_code_field_is_required') }}");
                validation(false, timeout_short, '{!! trans('toot_card.empty_pin') !!}');
            } else {
                authCard(toot_card_id.val(), pin_code.val());
            }
        }

        if (enter_load_amount.hasClass("in")) {
            if (parseInt(load_amount.val().length) < 1 || parseInt(load_amount.val()) < 1) {
                $.playSound("{{ asset('speech/the_load_amount_field_is_required') }}");
                validation(false, timeout_short, '{!! trans('toot_card.empty_load_amount') !!}');
            } else {
                validateLoadAmount(load_amount.val());
            }
        }
    });

    function checkCard(interval) {
        _interval = setInterval(function () {
            $.get("check_card", function (response) {
                if (response != null) {
                    if (response.status == "{{ \App\Models\StatusResponse::find(1)->name }}") {
                        tap_card.modal("hide");
                        toot_card_id.val(response.toot_card_id);
                        enterPinCode(timeout_long);
                    } else if (response.status == "{{ \App\Models\StatusResponse::find(2)->name }}") {
                        $.playSound("{{ asset('speech/whoops_invalid_toot_card') }}");
                        validation(false, timeout_short, '{!! trans('toot_card.invalid_card') !!}');
                    } else if (response.status == "{{ \App\Models\StatusResponse::find(14)->name }}") {
                        $.playSound("{{ asset('speech/whoops_too_many_card_tap') }}");
                        validation(false, timeout_short, '{!! trans('toot_card.to_many_card_tap') !!}');
                    } else if (response.status == "{{ \App\Models\StatusResponse::find(21)->name }}") {
                        $.playSound("{{ asset('speech/whoops_inactive_toot_card') }}");
                        validation(false, timeout_short, '{!! trans('toot_card.inactive_card') !!}');
                    } else if (response.status == "{{ \App\Models\StatusResponse::find(22)->name }}") {
                        $.playSound("{{ asset('speech/your_toot_card_has_expired') }}");
                        validation(false, timeout_short, '{!! trans('toot_card.expired_card') !!}');
                    }
                    console.log(response);
                }
            }, "json");
        }, interval);
    }

    function ready(bool) {
        $.post("ready", {
            bool: bool
        }, function (response) {
            console.log(response);
        }, "json").done(function (response) {
            if (response.value == 1) {
                tapCard(timeout_long);
                checkCard(1000);
                console.log("Listening on card tap...");
            }
        });
    }

    function validateUserId(user_id_value) {
        $.post("check_user_id", {
            user_id: user_id_value
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(15)->name }}") {
                enter_user_id.modal("hide");
                ready(1);
            } else if (response.status == "{{ \App\Models\StatusResponse::find(16)->name }}") {
                $.playSound("{{ asset('speech/whoops_invalid_user_id') }}");
                validation(false, timeout_short, '{!! trans('user.invalid_user_id') !!}');
            }
            console.log(response);
        }, "json");
    }

    function validateLoadAmount(load_amount_value) {
        if (last_resort.val() == 5) {
            if (parseFloat(load_amount_value) > parseFloat('{{ \App\Models\Setting::value("toot_card_max_load_limit") }}')) {
                $.playSound("{{ asset('speech/whoops_the_load_amount_you_entered_exceed_the_maximum_load_limit') }}");
                validation(false, 5000, '{!! trans('toot_card.exceed_max_load_limit', ['limit' => number_format(\App\Models\Setting::value('toot_card_max_load_limit'), 0, '.', ',')]) !!}');
            } else {
                enter_load_amount.modal("hide");
                enterUserId(timeout_long);
            }
        } else if (last_resort.val() == 1) {
            if (parseFloat(load_amount_value) > parseFloat('{{ \App\Models\Setting::value("toot_card_max_load_limit") }}')) {
                $.playSound("{{ asset('speech/whoops_the_load_amount_you_entered_exceed_the_maximum_load_limit') }}");
                validation(false, 5000, '{!! trans('toot_card.exceed_max_load_limit', ['limit' => number_format(\App\Models\Setting::value('toot_card_max_load_limit'), 0, '.', ',')]) !!}');
            } else if (parseFloat(load_amount_value) < parseFloat('{{ \App\Models\Setting::value("toot_card_min_load_limit") }}')) {
                $.playSound("{{ asset('speech/whoops_the_load_amount_you_entered_exceed_the_minimum_load_limit') }}");
                validation(false, 5000, '{!! trans('toot_card.exceed_min_load_limit', ['limit' => number_format(\App\Models\Setting::value('toot_card_min_load_limit'), 0, '.', ',')]) !!}');
            } else {
                enter_load_amount.modal("hide");
                ready(1);
            }
        }
    }

    function checkBalance(toot_card_id) {
        pleaseWait();
        $.post("check_balance", {
            toot_card_id: toot_card_id
        }, function (response) {
            $("#check_balance").html(response);
            console.log(response);
        }).done(function () {
            $("#please_wait").modal("hide");
            tootCardDetails(timeout_long);
        });
    }

    function shareLoad(toot_card_id, user_id, load_amount) {
        pleaseWait();
        $.post("share_load", {
            toot_card_id: toot_card_id,
            user_id: user_id,
            load_amount: load_amount
        }, function (response) {
            $("#please_wait").modal("hide");
            if (response.status == "{{ \App\Models\StatusResponse::find(9)->name }}") {
                $.playSound("{{ asset('speech/you_have_successfully_shared_your_load') }}");
                validation(true, 5000, '{!! trans('toot_card.load_shared') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(19)->name }}") {
                $.playSound("{{ asset('speech/whoops_the_load_amount_you_entered_exceed_the_maximum_load_limit') }}");
                validation(false, 5000, '{!! trans('toot_card.exceed_max_load_limit', ['limit' => number_format(\App\Models\Setting::value('toot_card_max_load_limit'), 0, '.', ',')]) !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(18)->name }}") {
                $.playSound("{{ asset('speech/whoops_your_load_is_not_enough_to_complete_the_load_sharing') }}");
                validation(false, 5000, '{!! trans('toot_card.insufficient_load_share') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(28)->name }}") {
                $.playSound("{{ asset('speech/whoops_cant_share_load_to_yourself') }}");
                validation(false, 5000, '{!! trans('toot_card.cant_share_load_to_yourself') !!}');
            }
            console.log(response);
        }, "json");
    }

    function reloadRequest(toot_card_id, load_amount) {
        $.post("reload_request", {
            toot_card_id: toot_card_id,
            load_amount: load_amount
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(9)->name }}") {
                $.playSound("{{ asset('speech/your_reload_request_was_successfully_sent') }}");
                validation(true, 5000, '{!! trans('toot_card.reload_request_sent') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(19)->name }}") {
                $.playSound("{{ asset('speech/whoops_the_load_amount_you_entered_exceed_the_maximum_load_limit') }}");
                validation(false, 5000, '{!! trans('toot_card.exceed_max_load_limit', ['limit' => number_format(\App\Models\Setting::value('toot_card_max_load_limit'), 0, '.', ',')]) !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(12)->name }}") {
                $.playSound("{{ asset('speech/whoops_the_load_amount_you_entered_exceed_the_minimum_load_limit') }}");
                validation(false, 5000, '{!! trans('toot_card.exceed_min_load_limit', ['limit' => number_format(\App\Models\Setting::value('toot_card_min_load_limit'), 0, '.', ',')]) !!}');
            }
            console.log(response);
        }, "json");
    }

    function authCard(toot_card_id, pin_code) {
        $.post("auth_card", {
            toot_card_id: toot_card_id,
            pin_code: pin_code
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(3)->name }}") {
                lastResort(last_resort.val());
            } else if (response.status == "{{ \App\Models\StatusResponse::find(4)->name }}") {
                $.playSound("{{ asset('speech/whoops_wrong_pin_code_try_again') }}");
                validation(false, timeout_short, '{!! trans('toot_card.wrong_pin') !!}');
            }
            resetPinCodeValue();
            console.log(response);
        }, "json");
    }

    function lastResort(last_resort_value) {
        switch (parseInt(last_resort_value)) {
            case 1:
                reloadRequest(toot_card_id.val(), load_amount.val());
                console.log("LAST_RESORT_RELOAD_TOOT_CARD");
                break;
            case 2:
                enter_pin.modal("hide");
                checkBalance(toot_card_id.val());
                console.log("LAST_RESORT_CHECK_BALANCE");
                break;
            case 3:
                enter_pin.modal("hide");
                sendOrders(10, 3);
                console.log("LAST_RESORT_QUEUED_ORDER");
                break;
            case 5:
                enter_pin.modal("hide");
                shareLoad(toot_card_id.val(), user_id.val(), load_amount.val());
                console.log("LAST_RESORT_SHARE_LOAD");
                break;
            case 6:
                enter_pin.modal("hide");
                sendOrders(10, 4);
                console.log("LAST_RESORT_TOOT_POINTS");
                break
            default:
        }
    }

    function routeToIdle(timeout) {
        _timer = setTimeout(function () {
            window.location.href = "{{ route('transaction.idle') }}";
        }, timeout);
    }

    function menuToday() {
        $.get("order/menu", function (response) {
            $("#todays_menu").html(response);

            $(".modal-footer").on("click", "button.btn-add-order", function () {
                var merchandise_id = $(this).data("merchandise_id");
                var name = $(this).data("name");
                var price = $(this).data("price");
                var element_id = $(this).data("element_id");
                var qty = $(element_id + " .modal-dialog .modal-content .modal-body .col-md-6 input.qty");
                addOrder(merchandise_id, name, price, qty.val());
                qty.val(1);
            });

            var modal_qty = $(".modal-body .row .col-md-6");
            modal_qty.on("click", "button.plus", function () {
                var qty = parseInt($(this).prev("input.qty").val());
                var new_qty = qty + 1;
                $(this).prev("input.qty").val(new_qty);
                compute();
            });
            modal_qty.on("click", "button.minus", function () {
                var qty = parseInt($(this).next("input.qty").val());
                var new_qty = ((qty - 1) < 1) ? 1 : qty - 1;
                $(this).next("input.qty").val(new_qty);
                compute();
            });
            console.log(response);
        });
    }

    $(function () {
        if (parseInt("{{ Route::is('order.order') }}")) {
            menuToday();
        }
    });

    function getOrders() {
        var orders = [];

        $("tr.row-order").each(function () {
            var qty = parseInt($("span.qty", this).text());
            var each_value = $("span.each", this);
            var each = parseFloat(each_value.text());
            var total = qty * each;
            var merchandise_id = $(this).data("merchandise_id");
            var order = {};

            order["merchandise_id"] = merchandise_id;
            order["quantity"] = qty;
            order["total"] = total;
            orders.push(order);
        });
        console.log(orders);
        return JSON.stringify(orders);
    }

    function sendOrders(status_response_id, payment_method_id) {
        var transaction = {};
        transaction["payment_method_id"] = payment_method_id;
        transaction["status_response_id"] = status_response_id;

        var _data = "";
        if (payment_method_id == 6) {
            _data = {
                lack_cash: $("#lack_cash").text(),
                orders: getOrders(),
                transaction: JSON.stringify(transaction),
                toot_card_id: toot_card_id.val()
            };
        } else {
            _data = {
                orders: getOrders(),
                transaction: JSON.stringify(transaction),
                toot_card_id: toot_card_id.val()
            };
        }

        pleaseWait();

        $.post("order/send", _data, function (response) {
            $("#please_wait").modal("hide");
            if (response.status == "{{ \App\Models\StatusResponse::find(8)->name }}") {
                $.playSound("{{ asset('speech/whoops_your_balance_is_not_enough_to_complete_the_payment') }}");
                validation(true, 5000, '{!! trans('toot_card.insufficient_balance') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(18)->name }}") {
                $.playSound("{{ asset('speech/whoops_your_load_is_not_enough_to_complete_the_payment') }}");
                validation("static", 5000, '{!! trans('toot_card.insufficient_load') !!}');
                $("#lack_cash").text(response.other);
                askForCash(5000).delay(5000);
            } else if (response.status == "{{ \App\Models\StatusResponse::find(20)->name }}") {
                $.playSound("{{ asset('speech/whoops_your_toot_points_is not_enough_to_complete_the_redeem') }}");
                validation(true, 5000, '{!! trans('toot_card.insufficient_points') !!}');
            } else {
                if (response.status == "{{ \App\Models\StatusResponse::find(5)->name }}") {
                    $.playSound("{{ asset('speech/transaction_complete') }}");

                    if (response.payment_method == "{{ \App\Models\PaymentMethod::find(1)->name }}") {
                        validation("static", 10000, '{!! trans('toot_card.transaction_complete') !!}');
                    }

                    if (response.payment_method == "{{ \App\Models\PaymentMethod::find(6)->name }}") {
                        $("#ask_for_cash").modal("hide");
                        validation(true, 10000, '{!! trans('toot_card.transaction_complete') !!}');
                    }
                    routeToIdle(1000);
                } else {
                    if (response.status == "{{ \App\Models\StatusResponse::find(12)->name }}" && response.payment_method == "{{ \App\Models\PaymentMethod::find(5)->name }}") {
                        validation("static", 10000, '{!! trans('toot_card.order_on_hold') !!}');
                    } else if (response.status == "{{ \App\Models\StatusResponse::find(10)->name }}") {
                        $("#queue_number").text(response.queue_number);
                        transactionCompleteWithQueueNumber(10000);
                    }
                    routeToIdle(2000);
                }
            }
            console.log(response);
        }, "json");
    }

    function orderRowActions(merchandise_id) {
        var order_qty = $("#merchandise_" + merchandise_id);
        order_qty.on("click", "td button.plus", function () {
            var qty = parseInt($(this).prev("span.qty").text());
            var new_qty = qty + 1;
            $(this).prev("span.qty").text(new_qty);
            compute();
        });
        order_qty.on("click", "td button.minus", function () {
            var qty = parseInt($(this).next("span.qty").text());
            var new_qty = ((qty - 1) < 1) ? 1 : qty - 1;
            $(this).next("span.qty").text(new_qty);
            compute();
        });
        $('td button.remove').on("click", function () {
            $(this).closest("tr").remove();
            compute();
        });
    }

    function pleaseWait() {
        $.playSound("{{ asset('speech/please_wait') }}");
        $("#please_wait").modal("show");
    }

    function addOrder(merchandise_id, name, price, qty) {
        var order_exist = false;

        $("tr.row-order").each(function () {
            if ($(this).data("merchandise_id") == merchandise_id) {
                var _qty = parseInt($("span.qty", this).text());
                $("span.qty", this).text(_qty + parseInt(qty));
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
        var row_count = parseInt($("#table_orders tbody tr.row-order").length);

        $("tr.row-order").each(function () {
            var qty = parseInt($("span.qty", this).text());
            var each_value = $("span.each", this);
            var each = parseFloat(each_value.text());
            each_value.text(each.toFixed(decimal_place));
            var total = qty * each;
            $("span.total", this).text(total.toFixed(decimal_place));
            grand_total += total;
        });

        $("#grand_total").text(grand_total.toFixed(decimal_place));

        if (row_count < 1) {
            btn_hold.attr("disabled", "disabled");
            btn_pay_using_toot_card.attr("disabled", "disabled");
            btn_pay_using_toot_points.attr("disabled", "disabled");
            btn_pay_using_cash.attr("disabled", "disabled");
        } else {
            btn_hold.removeAttr("disabled");
            btn_pay_using_toot_card.removeAttr("disabled");
            btn_pay_using_toot_points.removeAttr("disabled");
            btn_pay_using_cash.removeAttr("disabled");
        }
    }

    function refreshPage(timeout) {
        _timer = setTimeout(function () {
            location.reload();
        }, timeout);
    }

    function validation(backdrop, timeout, content) {
        _validation.find("#validation_content").html(content);

        switch (backdrop) {
            case true:
                if (_modal.hasClass("in")) {
                    _modal.modal("hide");
                }
                _validation.modal("show");
                break;
            case false:
                _validation.modal({backdrop: false});
                break;
            case "static":
                _validation.modal({backdrop: "static"});
                break;
            default:
        }
        setTimeout(function () {
            _validation.modal("hide");
        }, timeout);
    }

    function enterLoadAmount(timeout) {
        $.playSound("{{ asset('speech/enter_load_amount') }}");
        enter_load_amount.modal("show");
        _timer = setTimeout(function () {
            enter_load_amount.modal("hide");
        }, timeout);
    }

    function enterUserId(timeout) {
        $.playSound("{{ asset('speech/enter_user_id') }}");
        enter_user_id.modal("show");
        _timer = setTimeout(function () {
            enter_user_id.modal("hide");
        }, timeout);
    }

    function _menu(timeout) {
        $.playSound("{{ asset('speech/please_select') }}");
        menu.modal("show");
        _timer = setTimeout(function () {
            menu.modal("hide");
        }, timeout);
    }

    function enterPinCode(timeout) {
        $.playSound("{{ asset('speech/enter_your_pin_code') }}");
        enter_pin.modal("show");
        _timer = setTimeout(function () {
            enter_pin.modal("hide");
        }, timeout);
    }

    function askForCash(timeout) {
        setTimeout(function () {
            $.playSound("{{ asset('speech/would_you_like_to_cash_in') }}");
            $("#ask_for_cash").modal({backdrop: "static"});
        }, timeout);
        _timer = setTimeout(function () {
            $("#ask_for_cash").modal("hide");
        }, timeout_long);
    }

    function tootCardDetails(timeout) {
        $.playSound("{{ asset('speech/your_balance_is') }}");
        toot_card_details.modal("show");
        _timer = setTimeout(function () {
            toot_card_details.modal("hide");
        }, timeout);
    }

    function tapCard(timeout) {
        $.playSound("{{ asset('speech/please_tap_your_toot_card') }}");
        tap_card.modal("show");
        _timer = setTimeout(function () {
            tap_card.modal("hide");
        }, timeout);
    }

    function transactionCompleteWithQueueNumber(timeout) {
        $.playSound("{{ asset('speech/transaction_complete') }}");
        transaction_complete_with_queue_number.modal({backdrop: "static"});
        _timer = setTimeout(function () {
            transaction_complete_with_queue_number.modal("hide");
        }, timeout);
    }

    function resetValidationContentHtml() {
        validation_content.html("");
    }

    function resetLoadAmountValue() {
        load_amount.val("");
    }

    function resetLastResortValue() {
        last_resort.val("");
    }

    function resetUserIdValue() {
        user_id.val("");
    }

    function resetTootCardBalanceHtml() {
        toot_card_balance.html("");
    }

    function resetPinCodeValue() {
        pin_code.val("");
    }

    (function ($) {
        $.fn.blink = function (options) {
            var defaults = {delay: 500};
            var _options = $.extend(defaults, options);
            return $(this).each(function (idx, itm) {
                setInterval(function () {
                    if ($(itm).css("visibility") === "visible") {
                        $(itm).css("visibility", "hidden");
                    }
                    else {
                        $(itm).css("visibility", "visible");
                    }
                }, _options.delay);
            });
        }
    }(jQuery));

    $("#touch").blink();
</script>