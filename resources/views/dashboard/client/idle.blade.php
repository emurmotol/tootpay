@extends('layouts.app')

@section('title', 'Client Idle')

@section('content')
    <div id="toot_idle" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @foreach(glob('img/slides/*.png') as $img)
                <div class="item {{ (glob('img/slides/*.png')[0] == $img) ? 'active' : '' }}">
                    <img src="{{ asset($img) }}" class="img-responsive">
                </div>
            @endforeach
            <div class="carousel-caption">
                <h1 id="touch">Touch the screen to interact.</h1>
            </div>
        </div>
    </div>
    @include('dashboard.client._partials.tap_card')
    @include('dashboard.client._partials.enter_pin')
    @include('dashboard.client._partials.invalid_card')
    @include('dashboard.client._partials.wrong_pin')
    @include('dashboard.client._partials.menu')
    @include('dashboard.client._partials.loading')
    @include('dashboard.client._partials.empty_pin')
    @include('dashboard.client._partials.check_balance')
    @include('dashboard.client._partials.enter_load_amount')
    @include('dashboard.client._partials.empty_load_amount')
    @include('dashboard.client._partials.waiting_for_payment')
    @include('dashboard.client._partials.reload_paid')
    @include('dashboard.client._partials.reload_canceled')
@endsection

@section('style')
    <style>
        body {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .table th, .table td, .table-responsive {
            border: none !important;
        }
    </style>
@endsection

@section('javascript')
    <script>
        $('#touch').blink();
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
            window.location.replace('{{ route('client.index') }}/');
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
                        setTimeout(function() {
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
            $(this).button('loading').delay(1000).queue(function() {
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
                                }, function(response) {

                                    if (response != null) {
                                        console.log('reload_id is ' + response + '!');

                                        var interval = setInterval(function() {
                                            $.post('reload_status', {
                                                id: $('#id').val(),
                                                reload_id: response
                                            }, function(response) {

                                                if (response == 'pending') {
                                                    var waiting_for_payment = $('#waiting_for_payment');

                                                    if (!waiting_for_payment.hasClass('in')) {
                                                        $('#loading').modal('toggle');
                                                        $('#_amount').text(load_amount.val());
                                                        console.log('_amount is set to ' + load_amount.val() + '!');
                                                        waiting_for_payment.modal({backdrop: 'static'});
                                                        console.log('showing waiting_for_payment modal');
                                                    }
                                                } else {
                                                    $('#waiting_for_payment').modal('toggle');
                                                    clearInterval(interval);

                                                    if (response == 'paid') {
                                                        $('#reload_paid').modal('show');
                                                        console.log('showing reload_paid modal');

                                                        $.post('check_balance', { id: $('#id').val() }, function(response) {
                                                            $('#toot_card_details').html(response);
                                                        }).done(function() {
                                                            setTimeout(function() {
                                                                console.log('page reloading!');
                                                                location.reload();
                                                            }, 30000);

                                                            $('#reload_paid').modal('toggle');
                                                            $('#check_balance').modal('show');
                                                            console.log('showing check_balance modal');
                                                        });
                                                    } else if (response == 'canceled') {
                                                        setTimeout(function() {
                                                            console.log('page reloading!');
                                                            location.reload();
                                                        }, 5000);

                                                        $('#reload_canceled').modal('show');
                                                        console.log('showing reload_canceled modal');
                                                    }
                                                }
                                                console.log('reload status is ' + response + '!');
                                            });
                                        }, 1500);
                                    }
                                });
                            } else if (menu_id.val() == 2) {
                                $.post('check_balance', { id: $('#id').val() }, function(response) {
                                    $('#toot_card_details').html(response);
                                }).done(function() {
                                    setTimeout(function() {
                                        console.log('page reloading!');
                                        location.reload();
                                    }, 30000);

                                    $('#check_balance').modal('show');
                                    console.log('showing check_balance modal');
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
    </script>
@endsection