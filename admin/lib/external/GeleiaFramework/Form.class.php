<?php

/**
 * This a magic class which is responsable for create new html controls dinamically
 * @author Vitor "El Junior"
 *
 *
 * Some examples to add to COMMENT FIELD in the table fields:
 * {"user-control":"select","datasource-type":"sql", "datasource-sql":"select.supervisor"} - HTML SELECT USING AS DATASOURCE ONE SQL QUERY
 * {"user-control":"text"} - DISPLAY AN INPUT TEXT
 * {"user-control":"hidden"} - DISPLAY A HIDDEN FIELD
 * {"user-control":"radio","datasource-type":"literal", "datasource-literal":"Comercial#Juridico#Suporte"} - DISPLAY RADIOBOXES USING LITERAL DATASOURCE
 * {"user-control":"select", "datasource-type":"literal", "datasource-literal":"GO#DF#SP"} - DISPLAY SELECT USING LITERAL DATASOURCE RATHER THAN SQL QUERY
 * {"removed":"yes"} - INDICATES A FIELD USED FOR LOGICAL DELETION
 * {"user-control":"password"} - DISPLAY AN PASSWORD FIELD
 */
abstract class PForm extends UserControl
{

    protected $TableList = Array();
    protected $Table = null;
    protected $SQList = Array();
    protected $LiteralList = Array();
    protected $SQL_GetById = null;
    protected $SQL_Delete = null;
    protected $DynamicVars = Array();
    protected $RemovedFieldName = 'deleted';

    public function getRemovedFieldName()
    {
        return $this->RemovedFieldName;
    }

    public function setRemovedFieldName($RemovedFieldName)
    {
        $this->RemovedFieldName = $RemovedFieldName;
    }

    function GetById($ReturnArray = false)
    {
        global $dbGeleia;

        if ($this > SQL_GetById != null) {
            if ($rset = $dbGeleia->ExecSQL($this->SQL_GetById)) {
                //echo $this->SQL_GetById;
                if ($ReturnArray) {
                    return $dbGeleia->GetArray($rset);
                }
                return $dbGeleia->GetObject($rset);
            }
        } else {
            error_log(__CLASS__ . "." . __METHOD__ . " SQL_GetById does not exist.");
            return false;
        }
    }

    function Delete()
    {
        global $dbGeleia;

        if ($this->SQL_Delete != null) {
            if ($rset = $dbGeleia->ExecSQL($this->SQL_Delete)) {

                return true;
            }
        } else {
            error_log(__CLASS__ . "." . __METHOD__ . " SQL_Delete does not exist.");
            return false;
        }
    }

    function PopulateFormFromDB($Array)
    {
        $Keys = @array_keys($Array);
        $Temp = explode("_", $Keys[0]);
        $Prefix = $Temp[0];

        /*
         * @todo do not allow to have prefix_id repeated (solution: use always prefix_foreign_id)
         */

        foreach (($Keys ? $Keys : Array()) as $Obj) {
            $ObjColumn = $this->GetInfoAboutColumn($this->Table, $Obj); //check if this field is a checkbox
            $FieldPreferences = json_decode($ObjColumn->COLUMN_COMMENT);


            if ($ObjColumn->DATA_TYPE == 'decimal') {
                $Array[$Obj] = number_format($Array[$Obj], 2, ',', '.');
            }

            $campo = strtolower(substr($Obj, strlen($Prefix) + 1, strlen($Obj)));
            if ($FieldPreferences->{'user-control'} == 'radio' || $FieldPreferences->{'user-control'} == 'checkbox') {
                $_POST[$campo][] = $Array[$Obj];
            } else if ($FieldPreferences->{'user-control'} == 'datetime') {
                $Timestamp = strtotime($Array[$Obj]);
                $_POST[$campo] = date("d/m/Y", $Timestamp);
// 					echo $Timestamp;
// 					_debug($_POST[$campo]);

                $_POST[$campo . "_hour"] = date("H", $Timestamp);
                $_POST[$campo . "_minute"] = date("i", $Timestamp);
            } else {
                $_POST[$campo] = $Array[$Obj];
            }
        }
// 			die();
    }

    function GetInfoAboutColumn($Table, $Column)
    {
        global $dbGeleia;

        $sql = "SELECT * FROM information_schema.`COLUMNS` WHERE TABLE_NAME='" . $Table . "' AND COLUMN_NAME='" . $Column . "'";
        //	die($sql);
        if ($rset = $dbGeleia->ExecSQL($sql)) {
            return $dbGeleia->GetObject($rset);
        }

        return false;
    }

    function GetInfoAboutTable($Table)
    {
        global $dbGeleia;

        $sql = "SELECT * FROM information_schema.`COLUMNS` WHERE TABLE_NAME='" . ($Table) . "' AND TABLE_SCHEMA='" . $dbGeleia->db . "' ORDER BY ORDINAL_POSITION ASC";
        //die($sql);
        if ($rset = $dbGeleia->ExecSQL($sql)) {
            return $dbGeleia->GetObjectList($rset);
        }

        return false;
    }

}

class Form extends PForm
{

    /*function Save($modulo = null)
    {
        global $dbGeleia;

        $Sql = $this->GenerateInsertSQL($modulo);
        if ($dbGeleia->ExecSQL($Sql)) {
            $this->setId($dbGeleia->GetLastId());

            return true;
        }
        return false;
    }*/

    function Save($modulo = null)
    {
        global $db;

        $Sql = $this->GenerateInsertSQL($modulo);

        unset($_POST['id']);
        
        if ($db->ExecSQL($Sql, $_POST)) {
//            $this->setId($db->GetLastId());

            return true;
        }

        return false;
    }

    function Update($modulo = null)
    {
        global $dbGeleia;

        $Sql = $this->GenerateUpdateSQL($modulo);
//echo $Sql;
//die();
        if ($dbGeleia->ExecSQL($Sql)) {
            $this->setId($dbGeleia->GetLastId());
            return true;
        }
        return false;
    }

    function GenerateUpdateSQL($modulo = null)
    {
        if ($modulo == null) {
            $ObjList = $this->GetInfoAboutTable($this->Table);
        } else {
            $ObjList = $this->GetInfoAboutTable($modulo);
        }

        $Sql = "UPDATE " . ($ObjList[0]->TABLE_NAME) . " SET ";

        foreach (($ObjList ? $ObjList : Array()) as $ObjTable) {

            $FieldPreferences = json_decode($ObjTable->COLUMN_COMMENT);


            $temp = explode("_", $ObjTable->COLUMN_NAME);

            if (sizeof($temp) >= 2) {
                $FieldName = strtolower(substr($ObjTable->COLUMN_NAME, strlen($temp[0]) + 1, strlen($ObjTable->COLUMN_NAME)));
            } else {
                $FieldName = strtolower($ObjTable->COLUMN_NAME);
            }

            //Handling decimal numbers - replacing . and ,
            if ($ObjTable->DATA_TYPE == 'decimal') {
                $_POST[$FieldName] = str_replace('.', '', $_POST[$FieldName]);
                $_POST[$FieldName] = str_replace(',', '.', $_POST[$FieldName]);
            }

            if ($FieldPreferences->{'user-control'} == 'file') {
                //uploading a single file
                $File = $_FILES[$FieldName];

                //delete previous file
                if ($filename = $this->UploadSingleFile($File, $FieldPreferences)) {
                    $SqlTemp .= $ObjTable->COLUMN_NAME . " = '" . mysql_escape_string($filename) . "',";
                } else {
                    //$SqlTemp .= $ObjTable->COLUMN_NAME . " = NULL,"; /** CAN OCCUR SOME PROBLEM WHEN ANOTHER FIELD COMES AFTERWARDS **/
                }
            } else if ($_POST[$FieldName] == "" && $ObjTable->IS_NULLABLE == 'YES' && $FieldPreferences->{'default-value-php'} == "" && $FieldPreferences->{'no-update'} != "yes") {
                $SqlTemp .= " " . $ObjTable->COLUMN_NAME . "=NULL,";
            } else if ($ObjTable->COLUMN_KEY == 'PRI') {
                $PrimaryKey = $ObjTable->COLUMN_NAME . "= '" . mysql_escape_string($_POST[$FieldName]) . "' ";
            } else {
                if ($FieldName == $this->RemovedFieldName) {
                    $ExtraClausule = " " . $ObjTable->COLUMN_NAME . "=0 ";
                } else {

                    if ($FieldPreferences->{'user-control'} == 'radio') {
                        $SqlTemp .= " " . $ObjTable->COLUMN_NAME . "='" . mysql_escape_string($_POST[$FieldName][0]) . "',";
                    } else if ($FieldPreferences->{'default-value-php'} != "" && $FieldPreferences->{'no-update'} != "yes") {
                        $SqlTemp .= " " . $ObjTable->COLUMN_NAME . "=" . $this->DynamicVars[$FieldPreferences->{'default-value-php'}] . ",";
                    } else {
                        if ($FieldPreferences->{'no-update'} == "yes") { //UPDATE ONLY IF DOES NOT HAVE no-update parameter
                            //DO NOT DO ANYTHINGdie
                        } else if ($FieldPreferences->{'user-control'} == 'datetime') {

                            $Date = useful::DateFormatBD($_POST[$FieldName]); //0000-00-00
                            $Hour = $_POST[$FieldName . "_hour"];
                            $Minute = $_POST[$FieldName . "_minute"];

                            $SqlTemp .= " " . $ObjTable->COLUMN_NAME . "='" . mysql_escape_string($Date . " " . $Hour . ":" . $Minute . ":00") . "',";
                        } else {
                            $SqlTemp .= " " . $ObjTable->COLUMN_NAME . "='" . mysql_escape_string($_POST[$FieldName]) . "',";
                        }
                    }
                }
            }
        }

        $SqlTemp = substr($SqlTemp, 0, strlen($SqlTemp) - 1) . " WHERE " . $PrimaryKey . ($ExtraClausule != '' ? " AND " . $ExtraClausule : "");
        $Sql .= $SqlTemp;

        return $Sql;
    }

    function GenerateInsertSQL($modulo)
    {
        if ($modulo == null) {
            $ObjList = $this->GetInfoAboutTable($this->Table);
        } else {
            $ObjList = $this->GetInfoAboutTable($modulo);
        }

        /*_debug($_POST);
        _debug($ObjList);
        die('w');*/

        $Sql = "INSERT INTO " . $ObjList[0]->TABLE_NAME . " (";

        foreach (($_POST ? $_POST : array()) as $nome_campo => $valor) {
            $Sql .= substr($modulo, 0, 4) . "_{$nome_campo}, ";
        }
        $Sql = substr($Sql, 0, -2) . ") VALUES ( ";

        foreach (($ObjList ? $ObjList : Array()) as $ObjTable) {
//            $FieldPreferences = json_decode($ObjTable->COLUMN_COMMENT);
            $Sql .= " ?, ";
        }

        $Sql = substr($Sql, 0, -2) . ")";

        return $Sql;
    }

    /*function GenerateInsertSQL($modulo)
    {
        global $dbGeleia;

//        $ObjList = $this->GetInfoAboutTable($this->Table);
        if ($modulo == null) {
            $ObjList = $this->GetInfoAboutTable($this->Table);
        } else {
            $ObjList = $this->GetInfoAboutTable($modulo);
        }

        $TotalOfColumns = sizeof($ObjList);

        $Sql = "INSERT INTO " . $ObjList[0]->TABLE_NAME . " VALUES (";

        foreach (($ObjList ? $ObjList : Array()) as $ObjTable) {

            $FieldPreferences = json_decode($ObjTable->COLUMN_COMMENT);

            if ($FieldPreferences->{'default-value-sql'} != "") {
                $SqlTemp .= $FieldPreferences->{'default-value-sql'} . ",";
            } else if ($FieldPreferences->{'default-value-php'} != "") {
                //$SqlTemp .= "'" . $FieldPreferences->{'default-value-php'} . "',";
                $SqlTemp .= $this->DynamicVars[$FieldPreferences->{'default-value-php'}] . ",";
            } else if ($ObjTable->COLUMN_KEY == 'PRI' && $ObjTable->EXTRA == 'auto_increment') { //CHECK STRPOS
                $SqlTemp .= "NULL,";
            } else {
                $temp = explode("_", $ObjTable->COLUMN_NAME);

                if (sizeof($temp) >= 2) {
                    $ObjTable->COLUMN_NAME = strtolower(substr($ObjTable->COLUMN_NAME, strlen($temp[0]) + 1, strlen($ObjTable->COLUMN_NAME)));
                } else {
                    $ObjTable->COLUMN_NAME = strtolower($ObjTable->COLUMN_NAME);
                }

                if ($ObjTable->COLUMN_NAME == $this->RemovedFieldName) {

                    if ($TotalOfColumns == $ObjTable->ORDINAL_POSITION) { //End of the table
                        $SqlTemp .= "0 ";
                    } else {
                        $SqlTemp .= "0, ";
                    }
                } elseif ($FieldPreferences->{'user-control'} == 'file') {
                    //uploading a single file
                    $File = $_FILES[$ObjTable->COLUMN_NAME];
                    if ($filename = $this->UploadSingleFile($File, $FieldPreferences)) {
                        $SqlTemp .= "'" . mysql_escape_string($filename) . "',";
                    } else {
                        $SqlTemp .= "NULL,";
                        //CAN OCCUR SOME PROBLEM WHEN ANOTHER FIELD COMES AFTERWARDS
                    }
                } else if ($_POST[$ObjTable->COLUMN_NAME] == "" && $ObjTable->IS_NULLABLE == 'YES' && $FieldPreferences->{'default-value-php'} == "") {
                    if ($TotalOfColumns == $ObjTable->ORDINAL_POSITION) {
                        $SqlTemp .= "NULL "; //THE LAST FIELD
                    } else {
                        $SqlTemp .= "NULL, ";
                    }
                } else if ($FieldPreferences->{'user-control'} == 'radio') {
                    $SqlTemp .= "'" . mysql_escape_string($_POST[$ObjTable->COLUMN_NAME][0]) . "',";
                } else if ($FieldPreferences->{'user-control'} == 'datetime') {

                    $Date = useful::DateFormatBD($_POST[$ObjTable->COLUMN_NAME]); //0000-00-00
                    $Hour = $_POST[$ObjTable->COLUMN_NAME . "_hour"];
                    $Minute = $_POST[$ObjTable->COLUMN_NAME . "_minute"];

                    $SqlTemp .= "'" . mysql_escape_string($Date . " " . $Hour . ":" . $Minute . ":00") . "',";
                } else if ($FieldPreferences->type == 'CURRENT_TIMESTAMP') {
                    $SqlTemp .= 'CURRENT_TIMESTAMP, ';
                } else {

                    if ($ObjTable->DATA_TYPE == 'decimal') { //formatting decimal numbers
                        $_POST[$ObjTable->COLUMN_NAME] = str_replace('.', '', $_POST[$ObjTable->COLUMN_NAME]);
                        $_POST[$ObjTable->COLUMN_NAME] = str_replace(',', '.', $_POST[$ObjTable->COLUMN_NAME]);
                    }

                    $SqlTemp .= "'" . mysql_escape_string($_POST[$ObjTable->COLUMN_NAME]) . "',";
                }

            }

            //echo $FieldPreferences->{'user-control'} . "<br>";
        }


        $SqlTemp = substr($SqlTemp, 0, strlen($SqlTemp) - 1);
        $Sql .= $SqlTemp . ")";

        return $Sql;
    }*/

