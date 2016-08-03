@extends('layouts.app')

@section('title', 'Client Idle')

@section('content')
    <div id="toot_idle" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            @foreach(glob('img/idle/*.png') as $img)
                <div class="item {{ (glob('img/idle/*.png')[0] == $img) ? 'active' : '' }}">
                    <img src="{{ asset($img) }}" class="img-responsive">
                </div>
            @endforeach
            <div class="carousel-caption">
                <h1 id="touch">Touch the screen to interact.</h1>
            </div>
        </div>
    </div>
    @include('dashboard.client._partials.identity_prompt')
    @include('dashboard.client._partials.tap')
    @include('dashboard.client._partials.pin')
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
            $('#identity_prompt').modal('show');
        });

        $('#identity_prompt_no').on('click', function () {
            window.location.replace('{{ route('client.index') }}/');
        });
        $('#identity_prompt_yes').on('click', function () {
            $('#identity_prompt').modal('toggle');
            $('#tap').modal('show');
        });

        $('#enter_pin_code').on('hidden.bs.modal', function () {
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

        var toot_card_id = $('#toot_card_id');
        toot_card_id.focus();
        toot_card_id.blur(function () {
            setTimeout(function () {
                toot_card_id.focus();
            }, 0);
        });

        $('#tap').on('shown.bs.modal', function () {
            toot_card_id.focus();
        });

        toot_card_id.change(function () {
            if ($(this).val().length == 10) {
                $.post('check_toot_card', {
                    toot_card: $(this).val()
                }, function (response) {
                    if (response == 'true') {
                        $('#tap').modal('toggle');
                        $('#id').val(toot_card_id.val());
                        $('#enter_pin_code').modal('show');
                    } else {
                        location.reload();
                    }
                    console.log(toot_card_id.val() + ' valid? ' + response);
                });
            }
        });

        $('#submit_check').on('click', function () {
            $(this).button('loading').delay(5000).queue(function() {
                $(this).button('reset');
                $(this).dequeue();
            });

            $.post('auth_toot_card', {
                id: $('#id').val(),
                pin_code: pin_code.val()
            }, function (response) {
                if (response == 'true') {
                    window.location.replace('{{ route('client.index') }}/');
                }
                console.log(response);
            });
        });

        $('#touch').blink();
    </script>
@endsection