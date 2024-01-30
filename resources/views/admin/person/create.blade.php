@extends('adminlte::page')

@section('title', 'New Person')

@section('content_header')
    <h1>New Person</h1>
@stop

@section('content')
    <form action="{{ route('person.store') }}" method="post">
        @include('admin.person.partials.form')
    </form>
@stop

@section('css')
@stop

@section('js')
@stop
