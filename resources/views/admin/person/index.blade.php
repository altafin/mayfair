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
                                    <a href="{{ route(strtolower($model) . '.edit', $person->id) }}" class="btn btn-sm btn-warning btnRemove" style="margin-right: 10px;"><i class="fa fa-pen" aria-hidden="true"></i></a>
                                    <button class="btn btn-sm btn-danger btnRemove" data-id="{{ $person->id }}" data-name="{{ $person->name }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $('.btnRemove').on('click', function () {
            Swal.fire({
                title: "Você tem certeza que deseja remover ?",
                text: $(this).data('name'),
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Remover",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    removePerson($(this).data('id'));
                    // Swal.fire({
                    //     title: "Deleted!",
                    //     text: "Your file has been deleted.",
                    //     icon: "success"
                    // });
                }
            });
        });

        function removePerson(id)
        {
            var urlRemover = "{{ route(strtolower($model).'.destroy', ':id') }}";
            urlRemover = urlRemover.replace(':id', id);
            $.ajax({
                type: 'DELETE',
                url: urlRemover,
                data: ({
                    '_token': '@csrf()'
                }),
                dataType: "json",
                async: true,
                cache: false,
                beforeSend: function() {
                    // Swal.fire({
                    //     title: 'por favor, aguarde!',
                    //     html: 'Removendo o orientador',// add html attribute if you want or remove
                    //     showConfirmButton: false,
                    //     allowOutsideClick: false,
                    //     onBeforeOpen: () => {
                    //         Swal.showLoading()
                    //     },
                    // });
                },
                success: function(data) {
                    console.log(data);
                    if (!data.erro) {
                    //     let timerInterval;
                    //     Swal.fire({
                    //         icon: "success",
                    //         title: data.msg,
                    //         html: "Alerta fechará em <b></b> millisegundos.",
                    //         timer: 2000,
                    //         timerProgressBar: true,
                    //         didOpen: () => {
                    //             Swal.showLoading();
                    //             const timer = Swal.getPopup().querySelector("b");
                    //             timerInterval = setInterval(() => {
                    //                 timer.textContent = `${Swal.getTimerLeft()}`;
                    //             }, 100);
                    //         },
                    //         willClose: () => {
                    //             clearInterval(timerInterval);
                    //             location.reload();
                    //         }
                    //     }).then((result) => {
                    //         /!* Read more about handling dismissals below *!/
                    //         if (result.dismiss === Swal.DismissReason.timer) {
                    //             //console.log("I was closed by the timer");
                    //         }
                    //     });
                    } else {
                        alert('erro');
                    }
                }
                , complete: function() {}
            });


            // $.ajax({
            //     type: 'POST',
            //     url: '/admin/.destroy', id) }}',
            //     data: ({
            //         'codEvento': codevento,
            //         'codTrabalho': codTrabalho,
            //         'c': 'GerenciarTrabalhoInscrito',
            //         'm': 'removerOrientador',
            //     }),
            //     dataType: "json",
            //     async: true,
            //     cache: false,
            //     beforeSend: function() {
            //         Swal.fire({
            //             title: 'por favor, aguarde!',
            //             html: 'Removendo o orientador',// add html attribute if you want or remove
            //             showConfirmButton: false,
            //             allowOutsideClick: false,
            //             onBeforeOpen: () => {
            //                 Swal.showLoading()
            //             },
            //         });
            //     },
            //     success: function(data) {
            //         if (!data.erro) {
            //
            //             let timerInterval;
            //             Swal.fire({
            //                 icon: "success",
            //                 title: data.msg,
            //                 html: "Alerta fechará em <b></b> millisegundos.",
            //                 timer: 2000,
            //                 timerProgressBar: true,
            //                 didOpen: () => {
            //                     Swal.showLoading();
            //                     const timer = Swal.getPopup().querySelector("b");
            //                     timerInterval = setInterval(() => {
            //                         timer.textContent = `${Swal.getTimerLeft()}`;
            //                     }, 100);
            //                 },
            //                 willClose: () => {
            //                     clearInterval(timerInterval);
            //                     location.reload();
            //                 }
            //             }).then((result) => {
            //                 /* Read more about handling dismissals below */
            //                 if (result.dismiss === Swal.DismissReason.timer) {
            //                     //console.log("I was closed by the timer");
            //                 }
            //             });
            //
            //         } else {
            //             alert('erro');
            //         }
            //     }
            //     , complete: function() {}
            // });
        }
    </script>
@stop
