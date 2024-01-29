@extends('adminlte::page')

@section('title', 'Person')

@section('content_header')
    <h1>Person</h1>
@stop

@section('content')
    <p>Person List. - <a href="{{ route('person.create') }}">Create</a></p>
    @foreach($people as $person)
        <a href="{{ route('person.edit', $person['id']) }}">edit</a>
        {{ $person['name'] }}<br>
        {{ $person['type'] }}<br>
    @endforeach
@stop

@section('css')
@stop

@section('js')
@stop
