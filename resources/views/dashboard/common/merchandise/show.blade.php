@extends('layouts.app')

@section('title', 'Show Merchandise')

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
                            {!! Form::open(['route' => ['merchandises.destroy', $merchandise->id], 'class' => '']) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                <a href="{{ url('merchandises') }}" class="btn btn-info btn-xs">Back</a>
                                <a href="{{ route('merchandises.edit', $merchandise->id) }}" class="btn btn-default btn-xs">Edit</a>
                                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                            {!! Form::close() !!}
                        </span>
                    </div>
                    <div class="panel-body">
                        @include('_tootpay.flash')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection