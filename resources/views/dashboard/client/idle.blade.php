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
    @include('dashboard.client._partials.loading', ['text' => 'Loading delicious food options'])
    @include('dashboard.client._partials.empty_pin')
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
        $('#toot_idle').on('click', function () {
            $('#menu').modal('show');
            console.log('showing menu modal');
        });

        $('#menu_order').on('click', function () {
            $('#loading').modal('show');
            console.log('showing loading modal');
            $('#menu').modal('toggle');
            console.log('route to order!');
            window.location.replace('{{ route('client.index') }}/');
        });

        $('#enter_pin').on('hidden.bs.modal', function () {
            console.log('page reloading!');
            location.reload();
        });
        $('#invalid_card').on('hidden.bs.modal', function () {
            console.log('page reloading!');
            location.reload();
        });

        var pin_code = $('#pin_code');
        $('#backspace').click(function () {
            pin_code.val(function (index, value) {
                return value.substr(0, value.length - 1);
            });
        });
        $('.key').on('click', function () {
            pin_code.val((pin_code.val()) + (this.value));
        });

        var menu_id = $('#menu_id');
        $('#menu_reload').on('click', function () {
            $('#menu').modal('toggle');
            $('#tap_card').modal('show');
            console.log('showing tap_card modal');
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
                    if (response == 'true') {
                        console.log(toot_card_id.val() + ' is valid!');
                        $('#id').val(toot_card_id.val());
                        $('#enter_pin').modal('show');
                        console.log('showing enter_pin modal');
                    } else {
                        console.log(toot_card_id.val() + ' is not valid!');
                        $('#invalid_card').modal('show');
                        console.log('showing invalid_card modal');
                    }
                });
            }
        });

        $('#tap_card').on('shown.bs.modal', function () {
            toot_card_id.focus();
            console.log('toot_card_id is on focus!');
        });

        $('#submit_check').on('click', function () {
            $(this).button('loading').delay(1000).queue(function() {
                $(this).button('reset');
                $(this).dequeue();
            });

            if (pin_code.val().length < 1) {
                $('#empty_pin').modal('show');
                console.log('showing empty_pin modal');
            } else {
                $.post('auth_toot_card', {
                    id: $('#id').val(),
                    pin_code: pin_code.val()
                }, function (response) {
                    if (response == 'true') {
                        console.log('correct pin!');
                        if (menu_id.val() == 1) {
                            console.log('showing reload modal');
                        } else if (menu_id.val() == 2) {
                            console.log('showing check_balance modal');
                        } else {
                            // default action
                            $('#loading').modal('show');
                            console.log('showing loading modal');
                            window.location.replace('{{ route('client.index') }}/');
                            console.log('route to order!');
                        }
                    } else {
                        console.log('incorrect pin!');
                        $('#wrong_pin').modal('show');
                        console.log('showing wrong_pin modal');
                    }
                });
            }
        });

        $('#touch').blink();
    </script>
@endsection