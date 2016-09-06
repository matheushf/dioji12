<?php

class DB
{

    public $id, $user, $password, $db, $db_secundario, $host, $msg, $sql;
    private $sql_error_bd = 'INSERT INTO mysql_erros SET  data = ?, script = ?, sql_query = ?, erro = ?';
    public $affected_rows;

    function Connect()
    {
        global $pdo;

        try {
            $pdo = new PDO ('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->user, $this->password, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            ));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            die ($e->getMessage());
        }
    }

    function ExecSQL($sql, $valores = array())
    {
        global $pdo, $log;

        try {

            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            $this->affected_rows = $query->rowCount();
        } catch (Exception $e) {

            //error_log ( date ( "d/m/Y H:i:s" ) . " - [SQL - ERRO] - " . $sql . " - " . $e->getMessage () . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log" );

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage() . ' - values: ' . print_r($valores, 1)));

            $log->addError($e->getMessage() . ' == ' . $sql, $valores);

            return false;
        }

//        return $query;
        return true;
    }

    function getLastInsertId()
    {
        global $pdo;
        return $pdo->lastInsertId();
    }

    function GetObject($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->fetch(PDO::FETCH_OBJ);

        } catch (Exception $e) {

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }

    function GetObjectList($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->fetchAll(PDO::FETCH_OBJ);

        } catch (Exception $e) {
            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            //echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage() );
        }

    }

    function GetAssocList($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }

    function GetJsonList($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($resultado, JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }

    function GetColumn($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->fetchColumn();

        } catch (Exception $e) {
            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }

    }

    function GetCountRows($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->rowCount();

        } catch (Exception $e) {
            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }


}

?>
