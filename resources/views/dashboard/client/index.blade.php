@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="#enter_pin_code" data-toggle="modal" data-dismiss="modal">
                <img src="{{ asset('img/rfid-symbol-animated.gif') }}" class="img-responsive" alt="">
            </a>

        </div>
    </div>
    <input type="number" id="toot_card_id"  pattern="[0-9]{10}" maxlength="10" autofocus>

    @include('dashboard.client._partials.pin')
@endsection

@section('javascript')
    <script>
        var pin_code = $('#pin_code');
        $('#enter_pin_code').on('hidden.bs.modal', function () {
            location.reload();
        });
        $('#backspace').click(function(){
            pin_code.val(function(index, value){
                return value.substr(0, value.length - 1);
            });
        });
        $('.key').on('click', function () {
            pin_code.val((pin_code.val()) + (this.value));
        });

        var toot_card_id = $('#toot_card_id');
        toot_card_id.change(function() {
            if($(this).val().length == 10) {
                $.post('client/check_toot_card', {
                    toot_card: $(this).val()
                }, function(response) {
                    if(response) {
                        $('#id').val(toot_card_id.val());
                        $('#enter_pin_code').modal('show');
                    }
                    console.log(toot_card_id.val() + ': ' + response);
                });
            }
        });

        $('#submit_check').on('click', function () {
            $.post('client/auth_toot_card', {
                id: $('#id').val(),
                pin_code: pin_code.val()
            }, function(response) {
//                $('#enter_pin_code').modal('toggle');
                window.location.replace(response);
                console.log(response);
            });
        });
    </script>
@endsection