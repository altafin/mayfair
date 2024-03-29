@extends('adminlte::page')

{{--@section('plugins.Datatables', true)--}}

@section('title', $model)

@section('content_header')
    <h1>Lista de Clientes</h1>
{{--    <h1>{{$model}}</h1>--}}
@stop

@section('content')
{{--    <p>{{$model}} List. - <a href="{{ route(strtolower($model) . '.create') }}">Create</a></p>--}}
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form>
                        <div class="card-tools float-left">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="filter" value="{{ $filters['filter'] }}" class="form-control float-right" placeholder="Nome">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route(strtolower($model) . '.create') }}" class="btn-sm btn-outline-info float-right" style="border: 2px solid white; border-radius: 5px;">Novo registro</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="person" class="table table-hover text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th  style="text-align: left;">Tipo</th>
                                <th style="text-align: center;">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($people->items() as $person)
                            <tr>
                                <td>{{ $person->name }}</td>
                                <td style="width: 150px; text-align: left;">{{ $person->type == 'J' ? 'Jurídica' : 'Física'  }}</td>
                                <td style="width: 10px; text-align: right;">
                                    <a href="{{ route(strtolower($model) . '.edit', $person->id) }}" class="btn btn-sm btn-warning" style="margin-right: 10px;"><i class="fa fa-pen" aria-hidden="true"></i></a>
                                    <a href='javascript:' class="btn btn-sm btn-danger btnRemovePerson" data-id="{{ $person->id }}" data-name="{{ $person->name }}" onclick='deletePerson("{{ route(strtolower($model) . '.destroy', $person->id) }}")'><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">
                                    {{ $people->appends(['filter' => $filters['filter']])->links() }}
                                    <div>Showing {{( $people->currentpage()-1)*$people->perpage()+1 }} to {{ $people->currentpage()*$people->perpage() <= $people->total() ? $people->currentpage()*$people->perpage() : $people->total() }}
                                        of  {{ $people->total() }} entries
                                    </div>
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal fade" id="modalRemoverRegistro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="" id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header d-block alert-danger">
                                        <h4 class="modal-title text-center" id="myModalLabel">REMOVER PESSOA</h4>
                                    </div>
                                    <div class="modal-body text-center"></div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger" onclick="formSubmit()">Remover</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    @vite(['resources/js/person-list.js'])
@stop
