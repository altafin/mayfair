@extends('adminlte::page')

@section('title', $model)

@section('content_header')
    <h1>{{$model}}</h1>
@stop

@section('content')
    <p>{{$model}} List. - <a href="{{ route(strtolower($model) . '.create') }}">Create</a></p>
    @foreach($people as $person)
        <a href="{{ route(strtolower($model) . '.edit', $person['id']) }}">edit</a>
        {{ $person['name'] }}<br>
        {{ $person['type'] }}<br>
    @endforeach
@stop

@section('css')
@stop

@section('js')
@stop
