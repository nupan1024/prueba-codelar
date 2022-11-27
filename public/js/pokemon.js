$("#formPokemon").on("submit", function (e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: $(this).attr("action").replace(/&amp;/g, "&"),
        beforeSend: function () { $('#loading').removeClass("d-none"); $('#loading').addClass("d-flex"); },
        complete: function () { $('#loading').addClass("d-none"); $('#loading').removeClass("d-flex"); },
        data: $("#formPokemon").serialize(),
        dataType: "json",
        success: function (res) {
            $('#formPokemon')[0].reset();

            if (res.error) {

                $('#msjError').removeClass('d-none');
                $('#msjError').text(res.error);
                return;
            }

            $('#msjError').addClass('d-none');
            $('#cards').prepend(res.response);
        },
    });
});
function deletePokemon(e) {

    var url_delete = $("#url_delete").data("url");
    var id = $(e).data("id");
    $.ajax({
        type: "get",
        url: url_delete,
        beforeSend: function () { $('#loading').removeClass("d-none"); $('#loading').addClass("d-flex"); },
        complete: function () { $('#loading').addClass("d-none"); $('#loading').removeClass("d-flex"); },
        data: { 'id_pokemon': id },
        dataType: "json",
        success: function (res) {

            if (res.error) {

                $('#msjError').removeClass('d-none');
                $('#msjError').text(res.error);
                return;
            }

            $('#msjError').addClass('d-none');
            $(`#pokemon_${id}`).remove();
        },
    });
}

function evolution(e) {

    var url_evolution = $("#url_evolution").data("url");
    var id = $(e).data("id");

    $.ajax({
        type: "get",
        url: url_evolution,
        beforeSend: function () { $('#loading').removeClass("d-none"); $('#loading').addClass("d-flex"); },
        complete: function () { $('#loading').addClass("d-none"); $('#loading').removeClass("d-flex"); },
        data: {
            'id_pokemon': id,
            'url': $(e).data("url")
        },
        dataType: "json",
        success: function (res) {

            if (res.error) {

                $('#msjError').removeClass('d-none');
                $('#msjError').text(res.error);
                return;
            }

            $('#msjError').addClass('d-none');
            $(`#pokemon_${id}`).remove();
            $('#cards').prepend(res.response);

        },
    });

}

