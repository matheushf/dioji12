<?php
session_start();

require_once 'lib/metodos.php';

$acao = ($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

switch ($acao) {
    case 'salvar_sugestao':

        $dados = http_build_query($_POST);

        $res = conectarCurl(null, 'sugestao/salvar', $dados);

        echo json_encode($res);

        break;
}