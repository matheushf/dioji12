<?php
include 'head.php';
$sugestao_area = conectarCurl(null, 'sugestao/area/obter');
?>
    <script>
        function declararArea() {
            area = document.getElementsByClassName('sugestao-intro');
        }
    </script>

    <div class="col-sm-3"></div>
    <div class="col-sm-6">

        <div class="sugestao-intro text-center">

            <?= mensagem() ?>

            <!-- <h2 class="sugestao-quantidade">
            <b><? /*= conectarCurl(null, 'sugestao/quantidade')->conteudo->suge_id */ ?></b>
            Sugestões
        </h2>-->

            <h3 class="sugestao-titulo"> ENVIE SUA SUGESTÃO PARA DIOJI12 </h3>

            <form action="acoes.php?acao=salvar_sugestao" method="post" enctype="multipart/form-data">

                <div class="form-group">

                    <select class="form-control" name="suge_area_id">
                        <option value="">Selecione uma área...</option>
                        <?php foreach ($sugestao_area->conteudo as $area) { ?>
                            <option value="<?= $area->suar_id ?>"><?= $area->suar_descricao ?></option>
                        <?php } ?>
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

                    <input type="text" class="form-control" name="suge_celular" placeholder="(62) 0000-0000.."/>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-enviar">ENVIAR SUGESTÃO</button>
                </div>

            </form>

        </div>

<?php
include 'foot.php';