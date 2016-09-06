<?php

function get_head($Titulo, $FormGrid = null, $path = null)
{
    if (!isset($path))
        $path = 'head.php';

    include($_SERVER['DOCUMENT_ROOT'] . '/admin/' . $path);
}

function get_foot($tipo = null)
{
    include($_SERVER['DOCUMENT_ROOT'] . '/admin/foot.php');
}

function _debug($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function _GetVarsByCSV($Var)
{
    $Value = "";
    foreach (($Var ? $Var : Array()) as $s) {
        $Value .= "'" . $s . "',";
    }
    return substr($Value, 0, strlen($Value) - 1);
}

// Exibe mensagens definidas pela sessão
function mensagem()
{

    if (isset($_SESSION['Mensagem']['tipo'])) {
        switch ($_SESSION['Mensagem']['tipo']) {

            case "error": {
                echo '<div class="alert alert-danger">' . $_SESSION['Mensagem']['texto'] . ' </div>';

                break;
            }

            case "sucesso": {
                echo '<div class="alert alert-success">' . $_SESSION['Mensagem']['texto'] . '</div>';

                break;
            }
        }
        unset($_SESSION['Mensagem']);
    }
}

function EstaLogado()
{
    if (isset($_SESSION['usua_id']) && $_SESSION['usua_id'] != null) {
        return true;
    } else {
        return false;
    }
}

/*
 * Verificar se é alguma das páginas que são liberadas o acesso sem o login
 */
function PaginasLivres()
{
    $paginas = array("mleitura", "acoes", "listagem", "etiquetas\/index");

    foreach ($paginas as $files) {
        if (preg_match('/' . $files . '/i', $_SERVER['SCRIPT_FILENAME'])) {
            return true;
        }
    }

    return false;
}

function rrmdir($dir)
{
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
}

function DeletarArquivos($diretorio)
{
    $tempo = 3600; // 1 hora
    $current_time = time();

    foreach (glob($diretorio) as $arquivo) {
        $tempo_arquivo = filemtime($arquivo);
        $diferenca = $current_time - $tempo_arquivo;

        if ($diferenca >= $tempo) {
            if (is_dir($arquivo))
                rrmdir($arquivo);
            else
                unlink($arquivo);
        }
    }
}

function GetQuery($link)
{
    if ($_GET['busca']) {
        $link = $link . '&busca=' . $_GET['busca'];
    }

    return $link;
}
