@extends('adminlte::page')

@section('title', 'Person')

@section('content_header')
    <h1>Person</h1>
@stop

@section('content')
    <p>Person List.</p>
    @foreach($people as $person)
        {{ $person['name'] }}<br>
        {{ $person['type'] }}<br>
    @endforeach
@stop

@section('css')
@stop

@section('js')
@stop
