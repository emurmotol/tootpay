@extends('layouts.app')

@section('title', 'Create Merchandise')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.common.merchandise._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            @include('dashboard.common.merchandise._partials.cancel')
                        </span>
                    </div>
                    <div class="panel-body">
                        @include('_tootpay.flash')
                        @include('dashboard.common.merchandise._partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function readImageUrl(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image-merchandise').attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection