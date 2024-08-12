var search = "";

$(document).on("submit", ".form-search-global", function (event) {
    var parametros = $(this).serialize();
    search = $('.txtSearchGlobal').val();
    loadSearchGlobal();
    event.preventDefault();
});

function loadSearchGlobal() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: base_url + '/searchGlobal',
        method: 'POST',
        dataType: 'JSON',
        data: {
            search: search,
        },
        beforeSend: function (objeto) {
            $('.btnSearchGlobal').html('<span class="spinner-border spin-x" role="status" aria-hidden="true"></span>');
            $(".div-cnt-search-global").html('<div class="text-center alert alert-dark" role="alert">' +
                '<span class="spinner-border spin-x" role="status" aria-hidden="true"></span> Buscando...</div>');
        },
        success: function (res) {
            $('.div-cnt-search-global').html(res.search);
            $('.btnSearchGlobal').html('<i class="bi bi-search"></i>');
        },
        error: function (data) {
            $(".btnSearchGlobal").html('<i class="bi bi-search"></i>');
            $(".div-cnt-search-global").html('<div class="text-center alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i> Error interno, intenta más tarde.</div>');
        }
    });
}