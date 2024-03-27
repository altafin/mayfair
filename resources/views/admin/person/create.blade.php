@extends('adminlte::page')

@section('title', 'New ' . $model)

@section('content_header')
    <h1>Novo Cliente</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <form action="{{ route(strtolower($model) . '.store') }}" method="post">
            @include('admin.person.partials.form', ['model' => $model])
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    @vite(['resources/js/person.js'])
    <script>
        $('#name').on('blur', function() {
            var searchName = $(this).val();
            searchPersonByName(searchName);
        });

        function searchPersonByName(name)
        {
            if (name) {
                $.ajax({
                    url: '/admin/simplified/client/search',
                    type: "get",
                    dataType: 'json',
                    data: {
                        'name': name
                    },
                }).done(function (result) {
                    if (result.person)
                        console.log(result.person.length);
                });
            }
        }
    </script>
@stop
