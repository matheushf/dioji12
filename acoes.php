<?php
session_start();

require_once 'lib/metodos.php';

$acao = ($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

switch ($acao) {
    case 'salvar_sugestao':

        $dados = http_build_query($_POST);

        $res = conectarCurl(null, 'sugestao/salvar', $dados);

        if ($res)
            $_SESSION['textoMensagem']['sucesso'] = 'Sua sugestão foi enviada com sucesso.';
        else
            $_SESSION['textoMensagem']['error'] = 'Ocorreu um erro ao enviar a sugestão, tente novamente mais tarde.';

        header('Location: index.php');

        break;
}