@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', $model)

@section('content_header')
    <h1>Lista de Clientes</h1>
{{--    <h1>{{$model}}</h1>--}}
@stop

@section('content')
{{--    <p>{{$model}} List. - <a href="{{ route(strtolower($model) . '.create') }}">Create</a></p>--}}
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
            <a href="{{ route(strtolower($model) . '.create') }}" class="btn-sm btn-outline-info float-right">Novo registro</a>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Ação</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($people as $person)
                    <tr>
                        <td><a href="{{ route(strtolower($model) . '.edit', $person['id']) }}">edit</a></td>
                        <td>{{ $person['name'] }}</td>
                        <td>{{ $person['type'] }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Name</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
    $(function () {
        $('#example').DataTable({

        });
    });
    </script>
@stop
