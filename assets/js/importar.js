$(document).ready(function () {
    $("#importar").on("click", function (event) {

        if ($("#arquivo_csv").val() == '') {
            alert("Escolha um arquivo.");
            event.preventDefault();
            return;
        }
        $(this).after('<br><p id="loader"><i class="fa fa-refresh fa-spin"></i> Importando   CSV...</p>');

    })
})