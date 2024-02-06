@extends('adminlte::page')

@section('title', 'New ' . $model)

@section('content_header')
    <h1>New {{ $model }}</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">New {{ $model }}</h3>
        </div>
        <form action="{{ route(strtolower($model) . '.store') }}" method="post">
            @include('admin.person.partials.form', ['model' => $model])
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
