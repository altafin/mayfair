@extends('adminlte::page')

@section('title', 'Edit ' . $model)

@section('content_header')
    <h1>Edit {{ $model }} - {{ $person->name }}</h1>
@stop

@section('content')
    <form action="{{ route(strtolower($model) . '.update', $person->id) }}" method="post">
        @method('PUT')
        @include('admin.person.partials.form', ['person' => $person, 'model' => $model])
    </form>
@stop

@section('css')
@stop

@section('js')
    <script type="application/javascript" src="/js/person.js"></script>
{{--    <script>--}}
{{--        $(function () {--}}
{{--            $('[data-mask]').inputmask();--}}
{{--            $('#type').on('change', function () {--}}
{{--                $('#document').val('');--}}
{{--                let opt = $(this).find(':selected').val();--}}
{{--                var maskuse, labeluse;--}}

{{--                switch (opt) {--}}
{{--                    case 'F':--}}
{{--                        labeluse = 'CPF';--}}
{{--                        maskuse = '999.999.999-99';--}}
{{--                        break;--}}
{{--                    case 'J':--}}
{{--                        labeluse = 'CNPJ';--}}
{{--                        maskuse = '99.999.999/9999-99';--}}
{{--                        break;--}}
{{--                }--}}
{{--                $('label[for="document"]').text(labeluse);--}}
{{--                $('#document').attr('data-inputmask', "'mask':'".concat(maskuse).concat("'")).inputmask();--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@stop
