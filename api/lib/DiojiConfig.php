<?php
session_start();
session_set_cookie_params(3600);

$db = new DB();

if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    $db->host = 'localhost';
    $db->user = 'root';
    $db->password = '';
    $directory = "C:\\tmp\\";
    $diretorio_cookie = 'C:\\tmp\\';

} else {
    $db->host = 'localhost';
    $db->user = 'alan';
    $db->password = 'praxedes!';

    $diretorio_cookie = '//tmp//';
    $directory = "//srv//www//api.dioji.com//logs//";
}

//Acoes para auditar
$__acoes = array();

date_default_timezone_get('America/Sao_Paulo');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter;
use Monolog\Formatter\LineFormatter;

$logchannel = 'dioji-api';
$log = new Logger($logchannel);

$logstream = new StreamHandler($directory . $logchannel . '-' . date('d-m-Y') . '.log', Logger::WARNING);

$log->pushHandler($logstream);

$dateFormat = "d/m/Y H:i:s";
$output = "%datetime% > %channel% > %level_name% > %message% %context% %extra%\n";
$formatter = new LineFormatter($output, $dateFormat);
$logstream->setFormatter($formatter);

$log->pushProcessor(function ($record) {
    $record['extra']['ip'] = $_SERVER['REMOTE_ADDR'];
    $record['extra']['session'] = print_r($_SESSION, 1);
    $record['extra']['user-agent'] = $_SERVER['HTTP_USER_AGENT'];
    return $record;
});

class Dioji
{

    public $__id; //ultimo id gerado por um INSERT
    public $__rows; //linhas afetadas por delete, update etc..
    public $log;

    function __construct()
    {
        global $log;
    }

}

function __log($Detalhes)
{
    error_log(date('d/m/Y H:i:s') . ' - dados {' . $Detalhes . '}\n' . print_r($_SESSION, 1) . '\n\n', 3, $_SERVER['DOCUMENT_ROOT'] . '/error_manual.log');
}