/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#btn-salvar").on("click", function(event) {
//        event.preventDefault();
        
        var modulo = $("form").attr("id");
        modulo =  modulo.split("_");
        modulo = modulo[1];

        if ($("form").data("operacao") == 'inserir') {
            $("form").attr("action", "?acao=inserir&modulo=" + modulo);
        } else if ($("form").data("operacao") == 'atualizar') {
            $("form").attr("action", "?acao=atualizar&modulo=" + modulo);
        }
    })
});