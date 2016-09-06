<?php

require_once 'Useful.class.php';
require_once 'DBGeleia.class.php';
require_once 'DB.class.php';

// on production
error_reporting(1);

$dbGeleia = new DBGeleia();
$db = new DB();

date_default_timezone_set("America/Sao_Paulo");

setlocale(LC_ALL, "pt_BR");

/* CONSTANT */
define("_PAGE_TITLE", 'Vivo Inventário');

class Geleia extends Form
{

    public $error;
    public $mail_config;

    public function Geleia($Table = "")
    {

        if ($Table != "") {
            parent::Form($Table);
        }

        //this is valid for all sub-classes
        $this->DynamicVars['$1'] = $this->GetUserIdLogged();
        $this->DynamicVars['$2'] = "'" . date('Y-m-d H:i:s') . "'";
    }

    function GetUserIdLogged()
    {
        //return 1; //testing
        return $_SESSION['usua_id'];
    }

    function GetUserNameLogged()
    {
        return $_SESSION['usua_nome'];
    }

    function GetUserEmailLogged()
    {
        return $_SESSION['usua_email'];
    }

    function isLogged()
    {
        if ($this->GetUserIdLogged() != "") {
            return true;
        }
        return false;
    }

    function forceAuthentication($Url = "")
    {
        if (!$this->isLogged()) {

            if ($Url != "") {
                Useful::JsRedirect($Url);
            } else {
                Useful::JsRedirect("/admin/index.php?redirect=" . rawurlencode($_SERVER[REQUEST_URI]));
            }
        }
    }

    function GetEmailConfig($from_name = "Aminezia")
    {

        try {

            $config = array(
                'ssl' => 'tls',
                'port' => 587,
                'auth' => 'login',
                'username' => 'rotiv.jr@gmail.com',
                'password' => 'cativeiro666##$'
            );
            //suasvendasmail.com.br
            $mailTransport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
            Zend_Mail::setDefaultTransport($mailTransport);
        } catch (Zend_Exception $e) {
            // Here you can log an Zend_Mail exceptions</strong>
        }

        $this->mail_config = new Zend_Mail();

        $from = "sv@suasvendasmail.com.br";
        $this->mail_config->setFrom($from, $from_name);
    }

}

?>