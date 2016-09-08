<?php

class PSugestao
{

    function salvar($suge_area_id, $suge_descricao, $suge_nome, $suge_celular)
    {
        global $db;

        $valores[] = $suge_area_id;
        $valores[] = $suge_descricao;
        $valores[] = $suge_nome;
        $valores[] = $suge_celular;
        $valores[] = 'API';
        $valores[] = 'ip_temp';
        $valores[] = $_SERVER['HTTP_USER_AGENT'];

        $sql = " INSERT INTO sugestao 
                (suge_id, suar_id, suge_descricao, suge_nome, suge_celular, suge_data, suge_origem, suge_ip, suge_user_agent, suge_status) 
                VALUES (NULL, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?, ?, ?, 'recebida') ";

        return $db->ExecSQL($sql, $valores);
    }

    function obter()
    {
        global $db;

        $sql = " SELECT * FROM sugestao ";
        return $db->GetObjectList($sql);
    }

    function obterQuantidade()
    {
        global $db;

        $sql = " SELECT suge_id FROM sugestao ORDER BY suge_id DESC LIMIT 1 ";
        return $db->GetObject($sql);
    }

    function obterArea() {
        global $db;

        $sql = " SELECT * FROM sugestao_area ";
        return $db->GetObjectList($sql);
    }
}

class Sugestao extends PSugestao
{

    function salvar($suge_area, $suge_descricao, $suge_nome, $suge_celular)
    {
        $Retorno['retorno'] = 'sugestao.salvar';

        $Resultado = parent::salvar($suge_area, $suge_descricao, $suge_nome, $suge_celular);

        if ($Resultado) {
            $Retorno['conteudo'] = 'sucesso';
        } else {
            $Retorno['conteudo'] = 'erro';
        }

        return $Retorno;
    }

    function obter()
    {
        $Retorno['retorno'] = 'sugestao.obter';
        $Retorno['conteudo'] = parent::obter();

        return $Retorno;
    }

    function quantidade()
    {
        $Retorno['retorno'] = 'sugestao.quantidade';
        $Retorno['conteudo'] = parent::obterQuantidade();

        return $Retorno;
    }

    function obterArea() {
        $Retorno['retorno'] = 'sugestao.area';
        $Retorno['conteudo'] = parent::obterArea();
        
        return $Retorno;
    }
}