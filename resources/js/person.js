$(function () {
    var qtdRegistros = 50;
    $('#state').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
        ajax: {
            url: '/admin/state',
            type: "get",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term, // search term
                    page: params.page || 1,
                    qtdRegistros: qtdRegistros
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * qtdRegistros) < data.count_filtered
                    }
                };
            },
            cache: true
        },
    }).on('select2:open', function(e) {
        $('input.select2-search__field')[0].focus();
    }).on('select2:select', function(e){
        $('#city').prop("disabled", false);
        $('#city').val(null).trigger('change');
    });

    $('#city').select2({
        language: "pt-BR",
        theme: 'bootstrap4',
        ajax: {
            url: function (params) {
                return '/admin/city/' + $('#state').val();
            },
            type: "get",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term, // search term
                    page: params.page || 1,
                    qtdRegistros: qtdRegistros
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * qtdRegistros) < data.count_filtered
                    }
                };
            },
            cache: true
        },
    }).on('select2:open', function(e) {
        $('input.select2-search__field')[0].focus();
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
                exibirCidade(data.city);
                $('#number').focus();
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
        $('#city').append($('<option>', {value: city.id, text: city.name}));
    }

    $(document).keypress(function(event){
        if (event.which == '13' && event.target.nodeName == 'INPUT' && event.target.type == 'text') {
            event.preventDefault();
        }
    });

    $('#name').focus();
});
