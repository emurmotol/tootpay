@extends('layouts.app')

@section('title', 'Reloads')

@section('content')
    <div class="container">
        <div class="row cahier-header">
            <div class="col-md-12">
                <h3><strong>Load Request</strong></h3>
            </div>
        </div>
        <div id="reloads" class="row"></div>
    </div>
@endsection

@section('javascript')
    <script>
        pendingReload(2000);

        function pendingReload(timeout) {
            var interval = setInterval(function() {
                console.log('interval started!');

                $.post('pending_reload', null, function(response) {
                    $('#reloads').html(response);

                    if (response != '') {
                        $('.paid').on('click', function() {
                            $(this).button('loading').delay(2000).queue(function() {
                                $(this).button('reset');
                                $(this).dequeue();
                            });

                            var id = $(this).data('id');
                            $.post('paid_reload', { id: id }, function(response) {
                                console.log(response);
                            }).done(function() { pendingReload(15000); });
                        });

                        $('.cancel').on('click', function() {
                            $(this).button('loading').delay(2000).queue(function() {
                                $(this).button('reset');
                                $(this).dequeue();
                            });

                            var id = $(this).data('id');
                            $.post('cancel_reload',  { id: id }, function(response) {
                                console.log(response);
                            }).done(function() { pendingReload(15000); });
                        });
                        // clearInterval(interval);
                        // console.log('interval stopped!');
                    }
                });
            }, timeout);
        }
    </script>
@endsection