    function Form($Table)
    {
        global $cache;

        //$var_table_info = 'geleia_table_info_' . strtolower($Table);
        //if(!$var = $cache->load($var_table_info)) { //not cached
        $this->TableList[$Table] = $this->GetInfoAboutTable($Table);
        //$cache->save($this->TableList[$Table], $var_table_info);
        //} else {
        //$this->TableList[$Table] = $var;
        //}

        $this->Table = $Table;
    }

    function GetColumnInfoFromTableList($Field)
    {
        if ($this->Table == null) {
            die("Table var is not filled.");
            return false;
        }

        $i = 0;
        foreach (($this->TableList[$this->Table] ? $this->TableList[$this->Table] : Array()) as $T) {

            if (strtoupper($T->COLUMN_NAME) == strtoupper($Field)) {

                return $this->TableList[$this->Table][$i];
            }
            $i++;
        }
    }

    function Create($Field, $Label = "", $ReadOnly = false)
    {

        $FieldInfo = $this->GetColumnInfoFromTableList($Field);

        if ($FieldInfo != null) {

            //echo $Field . " - ";

            $temp = explode("_", $Field);

            if (sizeof($temp) >= 2) { //creating the field name automatically
                $Field = strtolower(substr($Field, strlen($temp[0]) + 1, strlen($Field)));
            } else {
                $Field = strtolower($Field);
            }

            //echo $Field . "<br>";
            if ($_POST[$Field]) {
                $Value = $_POST[$Field];
            }

            //Getting info about the Field using JSON format
            $FieldPreferences = json_decode($FieldInfo->COLUMN_COMMENT);

            $CommentInfo = explode("|", $FieldInfo->COLUMN_COMMENT);
            $InputType = $FieldPreferences->{'user-control'};

            if ($FieldPreferences->{'style'} != "") {
                $FieldPreferences->{'style'} = " style='" . $FieldPreferences->{'style'} . "' ";
            }

            if ($FieldPreferences->{'css'} != "") {
                $FieldPreferences->{'css'} = " class='" . $FieldPreferences->{'css'} . "' ";
            }

            if ($FieldPreferences->{'typeof'} != "") { //email, cep, cpf, cnpj, number, currency
                $FieldPreferences->{'typeof'} = " typeof='" . $FieldPreferences->{'typeof'} . "' ";
            }

            if ($FieldPreferences->{'required'} != "") {
                $FieldPreferences->{'required'} = " required=\"yes\" ";
            }

            if ($FieldPreferences->{'maxlength'} != "") {
                $maxlength = " maxlength=\"" . $FieldPreferences->{'maxlength'} . "\" ";
            }

            if ($ReadOnly) {
                $readonly = ' readonly ';
            }

            switch (strtolower($InputType)) {
                case "password": {

//                    $Value = 

                    $html = " <label for='$Field'><strong>$Label</strong> </label>
                                    <input " . $readonly . $FieldPreferences->{'typeof'}
                        . $FieldPreferences->{'required'}
                        . $FieldPreferences->{'style'}
                        . " type='password' $int id='$Field' name='$Field' value='$Value' $maxlength is_nullable='$FieldInfo->IS_NULLABLE'/ class='form-control' style='margin-bottom: 10px'>";

                    return $html;
                    break;
                }


                case "text": {

                    $html = " <label for='$Field'><strong>$Label</strong> </label>
                                        <input " . $readonly . $FieldPreferences->{'typeof'}
                        . $FieldPreferences->{'required'}
                        . $FieldPreferences->{'style'}
                        . " type='$InputType' $int id='$Field' name='$Field' value='$Value' $maxlength is_nullable='$FieldInfo->IS_NULLABLE'/ class='form-control' style='margin-bottom: 10px'>";

                    return $html;
                    break;
                }

                case "hidden": {
                    $html = "<input type='hidden' class='form-control' id='$Field' name='$Field' value='$Value' is_nullable='$FieldInfo->IS_NULLABLE' />";

                    return $html;
                    break;
                }

                case "select": {
                    if ($FieldPreferences->{'datasource-type'} == 'literal') {
                        return "<label for='$Field'><strong>$Label</strong> </label>"
                        . $this->SelectUsingLiteralValues($Field, $FieldPreferences, "Selecione...")
                        . "";
                    } else if ($FieldPreferences->{'datasource-type'} == 'sql') {
                        $html = "<label for='$Field'><strong>$Label</strong> </label>"
                            . $this->SelectUsingDB($Field, $FieldPreferences, "Selecione...")
                            . "";
                        return $html;
                    } else if ($FieldPreferences->{'datasource-type'} == 'keyvalue') { //Array With Key=>Value
                        return "<div class='form-group'><label for='$Field'><strong>$Label</strong> </label>"
                        . $this->SelectUsingLiteralKeysAndValues($Field, $FieldPreferences, "Selecione...")
                        . "";
                    }

                    break;
                }

                case "textarea": {
                    return "<label class='Label' for='$Field'><strong>$Label</strong> </label> "
                    . "<textarea "
                    . $FieldPreferences->{'required'}
                    . $readonly . $FieldPreferences->{'typeof'}
                    . " name='$Field' id='$Field' class='form-control'>"
                    . $Value . "</textarea>";
                    break;
                }

                case "file": {
                    //*                         * @todo Adicionar tamanho máximo e extensões permitidas
                    return "<label class='Label' for='$Field'><strong>$Label</strong> </label> "
                    . "<input " . $FieldPreferences->{'required'}
                    . $readonly . $FieldPreferences->{'typeof'}
                    . " type=\"file\" name=\"" . $Field
                    . "\" id=\"" . $Field
                    . "\" class='form-control'>";
                    break;
                }

                case "checkbox": {
                    if ($FieldPreferences->{'datasource-type'} == 'literal') {
                        return "<label class='Label' for='$Field'> </label> <strong>$Label</strong> "
                        . $this->CheckboxUsingLiteralvalues($Field, $FieldPreferences);
                    }

                    break;
                }

                case "radio": {
                    if ($FieldPreferences->{'datasource-type'} == 'literal') {
                        return "<label class='Label' for='$Field'><strong>$Label</strong> </label>"
                        . $this->RadioboxUsingLiteralValues($Field, $FieldPreferences);
                    }

                    break;
                }

                case "datetime": {
                    return $this->CreateDateTimeField($Field, $FieldPreferences, $Label);
                    break;
                }


                default: {
                    die($FieldInfo->COLUMN_NAME . " does not have any comment. Check it out!");
                    break;
                }
            }
        } else {
            echo "Field does not exist in the database";
            error_log("Field does not exist in the database");
        }
    }

