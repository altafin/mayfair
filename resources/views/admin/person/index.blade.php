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
                    <a href="{{ route(strtolower($model) . '.create') }}" class="btn-sm btn-outline-info float-right">Novo registro</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="example" class="table table-hover text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Ação</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($people->items() as $person)
                            <tr>
                                <td><a href="{{ route(strtolower($model) . '.edit', $person->id) }}">edit</a></td>
                                <td>{{ $person->name }}</td>
                                <td>{{ $person->type == 'J' ? 'Jurídica' : 'Física'  }}</td>
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
{{--                    <x-pagination--}}
{{--                        :paginator="$people"--}}
{{--                        :appends="$filters"--}}
{{--                    />--}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
    $(function () {
    });
    </script>
@stop
