$(function () {

    $('.btnRemovePerson').on("click", function (e) {
        $('div.modal-body').html($(this).data('name'));
        $('#modalRemoverRegistro').modal('show');
    });

    function deletePerson(url) {
        $("#deleteForm").attr('action', url);
    }

    window.deletePerson = deletePerson;

});
