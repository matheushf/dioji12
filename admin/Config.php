<?php
session_start();

ini_set('max_execution_time', 600);
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");

// Variaveis globais de sistema
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');

// Requires relacionados a Configurações e Funcões
require_once 'lib/Funcoes.php';
require_once 'lib/Global.php';
require_once 'lib/action.php';
require_once 'lib/DB.class.php';

$db = new DB();

//error_reporting(E_ALL, ~E_DEPRECATED, ~E_STRICT);
ini_set("display_errors", 1);

//set_include_path($_SERVER['DOCUMENT_ROOT'] . 'lib/' . ';' .  $_SERVER['DOCUMENT_ROOT'] . 'lib/external/GeleiaFramework/');