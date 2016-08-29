@extends('layouts.app')

@section('title', 'Edit - ' . $toot_card->id)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.toot_cards._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">@yield('title')</span>
                        <span class="pull-right">
                            @include('_partials.cancel', ['url' => route('toot_cards.index')])
                        </span>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.admin.toot_cards._partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('_partials.spinner')