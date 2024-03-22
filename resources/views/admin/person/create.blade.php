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
        <form action="{{ route(strtolower($model) . '.store') }}" method="post" onsubmit="return false;">
            @include('admin.person.partials.form', ['model' => $model])
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
    @vite(['resources/js/person.js'])
    <script>
        $('#btnZipCodeSearch').on('click', function () {
            $.ajax({
                url: '/zipcode/search',
                type: "get",
                dataType: 'json',
                data: {
                    'zip_code': $('#zip_code').inputmask('unmaskedvalue')
                },
            }).done(function(data) {
                if (!('erro' in data)) {
                    $('#street').val(data.street);
                    $('#district').val(data.district);
                    exibirUF(data.state);
                    exibirCidade(null);
                }
            });
        });

        function exibirUF(state)
        {
            $('#state').append($('<option>', {value: state.id, text: state.name}));
        }

        function exibirCidade(city)
        {
            $('#city').prop("disabled", false);
        }
    </script>
@stop
