<?php

require_once DOCUMENT_ROOT . "/lib/DB.class.php";
$db = new DB();

/**
 * $CamposTabela = ['EPS', 'Centro', 'Cidade', 'Status', 'Livre 1', 'Livre 2', 'Livre 3'];
 * $DepositosCampos = ['depo_empresa', 'depo_centro', 'depo_cidade', 'depo_status', 'depo_livre1', 'depo_livre2', 'depo_livre3', ];
 * echo MontarTabela($CamposTabela, $Depositos, $DepositosCampos);
 * 
 * @param type $CamposTabela
 * @param type $Objeto
 * @param type $ObjetoCampos
 * @return string
 */
function MontarTabela($CamposTabela, $Objeto, $ObjetoCampos) {

    $html = " 
        <table class='table table-striped table-hover table-bordered'>
            <thead>
                <tr>
            ";

    foreach ($CamposTabela as $thNome) {
        $html .= "
                    <th> $thNome </th>
                ";
    }

    $html .= "
        </tr>
            </thead>
            
            <tbody>
            ";


    foreach ($Objeto as $Obj) {

        $html .= "
                <tr>
                ";
        foreach ($ObjetoCampos as $campos) {

            $valor = (string) $Obj->{$campos};

            $html .= "
                
                    <td> $valor </td>
                
                ";
        }
        $html .= "
                </tr>
                ";
    }

    $html .= "
            </tbody>
        </table>
        ";

    return $html;
}

function GerarInsert($Campos, $Tabela) {

    $sql = "INSERT INTO " . $Tabela . " ( ";

    foreach ($Campos as $campo) {
        $sql .= " " . trim($campo) . ", ";
    }

    $sql = substr($sql, 0, -2);

    $sql .= ") VALUES (''";
    
    return $sql;
}

function CombinarValores($Valores) {
    foreach ($Valores as $valor) {
        $sql .= ",'" . trim($valor) . "'";
    }

    $sql .= ")";

    return $sql;
}

function ImportarCSV($Campos, $Tabela, $ArquivoNome) {
    global $db;
    
    $insert = GerarInsert($Campos, $Tabela);

    $handle = fopen($ArquivoNome, "r");
    if ($handle !== FALSE) {
        $data = fgetcsv($handle, 1000, ",");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            
            $values = CombinarValores($data);
            $sql = $insert . $values;
//            echo $sql;
//            die();
            $db->ExecSQL($sql);
        }
    } else {
        return false;
    }

    fclose($handle);

    unlink($ArquivoNome);

    return true;
}
