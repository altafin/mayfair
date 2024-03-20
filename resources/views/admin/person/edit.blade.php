@extends('adminlte::page')

@section('title', 'Edit ' . $model)

@section('content_header')
    <h1>Edit {{ $model }} - {{ $person->name }}</h1>
@stop

@section('content')
    <form action="{{ route(strtolower($model) . '.update', $person->id) }}" method="post">
        @method('PUT')
        @include('admin.person.partials.form', ['person' => $person, 'model' => $model])
    </form>
@stop

@section('css')
@stop

@section('js')
    @vite(['resources/js/person.js'])
@stop
