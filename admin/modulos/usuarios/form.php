<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/Config.php';

get_head('Adicionar Usuário', 'form');

if (isset($_GET['id'])) {
    $ArrayUsuario = $Usuario->GetById($_GET['id'], true);
    $Usuario->PopulateFormFromDB($ArrayUsuario);
}
?>
    <script src="/assets/js/jquery.maskedinput.min.js"></script>
    <body>
    <fieldset class="scheduler-border" style="margin-top: 20px">
        <legend class="scheduler-border"> Adicionar Usuário</legend>
        <p> Preencha as informações corretamente: </p>
        <br>

        <form action="" method="post" id="form_usuario" enctype="multipart/form-data"
              data-operacao="<?php echo $_GET['operacao']; ?>">


            <!-- Campos do formulário -->
            <?php
            echo $Usuario->create('usua_id', 'id');
            echo $Usuario->create('usua_nome', 'Nome');

            //            if ($_GET['operacao'] == 'atualizar' || $_GET['acao'] == 'atualizar') { ?>

            <!--<label for="confirmar_senha"> Senha antiga </label>
            <input type="password" name="senha_antiga" class="form-control" id="senha_antiga" required="true">-->

            <label for="senha_nova"> Senha nova </label>
            <input type="password" name="senha_nova" class="form-control" id="senha_nova" required="true">

            <br>
            <?php
            //            } else {
            //                echo $Usuario->create('usua_senha', 'Senha');
            //            }
            echo $Usuario->create('usua_email', 'Email');
            echo $Usuario->create('usua_celular', 'Celular');
            echo $Usuario->create('usua_tipo', 'Tipo');
            echo $Usuario->create('usua_status', 'Status');
            ?>

            <center style="margin-top: 50px">
                <button class="btn btn-danger" id="cancelar"> Cancelar</button>
                <button class="btn btn-primary" id="btn-salvar"> Salvar</button>
            </center>

        </form>
    </fieldset>


    <?php
    // put your code here
    ?>
    </body>

    <script>

        jQuery(function ($) {
            $("#celular").mask("(99) 99999-9999");
        });

        $(document).ready(function () {


        })

    </script>
<?php
get_foot();
