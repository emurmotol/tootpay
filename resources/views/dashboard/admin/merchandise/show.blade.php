@extends('layouts.app')

@section('title', $merchandise->name)

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
                            {!! Form::open([
                                'route' => ['merchandises.destroy', $merchandise->id,
                                'redirect=' . request()->get('redirect')],
                                'class' => '']) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                <a href="{{ route('merchandises.edit', $merchandise->id, ['redirect' => request()->get('redirect')]) }}" class="btn btn-default btn-xs">Edit</a>
                                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                            {!! Form::close() !!}
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="img-merchandise">
                                    <a href="{{ \App\Models\Merchandise::image($merchandise->id) }}">
                                        <img src="{{ \App\Models\Merchandise::image($merchandise->id) }}" id="image-merchandise"
                                             class="img-responsive img-rounded" alt="{{ $merchandise->name }}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <ul class="list-unstyled">
                                    <li>ID: <strong>{{ $merchandise->id }}</strong></li>
                                    <li>Name: <strong>{{ $merchandise->name }}</strong></li>
                                    <li>Price: <strong>P{{ number_format($merchandise->price, 2, '.', ',') }}</strong></li>
                                    <li>Category: <strong>{{ $merchandise->merchandiseCategory->name }}</strong></li>
                                    <li>Available: <strong>{{ $merchandise->available ? 'Yes' : 'No' }}</strong></li>
                                    <li>Last Updated: <strong>{{ $merchandise->updated_at->diffForHumans() }}</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection