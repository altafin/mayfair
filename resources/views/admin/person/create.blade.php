@extends('adminlte::page')

@section('title', 'Person')

@section('content_header')
    <h1>New Person</h1>
@stop

@section('content')
    <form action="{{ route('person.store') }}" method="post">
        @csrf()
        <label>Name</label>
        <input type="text" name="name">
        <br><label>Type</label>
        <select name="type">
            <option value="F">Física</option>
            <option value="J">Jurídica</option>
        </select>
        <br>
        <button type="submit">Enviar</button>
    </form>
@stop

@section('css')
@stop

@section('js')
@stop