    function SelectUsingLiteralKeysAndValues($Field, $Options, $FirstOptionText)
    {

        $ArrayValues = $this->LiteralList[$Options->{'datasource-literal'}];

        $Select = "<select " . $Options->{'required'} . " id='$Field' name='$Field'> ";

        $Select .= "<option value=''>$FirstOptionText</option>";

        foreach (($ArrayValues ? $ArrayValues : Array()) as $Key => $Value) {

            if ($_POST[$Field] == $Key) {
                $Select .= "<option selected value=\"" . trim($Key) . "\">" . htmlentities($Value) . "</option>";
            } else {
                $Select .= "<option value=\"" . trim($Key) . "\">" . htmlentities($Value) . "</option>";
            }
        }
        $Select .= "</select>";
        return $Select;
    }

    function SelectUsingLiteralValues($Field, $Options, $FirstOptionText)
    {

        $DataSource = $this->LiteralList[$Options->{'datasource-literal'}];
        $ArrayValues = explode("#", $DataSource);
        $Select = "
                <div class='form-group'>
                     <select " . $Options->{'required'} . " id='$Field' name='$Field' class='form-control'> 
                            <option value=''>$FirstOptionText</option>";

        foreach (($ArrayValues ? $ArrayValues : Array()) as $Value) {

            if ($_POST[$Field] == trim($Value)) {
                $Select .= "<option selected value=\"" . trim($Value) . "\">" . htmlentities($Value) . "</option>";
            } else {
                $Select .= "<option value=\"" . trim($Value) . "\">" . htmlentities($Value) . "</option>";
            }
        }
        $Select .= "
                    </select>
                </div>";

        return $Select;
    }

