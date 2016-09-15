<?php
include 'head.php';
?>

    <script>
        function declararArea() {
            area = document.getElementsByClassName('sugestao-intro');
        }
    </script>

    <div class="col-sm-3"></div>
    <div class="col-sm-6">

        <div class="sugestao-intro text-center">

            <h3 class="sugestao-titulo"> ENVIE SUA SUGESTÃO PARA DIOJI12 </h3>

            <form action="acoes.php?acao=salvar_sugestao" method="post" enctype="multipart/form-data" id="form">

                <div class="form-group">

                    <select class="form-control" name="suge_area_id">
                        <option value="">Selecione uma área...</option>
                    </select>
                </div>

                <div class="form-group">
                <textarea class="form-control" rows="5" placeholder="Escreva uma sugestão.."
                          name="suge_descricao"></textarea>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="suge_nome" placeholder="Seu nome.."/>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control mask-telefone" name="suge_celular"
                           placeholder="(62) 0000-0000.."/>
                </div>
                
                <div class="form-group">
                    <button type="" class="btn btn-enviar">ENVIAR SUGESTÃO</button>
                </div>

            </form>

        </div>

        <div id="modal_respota" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h3><span id="resposta"></span></h3>
                    </div>
<!--                    <div class="modal-body"></div>-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

<?php
include 'foot.php';