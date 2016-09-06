<?php
require_once 'head.php';

$app->get('/', function () use ($app) {
    $retorno['url'] = 'dioji12.com';
    echo json_encode($retorno);
});

$app->post('/v1/agenda/salvar', function () use ($app, $Agenda) {
    $retorno['url'] = '/v1/agenda/salvar';
    echo json_encode($retorno);
});

//Apenas mostrar na tela o html
$app->get('/v1/agenda/obter', function () use ($app) {
    $Resultado = $app->campanha->obterAgenda();

    echo $Resultado;
});

$app->post('/v1/proposta/salvar', function () use ($app) {
    $retorno['url'] = '/v1/propostas/salvar';
    echo json_encode($retorno);
});

// Apenas mostrar na tela o html
$app->get('/v1/proposta/obter', function () use ($app) {
    $Resultado = $app->campanha->obterPropostas();

    echo $Resultado;
});

$app->post('/v1/sugestao/salvar', function () use ($app) {

    $suge_area_id = $app->request->post('suge_area_id');
    $suge_descricao = $app->request->post('suge_descricao');
    $suge_nome = $app->request->post('suge_nome');
    $suge_celular = $app->request->post('suge_celular');

    $Resultado = $app->sugestao->salvar($suge_area_id, $suge_descricao, $suge_nome, $suge_celular);

    echo json_encode($Resultado);
});

$app->post('/v1/sugestao/obter', function () use ($app) {

    $Resultado = $app->sugestao->obter();
    echo json_encode($Resultado);
});

$app->post('/v1/sugestao/quantidade', function () use ($app, $Sugestao) {

    $Resultado = $app->sugestao->quantidade();
    echo json_encode($Resultado);
});

$app->post('/v1/sugestao/area/obter', function () use ($app) {
    $Resultado = $app->sugestao->obterArea();
    echo json_encode($Resultado);
});

$app->run();