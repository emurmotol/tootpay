@extends('layouts.app')

@section('title', 'Order History')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.cardholder._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                        <span class="pull-right">Results: 0</span>
                    </div>
                    {{--@if($merchandises->total())--}}
                        <div class="panel-body">
                            Order History
                        </div>
                    {{--@else--}}
                        {{--@include('_partials.empty')--}}
                    {{--@endif--}}
                </div>
            </div>
        </div>
    </div>
@endsection