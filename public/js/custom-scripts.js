
function registrarDados(form, modal, tabela) {
    let data = new FormData(form[0]);
    const btnSubmit = form.find('button[type="submit"]');
    const url = form.attr('action');
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(form).find('.is-invalid').removeClass('is-invalid');
            $(form).find('.is-valid').removeClass('is-valid');
            $(form).find('.invalid-feedback').text('');
            btnSubmit.prop('disabled', true);
            btnSubmit.html('<i class="fas fa-spinner fa-spin"></i> Enviando...');
        },
        success: function (response) {
            $(tabela).DataTable().ajax.reload();
            $(modal).modal('hide');
            $(form)[0].reset();
            Swal.fire({
                title: 'Sucesso',
                text: response.message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, messages) {
                var mensagem = messages[0];
                let input = $(form).find('[name="' + key + '"]');
                input.addClass('is-invalid');
                input.removeClass('is-valid');
                $(form).find('#' + key + '_invalido')
                    .addClass('invalid-feedback')
                    .text(mensagem);
            });
        },
        complete: function () {
            btnSubmit.prop('disabled', false);
            btnSubmit.html('Salvar');
        },
    });
}
