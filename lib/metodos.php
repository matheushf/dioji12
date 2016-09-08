<?php

//$url_base = "http://dioji12.com/api/v1/";
$url_base = "http://dioji12/api/v1/";

// Fazer uma requisição à API
function conectarCurl(array $header = null, $url = null, $postField = null)
{
    global $url_base;

    $url = $url_base . $url;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'WEB Dioji');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($curl, CURLOPT_HTTPHEADER, array());
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postField);
    $curl_response = (curl_exec($curl));
    curl_close($curl);
    $Resultado = json_decode($curl_response);

    return $Resultado;
}

// Exibe mensagens definidas pela sessão
function mensagem()
{
    $html = '';

    if (isset($_SESSION['textoMensagem']['error'])) {
        $html = '<div class="alert alert-danger">' . $_SESSION['textoMensagem']['error'] . '</div>';
    }

    if (isset($_SESSION['textoMensagem']['sucesso'])) {
        $html = '<div class="alert alert-success">' . $_SESSION['textoMensagem']['sucesso'] . '</div>';
    }

    unset($_SESSION['textoMensagem']);

    return $html;
}