    function SelectUsingDB($Field, $Options, $FirstOptionText)
    {
        global $dbGeleia;

        $ObjList = $dbGeleia->GetObjectList($this->SQList[$Options->{'datasource-sql'}]['sql']);

        $key = $this->SQList[$Options->{'datasource-sql'}]['key'];
        $value = $this->SQList[$Options->{'datasource-sql'}]['value'];

        $Select = "
                <div class='form-group'>
                     <select " . $Options->{'required'} . " id='$Field' name='$Field' class='form-control'> 
                            <option value=''>$FirstOptionText</option>";

        foreach (($ObjList ? $ObjList : Array()) as $Obj) {
            if ($_POST[$Field] == $Obj->{$this->SQList[$Options->{'datasource-sql'}]['key']}) {

                $Select .= "<option selected value=\""
                    . $Obj->{$key}
                    . "\">" . $Obj->{$value}
                    . "</option>";
            } else {
                $Select .= "<option value=\""
                    . $Obj->{$key}
                    . "\">" . $Obj->{$value}
                    . "</option>";
            }
        }

        $Select .= "
                    </select>
                </div>";

        return $Select;
    }

    function CheckboxUsingLiteralValues($Field, $Options)
    {

        $DataSource = $this->LiteralList[$Options->{'datasource-literal'}];

        $ArrayValues = explode("#", $DataSource);

        $Checkbox = "<ul " . $Options->{'required'} . " class='CheckboxForm'> ";

        $Selected = ($_POST[$Field] ? $_POST[$Field] : Array());
        foreach (($ArrayValues ? $ArrayValues : Array()) as $Value) {

            if (in_array($Value, $Selected) && $_POST) {
                $Checkbox .= "<li><label><input checked type=\"checkbox\" value=\"$Value\" name=\"" . $Field . "[]\" id=\"$Field\"> $Value</label></li>";
            } else {
                $Checkbox .= "<li><label><input type=\"checkbox\" value=\"$Value\" name=\"" . $Field . "[]\" id=\"$Field\"> $Value</label></li>";
            }
        }

        $Checkbox .= "</ul>";
        return $Checkbox;
    }

