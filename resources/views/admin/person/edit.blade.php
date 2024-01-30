@extends('adminlte::page')

@section('title', 'Edit Person')

@section('content_header')
    <h1>Edit Person - {{ $person->name }}</h1>
@stop

@section('content')
    <form action="{{ route('person.update', $person->id) }}" method="post">
        @method('PUT')
        @include('admin.person.partials.form', ['person' => $person])
    </form>
@stop

@section('css')
@stop

@section('js')
@stop
