<?php
session_start();
require_once 'lib/Funcoes.php';

if (EstaLogado()) {
    header('Location: /666/');
}
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> Dioji 12 - Administração </title>

        <link href="/assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="/assets/css/animate.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
        <link href="/assets/css/style-adicional.css" rel="stylesheet">

        <!-- Mainly scripts -->
        <script src="/assets/js/jquery-1.11.3.min.js"></script>
        <script src="/assets/js/bootstrap/js/bootstrap.min.js"></script>

        <!-- Mainly scripts -->
        <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="/assets/js/jquery.maskedinput.min.js"></script>
        <script src="/assets/js/global.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="/assets/js/inspinia.js"></script>
        <script src="/assets/js/plugins/pace/pace.min.js"></script>

        <!-- Date picker -->
        <script type="text/javascript" href="/assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script type="text/javascript" href="/assets/js/plugins/datepicker/bootstrap-datepicker.pt-BR.js"></script>
        <link href="/assets/css/plugins/datepicker/datepicker3.css" rel="stylesheet">


        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


    </head>
<body class="gray-bg">

<div class="col-sm-4"></div>

<div class="col-sm-4">
    <div class="animated fadeInDown">
        <center>
            <h1 style="margin-top: 40%">Dioji 12 - Administração</h1>
            <br>
            <!--<img src="" style="width: 110px; height: 110px">-->

            <br>
        </center>
    </div>
    <div class="col-lg-12">
        <div class="ibox-contnt">
            <form class="m-t" role="form" action="lib/action.php?acao=login" method="post" id="login">

                <?php mensagem() ?>

                <div class="form-group">
                    <label for="email">Email: </label>
                    <input type="text" name="email" id="email" class="form-control" autofocus="true">
                </div>

                <div class="form-group">
                    <label for="senha">Senha: </label>
                    <input type="password" name="senha" id="senha" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b" style="margin-top: 40px">Acessar
                </button>

            </form>

        </div>
    </div>

</div>

<?php
get_foot();