<?php

require_once 'GeleiaUtil.class.php';

class PCampanha
{
    function obterAgenda()
    {
        global $db;

        $sql = " SELECT * FROM agenda ";
        return $db->GetObjectList($sql);
    }

    function obterPropostas()
    {

    }
}

class Campanha extends PCampanha
{

    function obterAgenda()
    {
        $agendas = parent::obterAgenda();
        $html = "<link rel='stylesheet' href='/assets/css/agenda.css'>";
        $html .= "<div class='wrapper-body'>";
        foreach ($agendas as $agenda) {
            $html .= " 
               <p> {$agenda->agen_descricao} </p>
               <small>(" . GeleiaUtil::DataComEspacos($agenda->agen_data) . ")</small>
               <hr>
             ";
        }
        $html .= "</div>";

        return $html;
    }

    function obterPropostas()
    {
        $Retorno['retorno'] = 'propostas.obter';

        $html = "
        <ul>
            <li>Placeholder</li>
        </ul>
        ";

        $Retorno['conteudo']['html'] = $html;

        return $Retorno;
    }
}