@extends('adminlte::page')

@section('title', 'Person')

@section('content_header')
    <h1>New Person</h1>
@stop

@section('content')
    <form action="{{ route('person.update', $person->id) }}" method="post">
        @csrf()
        <label>Name</label>
        <input type="text" name="name" value="{{ $person->name ?? old('name') }}">
        <br><label>Type</label>
        <select name="type">
            <option value="F" {{ (($person->type == 'F' ?? old('type') == 'F') ? 'selected' : '') }}>Física</option>
            <option value="J" {{ (($person->type == 'J' ?? old('type') == 'J') ? 'selected' : '') }}>Jurídica</option>
        </select>
        <br>
        <button type="submit">Enviar</button>
    </form>
@stop

@section('css')
@stop

@section('js')
@stop
