@extends('adminlte::page')

@section('title', 'New ' . $model)

@section('content_header')
    <h1>Novo Cliente</h1>
{{--    <h1>New {{ $model }}</h1>--}}
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
    <script>
        $(function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
            $('[data-mask]').inputmask();
            $('#type').on('change', function () {
                $('#document').val('');
                let opt = $(this).find(':selected').val();
                var maskuse, labeluse;

                switch (opt) {
                    case 'F':
                        labeluse = 'CPF';
                        maskuse = '999.999.999-99';
                        break;
                    case 'J':
                        labeluse = 'CNPJ';
                        maskuse = '99.999.999/9999-99';
                        break;
                }
                $('label[for="document"]').text(labeluse);
                $('#document').attr('data-inputmask', "'mask':'".concat(maskuse).concat("'")).inputmask();
            });
        });
    </script>
@stop
