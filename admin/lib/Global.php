<?php
$doc_root = $_SERVER['DOCUMENT_ROOT'] . '/';

//ini_set("include_path", ini_get("include_path") . ';/' . $doc_root . "lib/" . ';/' . $doc_root . "admin/lib/external/");
ini_set("include_path", $doc_root . "admin/lib/external/" . ";/" . $doc_root . "admin/lib/external/");

// Requires relacionadas a Lib
require_once 'external/GeleiaFramework/UserControl.class.php';
require_once 'external/GeleiaFramework/Form.class.php';
require_once 'external/GeleiaFramework/FormMobile.class.php';
require_once 'external/Zend/Mail/Transport/Smtp.php';
require_once 'Geleia.class.php';
require_once 'GeleiaMobile.class.php';
require_once 'Usuario.class.php';
require_once 'FuncoesPadroes.php';
//die('doge doge');

// Instanciar Classes
$Global = new Geleia();
$FuncoesPadroes = new FuncoesPadroes();
$Usuario = new Usuario('usuario');

// Operações Usadas em GRID

// Ordenação
if ($_GET['ordem'] == 'ASC') {
    $ordem = 'DESC';
} else {
    $ordem = 'ASC';
}

if ($_GET['ordem'] != '') {
    $OrderBy = 'ORDER BY ' . $_GET['by'] . ' ' . $_GET['ordem'];
} else {
    $OrderBy = null;
}

// Busca{
if ($_GET['busca']) {
    $Search = $_GET['busca'];
} else {
    $Search = null;
}

// Verificar se está logado
if (!EstaLogado() && !PaginasLivres()) {
//    header('Location: /index.php');
}

// Paginação
if ($_GET['page'] && $_GET['page'] != 1) {
    $Pagina = $_GET['page'];
    $limit = 100;
    $ofset = ($limit * $Pagina) - $limit;
    $Paginacao = 'LIMIT ' . $limit . ' OFFSET ' . $ofset;
} else {
    $Pagina = 1;
    $Paginacao = ' LIMIT 100 ';
}