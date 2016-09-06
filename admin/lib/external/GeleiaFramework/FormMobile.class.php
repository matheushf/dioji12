<?php

class FormMobile extends Form {

	function CheckboxUsingLiteralValues($Field, $Options) {

		$DataSource = $this->LiteralList[$Options->{'datasource-literal'}];

		$ArrayValues = explode("#", $DataSource);
		//asort($ArrayValues);

		$Selected = ($_POST[$Field] ? $_POST[$Field] : Array());
		foreach ( ($ArrayValues ? $ArrayValues : Array()) as $Value) {

			if(in_array($Value, $Selected) && $_POST) {
				$Checkbox .= "<label><input checked type=\"checkbox\" value=\"$Value\" name=\"". $Field . "[]\" id=\"$Field\"> $Value</label>";
			} else {
				$Checkbox .= "<label><input type=\"checkbox\" value=\"$Value\" name=\"". $Field . "[]\" id=\"$Field\"> $Value</label>";
			}
		}

		return $Checkbox;
	}

	function RadioboxUsingLiteralValues($Field, $Options) {

		$DataSource = $this->LiteralList[$Options->{'datasource-literal'}];

		$ArrayValues = explode("#", $DataSource);
		//asort($ArrayValues);

		$Selected = ($_POST[$Field] ? $_POST[$Field] : Array());
		foreach ( ($ArrayValues ? $ArrayValues : Array()) as $Value) {

			if(in_array($Value, $Selected) && $_POST) {
				$Checkbox .= "<div class='radio'><label><input checked type=\"radio\" value=\"$Value\" name=\"". $Field . "[]\" id=\"$Field\"> $Value</label></div>";
			} else {
				$Checkbox .= "<div class='radio'><label><input type=\"radio\" value=\"$Value\" name=\"". $Field . "[]\" id=\"$Field\"> $Value</label></div>";
			}
		}

		return $Checkbox;
	}

	function SelectUsingLiteralValues($Field, $Options, $FirstOptionText) {

		$DataSource = $this->LiteralList[$Options->{'datasource-literal'}];

		$ArrayValues = explode("#", $DataSource);

		//asort($ArrayValues);

		$Select = "<select ".$Options->{'required'}." id='$Field' name='$Field'> ";

		$Select .= "<option value=''>$FirstOptionText</option>";

		foreach ( ($ArrayValues ? $ArrayValues : Array()) as $Value) {

			if($_POST[$Field] == trim($Value) ) {
				$Select .= "<option selected value=\"".trim($Value)."\">" . htmlentities($Value) . "</option>";
			} else {
				$Select .= "<option value=\"".trim($Value)."\">" . htmlentities($Value) . "</option>";
			}
		}
		$Select .= "</select>";
		return $Select;
	}

	function CreateDateTimeField($Field, $Options, $Label) {
		$Selected = ($_POST[$Field] ? $_POST[$Field] : "");
		$SelectedHour = ($_POST[$Field . "_hour"] ? $_POST[$Field . "_hour"] : Array());
		$SelectedMinute = ($_POST[$Field . "_minute"] ? $_POST[$Field . "_minute"] : Array());

		for($i = 0; $i<=23; $i++) {
			$Hours[] = Useful::padLeft($i, 0,2);
		}

		for($i = 0; $i<=55; $i+=30) {
			$Minutes[] = Useful::padLeft($i, 0,2);
		}

		$data = explode("/", $Selected);
		$novaData = $data[2] . "-" . $data[1] . "-" . $data[0];
		$Selected = $novaData;
		$TextFieldDate = "<label for='$Field'><strong>$Label</strong></label><input ".$Options->{'required'}." name=\"".$Field."\" type=\"date\" id=\"".$Field."\" value=\"".$Selected."\" size=\"10\" maxlength=\"10\" class='form-control'>";
		$CbbHours = Useful::CreateComboBoxArray($Hours, $Field . "_hour", $SelectedHour);
		$CbbMinutes = Useful::CreateComboBoxArray($Minutes, $Field . "_minute", $SelectedMinute);

		$Html = $TextFieldDate . $CbbHours . $CbbMinutes;

		return $Html;

	}