    function RadioboxUsingLiteralValues($Field, $Options)
    {

        $DataSource = $this->LiteralList[$Options->{'datasource-literal'}];

        $ArrayValues = explode("#", $DataSource);
        //asort($ArrayValues);
        $Checkbox = "<ul " . $Options->{'required'} . " class='RadioboxForm'> ";

        $Selected = ($_POST[$Field] ? $_POST[$Field] : Array());
        foreach (($ArrayValues ? $ArrayValues : Array()) as $Value) {

            if (in_array($Value, $Selected) && $_POST) {
                $Checkbox .= "<li><label><input checked type=\"radio\" value=\"$Value\" name=\"" . $Field . "[]\" id=\"$Field\"> $Value</label></li>";
            } else {
                $Checkbox .= "<li><label><input type=\"radio\" value=\"$Value\" name=\"" . $Field . "[]\" id=\"$Field\"> $Value</label></li>";
            }
        }

        $Checkbox .= "</ul>";
        return $Checkbox;
    }

    function CreateDateTimeField($Field, $Options, $Label)
    {

        $Selected = ($_POST[$Field] ? $_POST[$Field] : "");
        $SelectedHour = ($_POST[$Field . "_hour"] ? $_POST[$Field . "_hour"] : Array());
        $SelectedMinute = ($_POST[$Field . "_minute"] ? $_POST[$Field . "_minute"] : Array());

        for ($i = 0; $i <= 23; $i++) {
            $Hours[] = Useful::padLeft($i, 0, 2);
        }

        for ($i = 0; $i <= 55; $i += 30) {
            $Minutes[] = Useful::padLeft($i, 0, 2);
        }

        $TextFieldDate = "<label class='Label'><strong>$Label</strong><input " . $Options->{'required'} . " name=\"" . $Field . "\" type=\"text\" id=\"" . $Field . "\" value=\"" . $Selected . "\" size=\"10\" maxlength=\"10\"></label>";
        $CbbHours = Useful::CreateComboBoxArray($Hours, $Field . "_hour", $SelectedHour);
        $CbbMinutes = Useful::CreateComboBoxArray($Minutes, $Field . "_minute", $SelectedMinute);

        $Html = $TextFieldDate . $CbbHours . $CbbMinutes;

        return $Html;
    }

    function UploadSingleFile($File, $FieldPreferences)
    {

        if ($File['size'] > 0) {
            $t = explode(".", $File['name']);
            $ext = $t[sizeof($t) - 1];

            $filename = str_replace(" ", "_", $t[0]) . "_" . (rand(10, 99)) . "." . $ext;
            $filename = Useful::stripAccents($filename);
            //validar se o ultimo caracter de folder � /, se nao, adicione.
            //VERIFIQUE SEMPRE SE TEM PERMISS�O
            $doc_root = ($_SERVER['SUBDOMAIN_DOCUMENT_ROOT'] != "" ? ($_SERVER['SUBDOMAIN_DOCUMENT_ROOT'] . "/") : $_SERVER['DOCUMENT_ROOT'] . "/");

            //validar se o ultimo caracter de folder � /, se nao, adicione.
            //VERIFIQUE SEMPRE SE TEM PERMISS�O
            if (move_uploaded_file($File['tmp_name'], $doc_root . $FieldPreferences->{'folder'} . $filename)) {
                return $filename;
            } else {

            }
        }

        return false;
    }

