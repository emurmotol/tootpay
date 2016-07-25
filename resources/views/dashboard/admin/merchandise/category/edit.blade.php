@extends('layouts.app')

@section('title', 'Edit - ' . $merchandise_category->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('dashboard.admin.merchandise._partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @yield('title')
                        <span class="pull-right">
                            @include('_partials.cancel', ['url' => route('merchandise.categories.index')])
                        </span>
                    </div>
                    <div class="panel-body">
                        @include('dashboard.admin.merchandise.category._partials.form')
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $merchandise_category->name . ' - ' . \App\Models\Merchandise::byCategory($merchandise_category->id)->get()->count() . ' entries' }}
                    </div>
                    @if(\App\Models\Merchandise::byCategory($merchandise_category->id)->get()->count())
                        <div class="panel-body">
                            @include('_partials.search')
                            @if(\App\Models\Merchandise::byCategory($merchandise_category->id)->get()->count())
                                @include('dashboard.admin.merchandise._partials.sort')
                            @endif
                        </div>
                        @include('dashboard.admin.merchandise._partials.table_edit_category')
                    @else
                        @include('_partials.empty')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@include('_partials.spinner')