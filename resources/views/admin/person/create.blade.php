@extends('adminlte::page')

@section('title', 'New Person')

@section('content_header')
    <h1>New Person</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">New Person</h3>
        </div>
        <form action="{{ route('person.store') }}" method="post">
            @include('admin.person.partials.form')
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
