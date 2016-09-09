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

    var create_cardholder = $("#create_cardholder");
    var queued_orders = $("#queued_orders");
    var queued_orders_count = $("#queued_orders_count");

    var _validation = $("#validation");
    var _transactions = $("#transactions");
    var _modal = $(".modal");

    var decimal_place = 2;

    var timeout_long = 60000;
    var timeout_short = 1500;
    var _timer;

    compute();
    transactionsCount();

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

    transaction_done.on("click", function () {
        $.post("transaction/done", {
            transaction_id: transaction_id.text()
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(11)->name }}") {
                validation(true, timeout_short, '{!! trans('transaction.done') !!}');
            } else if (response.status == "{{ \App\Models\StatusResponse::find(10)->name }}") {
                $("#queue_number").text(response.queue_number);
                transactionCompleteWithQueueNumber(timeout_short);
            }
            console.log(response);
        }, "json").done(function() {
            resetToDefault();
        });
    });
    transaction_cancel.on("click", function () {
        $.post("transaction/cancel", {
            transaction_id: transaction_id.text()
        }, function (response) {
            if (response.status == "{{ \App\Models\StatusResponse::find(7)->name }}") {
                validation(true, timeout_short, '{!! trans('transaction.canceled') !!}');
            }
            console.log(response);
        }, "json").done(function() {
            resetToDefault();
        });
    });

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
                }
            });
        }, 1500);
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

        if (parseFloat(transaction_change.text()) < 0.00 || parseInt(transaction_id.text()) == 0) {
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
        transaction_id.text(0);
    }

    function resetTransactionAmountDueText() {
        transaction_amount_due.text("0.00");
    }

    function resetTransactionChangeText() {
        transaction_change.text("0.00");
    }
</script>