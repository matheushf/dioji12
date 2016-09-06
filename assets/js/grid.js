/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    $("#btn-novo").on("click", function () {
        window.location.assign("form.php?operacao=inserir");
    });

    $("#btn-editar").on("click", function () {
        if (!(id = PegarId())) {
            return false;
        }

        window.location.assign("form.php?operacao=atualizar&id=" + id);
    });

    $("#btn-excluir").on("click", function () {

        var modulo = $("#modulo").val();

        if (!confirm("Tem certeza que deseja excluir? ")) {
            return;
        }

        var ArrayId = [];
        var i = 0;
        $("input:checked").not("#check_all").each(function () {
            ArrayId[i] = $(this).val();
            i = i + 1;
        });

        $.ajax({
            type: 'POST',
            url: '/lib/action.php',
            data: {
                acao: 'excluir',
                id: ArrayId,
                modulo: modulo
            },
            success: function (data) {
                if (data == "OK") {
                    $("input:checked").parents("tr").remove();
                    var mensagem = '<div class="alert alert-success"> Registro excluído com sucesso. </div>';
                    $("#mensagens").html(mensagem);
                } else if (data == "ERRO") {
                    var mensagem = '<div class="alert alert-danger"> Ocorreu um erro ao excluir o registro. </div>';
                    $("#mensagens").html(mensagem);
                } else {
                    console.log(data);
                }
            }
        })

    })

    // Buscador
    $("#procurar").click(function (event) {
        event.preventDefault();
        window.location.assign("?busca=" + $("#busca").val());
    })

    // Variáveis para funcionalidade de marcar linha clicada na grid
    selecionado = null;
    todos_selecionados = false;
    tr_click = false;
    link = false;

    // Selecionar todos checkbox
    $("#check_all").on("change", function () {
        if (!tr) {
            ChecarTodos();
        }
    })

    // Pequeno hack para tirar o bug ao selecionar todos
    $("input:checkbox").on("click", function () {
        selecionado = true;
    })

    $("a").on("click", function () {
        link = true;
    });

    $("tr").on("click", function () {

        if (link) {
            link = false;
            return;
        }

        var checkbox = $(this).find(':checkbox');

        if (checkbox.attr("id") == "check_all") {
            tr_click = true;
            ChecarTodos();
            return;
        }

        if (selecionado) {
            selecionado = false;
            return;
        }

        if (!checkbox.is(':checked')) {
            checkbox.prop("checked", true);
        } else {
            checkbox.prop("checked", false);
        }
    });
})

function PegarId() {
    if ($("input:checked").length == 0) {
        alert("Escolha pelo menos um registro.");
        return false;
    }

    if ($("input:checked").length >= 2) {
        alert('Selecione apenas um registro.');
        return;
    }

    var id = $("input:checked").val();

    return id;
}

function ChecarTodos() {
    if (todos_selecionados) {
        todos_selecionados = false;
    } else {
        todos_selecionados = true;
    }

    $("input:checkbox").each(function () {
        if (todos_selecionados) {
            $(this).prop("checked", true);

        } else {
            $(this).prop("checked", false);
        }
    })
}