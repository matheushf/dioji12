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
        global $db;

        $sql = " SELECT * FROM proposta ";
        return $db->GetObjectList($sql);

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
        $propostas = parent::obterPropostas();

        $html = "<link rel='stylesheet' href='/assets/css/agenda.css'>";
        $html .= "<div class='wrapper-body'>";

        foreach ($propostas as $proposta) {
            $html .= "
                   <h3> {$proposta->prop_area} </h3>
                   <p> {$proposta->prop_descricao} </p>
                   <small>(" . GeleiaUtil::DataComEspacos($proposta->prop_data) . ")</small>
                   <hr>
        ";
        }

        $html .= " </div> ";

        return $html;
    }
    
}