    function CodeCreateForm($TableName, $InstanceName)
    {
        $ObjList = $this->GetInfoAboutTable($TableName);

        $strFields = "<?php ";
        foreach (($ObjList ? $ObjList : Array()) as $Obj) {
            if ($Obj->COLUMN_COMMENT != '') {
                $Field = $Obj->COLUMN_NAME;

                if (strpos($Obj->COLUMN_COMMENT, 'removed') == false) {
                    $strFields .= "echo $" . $InstanceName . "->Create('" . strtolower($Field) . "');" . "\r\n";
                }
            }
        }

        return $strFields . " ?>";
    }

    function CodeEditingAction($InstanceName)
    {
        $strEditing = 'if($_GET[\'method\'] == \'edit\' && $_GET[\'id\'] != "") {';
        $strEditing .= '$editing = true;';
        $strEditing .= '$ArrayProperties = $' . $InstanceName . '->GetById($_GET[\'id\'], true);';
        $strEditing .= '$' . $InstanceName . '->PopulateFormFromDB($ArrayProperties); }';
        return $strEditing;
    }

    function CodeCreateClass($ClassName, $TableName, $TableKey, $TableDeleted, $TableOrderBy)
    {
        /**
         * @todo Validar o separador de diretorio \ ou / (linux)
         */
        if (file_exists(__DIR__ . '\ClassTemplate.php')) {
            $content = file_get_contents(__DIR__ . '\ClassTemplate.php');
            echo "<hr>C�digo da classe: <strong>" . $ClassName . ".class.php</strong> <pre>";
            $strCode = str_replace('##CLASS##', $ClassName, $content);
            $strCode = str_replace('##TABLE##', $TableName, $strCode);
            $strCode = str_replace('##TABLE_PK##', $TableKey, $strCode);
            $strCode = str_replace('##DELETED##', $TableDeleted, $strCode);
            $strCode = str_replace('##ORDERBY##', $TableOrderBy, $strCode);
            echo($strCode);
            echo "</pre>";
            echo "<hr>C�digo para global.php<br><br>";

            $strGlobalCode = " require_once '" . $ClassName . ".class.php';<br> $" . strtolower($ClassName) . " = new " . $ClassName . "('" . $TableName . "');";

            echo "<pre>" . $strGlobalCode . "</pre>";
        } else {
            die("Sorry, the template has not been found.");
        }
    }

    function CodePageForm($SuperClass, $PageTitle, $InstanceName, $EditSection, $Form, $SelectedMenu)
    {
        if (file_exists(__DIR__ . '\FormTemplate.php')) {
            $content = file_get_contents(__DIR__ . '\FormTemplate.php');

            $strCode = str_replace('##SUPER##', $SuperClass, $content);
            $strCode = str_replace('##TITLE##', $PageTitle, $strCode);
            $strCode = str_replace('##INSTANCE##', $InstanceName, $strCode);
            $strCode = str_replace('##EDIT##', $EditSection, $strCode);
            $strCode = str_replace('##FORM##', $Form, $strCode);
            $strCode = str_replace('##MENU##', $SelectedMenu, $strCode);

            echo "<pre>";
            echo htmlentities($strCode);
            echo "</pre>";
        }
    }

    function CodePageIndex($SuperClass, $PageTitle, $InstanceName, $SelectedMenu)
    {
        if (file_exists(__DIR__ . '\IndexTemplate.php')) {
            $content = file_get_contents(__DIR__ . '\IndexTemplate.php');

            $strCode = str_replace('##SUPER##', $SuperClass, $content);
            $strCode = str_replace('##TITLE##', $PageTitle, $strCode);
            $strCode = str_replace('##INSTANCE##', $InstanceName, $strCode);
            $strCode = str_replace('##MENU##', $SelectedMenu, $strCode);

            echo "<pre>";
            echo htmlentities($strCode);
            echo "</pre>";
        }
    }

    function CodeCreateActions($InstanceName, $EntityName = '')
    {

        if (file_exists(__DIR__ . '\ActionTemplate.php')) {
            $content = file_get_contents(__DIR__ . '\ActionTemplate.php');

            $strCode = str_replace('##ENTITY##', $EntityName, $content);
            $strCode = str_replace('##INSTANCE##', $InstanceName, $strCode);

            echo "<h2>Acoes</h2><pre>";
            echo htmlentities($strCode);
            echo "</pre>";
        }
    }

}

?>