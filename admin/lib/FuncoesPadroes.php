<?php

//require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/Global.php';

class FuncoesPadroes extends Geleia
{

    public function Save($modulo)
    {

        switch ($modulo) {

            case 'usuario':
                $_POST['senha'] = sha1(trim($_POST['senha']));

                break;
        }
        
        return parent::Save($modulo);
    }

    public function Update($modulo)
    {
        switch ($modulo) {
            case 'usuario': {
                global $Usuario;

                $_POST['senha'] = sha1(trim($_POST['senha_nova']));

                /*$Senha_antiga = sha1(trim($_POST['senha_antiga']));
                $Id = $_POST['id'];

                if ($Usuario->ConfirmarSenha($Id, $Senha_antiga)) {
                    $_POST['senha'] = sha1(trim($_POST['senha_nova']));
                } else {
                    return 'senha_diferente';
                }*/

                break;
            }

        }

        return parent::Update($modulo);
    }

    function Delete($Id, $Modulo)
    {
        global $db;

        switch ($Modulo) {

            case 'usuario':
                global $Usuario;

                return $Usuario->DeletarPorId($Id);

                break;
        }

//        $this->SQL_Delete = "DELETE FROM " . $Modulo . " WHERE " . substr($Modulo, 0, 4) . "_id = " . (int) $Id;

//        return parent::Delete();
    }

}
