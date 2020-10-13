$(document).ready(function () {
    $(document).on('ajaxStart', function () {
        $('button').attr("disabled", true);
    }).on('ajaxStop', function () {
        $('button').attr("disabled", false);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('body').on('change', '.custom-file-input', function () {
        let name = $(this).val().split('\\').pop();
        let label = $(this).parent().find('span');

        label.text(generalLang['select_a_file']);
        if (name) {
            label.text(name + " " + generalLang['selected']);
        }
    });
});