	function SelectUsingDB($Field, $Options, $FirstOptionText) {
		global $dbGeleia;

		$ObjList = $dbGeleia->GetObjectList($this->SQList[$Options->{'datasource-sql'}]['sql']);

		$Select = "<select ".$Options->{'required'}." id='$Field' name='$Field' class='form-control'> ";
		$Select .= "<option value=''>$FirstOptionText</option>";

		//echo $_POST[$Field];
		//_debug($Options);

			foreach (($ObjList ? $ObjList : Array()) as $Obj ) {
			if($_POST[$Field] == $Obj->{$this->SQList[$Options->{'datasource-sql'}]['key']} ) {
				$SelectOption .= "<option selected value=\"". htmlentities($Obj->{$this->SQList[$Options->{'datasource-sql'}]['key']})."\">".$Obj->{$this->SQList[$Options->{'datasource-sql'}]['value']}."</option>";
			} else {
				$SelectOption .= "<option value=\"".htmlentities($Obj->{$this->SQList[$Options->{'datasource-sql'}]['key']})."\">".$Obj->{$this->SQList[$Options->{'datasource-sql'}]['value']}."</option>";
			}
		}

			$Select .= $SelectOption . "</select>";
			return $Select;
	}

	function SelectUsingLiteralKeysAndValues($Field, $Options, $FirstOptionText) {

		$ArrayValues = $this->LiteralList[$Options->{'datasource-literal'}];

		$Select = "<select ".$Options->{'required'}." id='$Field' name='$Field' class='form-control'> ";

		$Select .= "<option value=''>$FirstOptionText</option>";

		foreach ( ($ArrayValues ? $ArrayValues : Array()) as $Key=>$Value) {

			if($_POST[$Field] == $Key ) {
				$Select .= "<option selected value=\"".trim($Key)."\">" . htmlentities($Value) . "</option>";
			} else {
				$Select .= "<option value=\"".trim($Key)."\">" . htmlentities($Value) . "</option>";
			}
		}
		$Select .= "</select>";
		return $Select;
	}





function Create($Field, $Label = "", $ReadOnly = false) {

	//criar elementos padrao bootstrap

	$FieldInfo = $this->GetColumnInfoFromTableList($Field);


	//_debug($FieldInfo);
	//_debug($_POST);

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
			case "text": case "password": {
				return "<label for='$Field'><strong>$Label</strong> </label> <input " . $readonly . $FieldPreferences->{'typeof'} . $FieldPreferences->{'required'} . $FieldPreferences->{'style'} . " type='$InputType' $int id='$Field'  name='$Field' value='$Value' $maxlength is_nullable='$FieldInfo->IS_NULLABLE' class='form-control' data-clear-btn='true'/>";
				break;
			}

			case "hidden": {
				return "<input type='hidden'  id='$Field' name='$Field' value='$Value' is_nullable='$FieldInfo->IS_NULLABLE' />";
				break;
			}

			case "select": {
				if ($FieldPreferences->{'datasource-type'} == 'literal') {
					return "<label for='$Field'><strong>$Label</strong> </label>" . $this->SelectUsingLiteralValues($Field, $FieldPreferences, "Selecione...");
				} else if ($FieldPreferences->{'datasource-type'} == 'sql') {
					return "<label for='$Field'><strong>$Label</strong> </label>" . $this->SelectUsingDB($Field, $FieldPreferences, "Selecione...");
				} else if ($FieldPreferences->{'datasource-type'} == 'keyvalue') { //Array With Key=>Value
					return "<label for='$Field'><strong>$Label</strong> </label>" . $this->SelectUsingLiteralKeysAndValues($Field, $FieldPreferences, "Selecione...");
				}
				break;
			}

			case "textarea": {
				return "<label class='Label' for='$Field'><strong>$Label</strong> </label> <textarea " . $FieldPreferences->{'required'} . $readonly . $FieldPreferences->{'typeof'} . " name='$Field' id='$Field'>" . $Value . "</textarea>";
				break;
			}

			case "file": {
				/*                         * @todo MAX SIZE and ALLOWED EXTENSIONS * */
				return "<label class='Label' for='$Field'><strong>$Label</strong> </label> <input " . $FieldPreferences->{'required'} . $readonly . $FieldPreferences->{'typeof'} . " type=\"file\" name=\"" . $Field . "\" id=\"" . $Field . "\">";
				break;
			}

			case "checkbox": {
				if ($FieldPreferences->{'datasource-type'} == 'literal') {
					return "<label class='Label' for='$Field'> </label> <strong>$Label</strong> " . $this->CheckboxUsingLiteralvalues($Field, $FieldPreferences);
					//return "<label>$Label " . $this->RadioboxUsingLiteralValues($Field, $FieldPreferences->{'datasource-literal'}) . "</label>";
				}

				break;
			}

			case "radio": {
				if ($FieldPreferences->{'datasource-type'} == 'literal') {
					return "<label class='Label' for='$Field'><strong>$Label</strong> </label>" . $this->RadioboxUsingLiteralValues($Field, $FieldPreferences);
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
}





























/*
function CreateBootstrap($Field, $Label = "", $ReadOnly = false) {

	//criar elementos padrao boostramp

	$FieldInfo = $this->GetColumnInfoFromTableList($Field);


	//_debug($FieldInfo);
	//_debug($_POST);

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
			case "text": case "password": {
				return "<label for='$Field'><strong>$Label</strong> </label> <input " . $readonly . $FieldPreferences->{'typeof'} . $FieldPreferences->{'required'} . $FieldPreferences->{'style'} . " type='$InputType' $int id='$Field'  name='$Field' value='$Value' $maxlength is_nullable='$FieldInfo->IS_NULLABLE'/ data-clear-btn='true'>";
				break;
			}

			case "hidden": {
				return "<input type='hidden' class='form-control' id='$Field' name='$Field' value='$Value' is_nullable='$FieldInfo->IS_NULLABLE' />";
				break;
			}

			case "select": {
				if ($FieldPreferences->{'datasource-type'} == 'literal') {
					return "<label for='$Field'><strong>$Label</strong> </label>" . $this->SelectUsingLiteralValues($Field, $FieldPreferences, "Selecione...") . "</div>";
				} else if ($FieldPreferences->{'datasource-type'} == 'sql') {
					return "<div class='form-group'><label for='$Field'><strong>$Label</strong> </label>" . $this->SelectUsingDB($Field, $FieldPreferences, "Selecione...") . "</div>";
				} else if ($FieldPreferences->{'datasource-type'} == 'keyvalue') { //Array With Key=>Value
					return "<div class='form-group'><label for='$Field'><strong>$Label</strong> </label>" . $this->SelectUsingLiteralKeysAndValues($Field, $FieldPreferences, "Selecione...") . "</div>";
				}
				break;
			}

			case "textarea": {
				return "<label class='Label' for='$Field'><strong>$Label</strong> </label> <textarea " . $FieldPreferences->{'required'} . $readonly . $FieldPreferences->{'typeof'} . " name='$Field' id='$Field' class='form-control'>" . $Value . "</textarea>";
				break;
			}

			case "file": {
				//*                         * @todo MAX SIZE and ALLOWED EXTENSIONS * *
				return "<label class='Label' for='$Field'><strong>$Label</strong> </label> <input " . $FieldPreferences->{'required'} . $readonly . $FieldPreferences->{'typeof'} . " type=\"file\" name=\"" . $Field . "\" id=\"" . $Field . "\" class='form-control'>";
				break;
			}

			case "checkbox": {
				if ($FieldPreferences->{'datasource-type'} == 'literal') {
					return "<label class='Label' for='$Field'> </label> <strong>$Label</strong> " . $this->CheckboxUsingLiteralvalues($Field, $FieldPreferences);
					//return "<label>$Label " . $this->RadioboxUsingLiteralValues($Field, $FieldPreferences->{'datasource-literal'}) . "</label>";
				}

				break;
			}

			case "radio": {
				if ($FieldPreferences->{'datasource-type'} == 'literal') {
					return "<label class='Label' for='$Field'><strong>$Label</strong> </label>" . $this->RadioboxUsingLiteralValues($Field, $FieldPreferences);
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
*/