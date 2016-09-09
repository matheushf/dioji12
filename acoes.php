<?php
session_start();

require_once 'lib/metodos.php';

$acao = ($_POST['acao']) ? $_POST['acao'] : $_GET['acao'];

switch ($acao) {
    case 'salvar_sugestao':

        $res = conectarCurl(null, 'sugestao/salvar', $_POST['dados']);

        echo json_encode($res);

        break;
}