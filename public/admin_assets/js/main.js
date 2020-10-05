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
});
