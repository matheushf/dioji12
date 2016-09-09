<?php
session_start();

// Logs de erros
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Handler/HandlerInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Handler/AbstractHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Handler/AbstractProcessingHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Psr/Log/LoggerInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Logger.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Handler/StreamHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Handler/HandlerInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Formatter/FormatterInterface.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Formatter/NormalizerFormatter.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Monolog/Formatter/LineFormatter.php';

// Lib necessaria
require $_SERVER['DOCUMENT_ROOT'] . '/api/lib/vendor/simple_html_dom.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/DB.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Campanha.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Sugestao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/lib/DiojiConfig.php';

// Util
require_once 'GeleiaUtil.class.php';

// API
require $_SERVER['DOCUMENT_ROOT'] . '/api/lib/Slim/Slim.php';
require $_SERVER['DOCUMENT_ROOT'] . '/api/lib/human_gateway_client_api/HumanClientMain.php';

// Instanciar classes
$Campanha = new Campanha();
$Sugestao = new Sugestao();

// Iniciar Configuracao API
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'cookiesencrypt' => true,
    'cookies.secret_key' => 'RiquezaPura!',
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC
));

// Definindo os objetos para serem usados dentro do $app
$app->campanha = $Campanha;
$app->sugestao = $Sugestao;

//$app->response()->header('Content-Type', 'application/json; charset=utf-8');

$app->hook('slim.before.dispatch', function () use ($app, $db) {
    $db->db = 'dioji12';
    $db->Connect();
});

$app->hook('slim.after.dispatch', function () use ($app) {
});
