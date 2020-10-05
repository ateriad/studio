$(document).ready(function () {
    $('#request').on('click', function () {
        $.ajax({
            url: requestUrl,
            method: 'post',
            dataType: 'json',
            data: {
                cellphone: $('#cellphone').val(),
            }
        }).done((response) => {
            $('#request').parent().hide();
            $('#code').parent().removeClass('d-none');
            $('#submit').parent().removeClass('d-none');
            $('#time').html(response['expires_after']);
            successToastr(response['message']);

            setInterval(() => {
                let t = $('#time');
                if (parseInt(t.html()) > 0) {
                    t.html(parseInt(t.html()) - 1);
                } else if (t.html() === '0') {
                    t.html('');
                    window.location.reload();
                }
            }, 1000);
        }).fail(e => {
            console.log(e);
            if (e.status === 422) {
                let errors = e['responseJSON']['errors'];
                for (let i in errors) {
                    errorToastr(errors[i])
                }
            } else {
                errorToastr(e['responseJSON']['message'])
            }
        });
    });

    $('#submit').on('click', function () {
        $.ajax({
            url: submitUrl,
            method: 'post',
            dataType: 'json',
            data: {
                cellphone: $('#cellphone').val(),
                code: $('#code').val(),
                session: true,
            }
        }).done(response => {
            window.location = response['redirect'];
        }).fail(e => {
            if (e.status === 422) {
                let errors = e['responseJSON']['errors'];
                for (let i in errors) {
                    errorToastr(errors[i])
                }
            } else {
                errorToastr(e['responseJSON']['message'])
            }
        });
    });
});
