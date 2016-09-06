<?php

class DBGeleia
{

    public $id, $user, $password, $db, $host, $msg, $sql;
    public $id_slave, $db_slave;

    function __construct()
    {

        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->db = 'dioji12';
        $this->Connect();
    }

    /**
     * Connects to database server
     * @return void
     */
    function Connect()
    {

        if ($this->id = mysql_pconnect($this->host, $this->user, $this->password)) {
            mysql_select_db($this->db, $this->id);

            mysql_set_charset('utf8', $this->id);

//        if ($this->id = new mysqli($this->host, $this->user, $this->password, $this->db)) {

//            if (!$this->id->set_charset("utf8")) {
//                $this->msg = "Erro ao setar a configuração UTF8, {$this->id->error}";
//                exit();
//            }

        } else {
            $this->msg = mysql_error();
            error_log($this->msg);
        }
    }

    function ExecSQL($sql)
    {
        /* if($rset = mysql_query($sql, $this->id)) {
          return $rset;
          } else {
          //Store message error for debug
          $this->msg = "<b>SQL:</b> " .$this->sql . " <br><br><b>" . mysql_error() . "</b>" ;
          error_log($this->msg);

          return false;
          } */
        $rset = mysql_query($sql);
//            $rset = mysqli_query($this->id, $sql);
        if (!$rset) {
            $this->msg = "<b>SQL:</b> " . $this->sql . " <br><br><b>" . mysql_error() . "</b>";
            error_log(date("d-m-Y H:i:s") . " - [SQL - ERRO] - " . $sql . " - " . $db->error . "\r\n", 3, $doc_root . "/_erro_sql.log");
            return false;
        }

        return $rset;
    }

    /**
     * Disconnect from database server
     *
     * @return boolean
     */
    function Disconnect()
    {
        return mysql_close();
    }

    function GetObject($rset)
    {
        if (is_resource($rset)) {
            if ($rset) {
                return @mysql_fetch_object($rset);
            } else {
                $this->msg = mysql_error();
                return false;
            }
        } else {

            $rset = $this->ExecSQL($rset);
            return $this->GetObject($rset);
        }
    }

    function GetArray($rset)
    {
        if ($rset) {
            return @mysql_fetch_assoc($rset);
        } else {
            $this->msg = mysql_error();
            return false;
        }
    }

    function GetObjectList($var)
    {
        $obj = array();

        //die($var);

        if (is_string($var)) {
            $rset = $this->ExecSQL($var);

            if ($this->AffectedLines($rset) > 0) {
                return $this->GetObjectList($rset);
            } else {
                return array();
            }
        } else if (is_resource($var)) {
            while ($line = $this->GetObject($var)) {
                $obj[] = $line;
            }
            return $obj;
        }
    }

    function QtyLines($rset)
    {
        return @mysql_numrows($rset);
    }

    function AffectedLines()
    {
        return mysql_affected_rows();
    }

    function GetLastId()
    {
        return mysql_insert_id();
    }

    /**
     * Begin a transaction
     * @return boolean
     */
    function Begin()
    {
        return $this->ExecSQL("BEGIN");
    }

    /**
     * Commit a transaction
     *
     * @return boolean
     */
    function Commit()
    {
        return $this->ExecSQL("COMMIT");
    }

    /**
     * Rollback a transaction
     *
     * @return boolean
     */
    function Rollback()
    {
        return $this->ExecSQL("ROLLBACK");
    }

}

?>