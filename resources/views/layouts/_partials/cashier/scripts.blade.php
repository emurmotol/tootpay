<script>
    var transaction_id = $("#transaction_id");
    var transaction_amount_due = $("#transaction_amount_due");
    var transaction_change = $("#transaction_change");
    var transaction_done = $("#transaction_done");
    var transaction_cancel = $("#transaction_cancel");

    var cash_received_minus = $("#cash_received_minus");
    var cash_received = $("#cash_received");
    var cash_received_plus = $("#cash_received_plus");
    var cash_received_backspace = $("#cash_received_backspace");
    var cash_received_clear = $("#cash_received_clear");

    var create_card_holder = $("#create_card_holder");
    var create_cardholder = $("#create_cardholder");
    var transaction_complete_with_queue_number = $("#transaction_complete_with_queue_number");

    var cash_suggestion_1 = $("#cash_suggestion_1");
    var cash_suggestion_5 = $("#cash_suggestion_5");
    var cash_suggestion_10 = $("#cash_suggestion_10");
    var cash_suggestion_20 = $("#cash_suggestion_20");
    var cash_suggestion_50 = $("#cash_suggestion_50");
    var cash_suggestion_100 = $("#cash_suggestion_100");
    var cash_suggestion_200 = $("#cash_suggestion_200");
    var cash_suggestion_500 = $("#cash_suggestion_500");
    var cash_suggestion_1000 = $("#cash_suggestion_1000");

    var _create_cardholder = $("#_create_cardholder");
    var queued_orders = $("#queued_orders");
    var _history = $("#history");
    var _reports = $("#reports");
    var queued_orders_count = $("#queued_orders_count");

    var _name = $("#name");
    var _email = $("#email");
    var _phone_number = $("#phone_number");
    var _user_id = $("#user_id");
    var _toot_card_uid = $("#toot_card_uid");

    var _validation = $("#validation");
    var _transactions = $("#transactions");
    var _modal = $(".modal");

    var decimal_place = 2;

    var timeout_long = 60000;
    var timeout_short = 1500;
    var _timer;

    compute();
    transactionsCount();
    queued();
    __history();
    reports();

    cash_suggestion_1.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_5.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_10.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_20.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_50.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_100.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_200.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_500.on("click", function () {
        addToCashReceivedValue($(this).text());
    });
    cash_suggestion_1000.on("click", function () {
        addToCashReceivedValue($(this).text());
    });

    cash_received.on("keyup", function () {
        compute();
    });

    cash_received_minus.on("click", function () {
        var current_value = parseFloat(cash_received.val());

        if (current_value == "") {
            current_value = 0;
        }
        var new_value = ((current_value - 1) < 1) ? 0 : current_value - 1;
        cash_received.val(new_value);
        compute();
    });
    cash_received_plus.on("click", function () {
        var current_value = cash_received.val();

        if (current_value == "") {
            current_value = 0;
        }
        var new_value = parseFloat(current_value) + 1;
        cash_received.val(new_value);
        compute();
    });

    cash_received_backspace.on("click", function () {
        cash_received.val(function (index, value) {
            return value.substr(0, value.length - 1);
        });
        compute();
    });
    cash_received_clear.on("click", function () {
        resetCashReceivedValue();
        compute();
    });

    _create_cardholder.on("click", function () {
        create_cardholder.modal("show");
    });

    create_cardholder.on("hidden.bs.modal", function () {
        $(this).find("#name").val("");
        $(this).find("#email").val("");
        $(this).find("#phone_number").val("");
        $(this).find("#user_id").val("");
        $(this).find("#toot_card_uid").val("");
    });

    _history.on("click", function () {
        __history();
        $("#history_modal").modal("show");
    });

    _reports.on("click", function () {
        reports();
        $("#reports_modal").modal("show");
    });

    queued_orders.on("click", function () {
        queued();
        $("#queued_modal").modal("show");
    });

    $("#refresh").on("click", function () {
        location.reload();
    });

    create_card_holder.on("click", function () {
        create_cardholder.modal("hide");
        if (_name.val() == "" && _email.val() == "" && _phone_number.val() == "" && _user_id.val() == "" && _toot_card_uid.val() == "") {
            validation(false, timeout_short, '{!! trans('user.empty_all_fields') !!}');
        } else if (_email.val() == "") {
            validation(false, timeout_short, '{!! trans('user.empty_email') !!}');
        } else if (_phone_number.val() == "") {
            validation(false, timeout_short, '{!! trans('user.empty_phone_number') !!}');
        } else if (_user_id.val() == "") {
            validation(false, timeout_short, '{!! trans('user.empty_user_id') !!}');
        } else if (_toot_card_uid.val() == "") {
            validation(false, timeout_short, '{!! trans('user.empty_toot_card_uid') !!}');
        } else if (_name.val() == "") {
            validation(false, timeout_short, '{!! trans('user.empty_name') !!}');
        } else {
            createCardHolder();
        }
    });

    transaction_done.on("click", function () {
        $("#amount_done").text(transaction_amount_due.text());
        $("#confirm_done").modal("show");
    });

    $("#yes_done").on("click", function () {
        $.post("transaction/done", {
            transaction_id: transaction_id.text()
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(11)->name }}") {
                validation(true, timeout_short, '{!! trans('transaction.done') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(10)->name }}") {
                $("#queue_number").text(response.queue_number);
                transactionCompleteWithQueueNumber(3000);
            }
            resetToDefault();
            console.log(response);
        }, "json");
    });

    transaction_cancel.on("click", function () {
        $("#amount_cancel").text(transaction_amount_due.text());
        $("#confirm_cancel").modal("show");
    });

    $("#yes_cancel").on("click", function () {
        $.post("transaction/cancel", {
            transaction_id: transaction_id.text()
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(7)->name }}") {
                validation(true, timeout_short, '{!! trans('transaction.canceled') !!}');
            }
            resetToDefault();
            console.log(response);
        }, "json");
    });

    function createCardHolder() {
        $.post("transaction/create_card_holder", {
            name: _name.val(),
            email: _email.val(),
            phone_number: _phone_number.val(),
            user_id: _user_id.val(),
            toot_card_uid: _toot_card_uid.val()
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(2)->name }}") {
                validation(false, timeout_short, '{!! trans('toot_card.invalid_card') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(23)->name }}") {
                validation(true, timeout_short, '{!! trans('user.cardholder_created') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(24)->name }}") {
                validation(false, timeout_short, '{!! trans('toot_card.active') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(25)->name }}") {
                validation(false, timeout_short, '{!! trans('toot_card.already_associated') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(26)->name }}") {
                validation(false, timeout_short, '{!! trans('user.user_id_exist') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(27)->name }}") {
                validation(false, timeout_short, '{!! trans('user.email_exist') !!}');
            }
            console.log(response);
        }, "json");
    }

    function transactionCompleteWithQueueNumber(timeout) {
        transaction_complete_with_queue_number.modal({backdrop: true});
        _timer = setTimeout(function () {
            transaction_complete_with_queue_number.modal("hide");
        }, timeout);
    }

    function resetToDefault() {
        resetCashReceivedValue();
        resetTransactionAmountDueText();
        resetTransactionChangeText();
        resetTransactionIdText();
        transaction_done.attr("disabled", "disabled");
        transaction_cancel.attr("disabled", "disabled");
    }

    function validation(backdrop, timeout, content) {
        _validation.find("#validation_content").html(content);

        switch (backdrop) {
            case true:
                if (_modal.hasClass("in")) {
                    _modal.modal("hide");
                }
                _validation.modal({backdrop: true});
                break;
            case false:
                _validation.modal({backdrop: false});
                break;
            case "static":
                _validation.modal({backdrop: "static"});
                break;
            default:
        }
        _timer = setTimeout(function () {
            _validation.modal("hide");
        }, timeout);
    }

    function transactionsCount() {
        setInterval(function () {
            $.get("transactions/count", function (response) {
                var count = parseInt(response);

                if (count != $('.well-transaction').length) {
                    transactions();
                    resetToDefault();
                }
            });
        }, 1500);
    }

    function queued() {
        $.get("transactions/cashier/queued", function (response) {
            if (response != "") {
                $("#queued_div").html(response);
                $(".queued-entry").on("click", ".btn-served-order", function () {
                    console.log($(this).data("transaction_id"));
                    served($(this).data("transaction_id"));
                    location.reload();
                });
            } else {
                $("#queued_div").html("<div class='text-muted text-center'>Empty.</div>");
            }
        });
    }

    function __history() {
        $.get("transactions/cashier/history", function (response) {
            if (response != "") {
                $("#history_div").html(response);
            } else {
                $("#history_div").html("<div class='text-muted text-center'>Empty.</div>");
            }
        });
    }

    function reports() {
        $.get("transactions/cashier/reports", function (response) {
            if (response != "") {
                $("#reports_div").html(response);
            } else {
                $("#reports_div").html("<div class='text-muted text-center'>Empty.</div>");
            }
        });
    }

    function served(transaction_id) {
        $.post("served", {
            transaction_id: transaction_id
        }, function (response) {
            $("#queued_modal").modal("hide");
            console.log(response);
        }, "json").done(function () {
            queued();
        });
    }

    function transactions() {
        $.get("transactions/cashier", function (response) {
            _transactions.html(response);

            _transactions.on("click", ".transaction-entry", function () {
                transaction_id.text($(this).data("transaction_id"));
                transaction_amount_due.text($(this).find("#grand_total").text());
                compute();
            });
        });
    }

    function compute() {
        var change = parseFloat(cash_received.val()) - parseFloat(transaction_amount_due.text().split(",").join(""));
        transaction_change.text(change.toFixed(decimal_place));

        if (parseFloat(transaction_change.text()) < 0 || parseFloat(transaction_amount_due.text()) == 0) {
            transaction_done.attr("disabled", "disabled");
            transaction_cancel.attr("disabled", "disabled");
        } else {
            transaction_done.removeAttr("disabled");
            transaction_cancel.removeAttr("disabled");
        }
    }

    function addToCashReceivedValue(value) {
        var current_value = cash_received.val();

        if (current_value == "") {
            current_value = 0;
        }
        var new_value = parseFloat(current_value) + parseFloat(value);
        cash_received.val(new_value);
        compute();
    }

    function resetCashReceivedValue() {
        cash_received.val(0);
    }

    function resetTransactionIdText() {
        transaction_id.text("");
    }

    function resetTransactionAmountDueText() {
        transaction_amount_due.text("0.00");
    }

    function resetTransactionChangeText() {
        transaction_change.text("0.00");
    }
</script>