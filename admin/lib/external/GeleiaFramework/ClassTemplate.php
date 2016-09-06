<&#63;php  
abstract class P##CLASS## extends Geleia {
		
		function P##CLASS##($Table = "") {
			parent::Geleia($Table);
			$this->LoadSQL4Datasource();
			$this->LoadLiteralDatasource();
			$this->DynamicVars['$1'] = $this->GetUserIdLogged();
			$this->DynamicVars['$2'] = "'" . date('Y-m-d H:i:s') . "'";			
		}
		
		function LoadSQL4Datasource() {
			/*$this->SQList['select.product']['sql'] = "SELECT PROD_ID, CONCAT(PROD_NAME, \" - R$ \",  PROD_PRICE) AS PROD_NAME FROM `PRODUCT` WHERE PROD_DELETED=0 ORDER BY PROD_NAME ASC";
			$this->SQList['select.product']['key'] = 'PROD_ID';			
			$this->SQList['select.product']['value'] = 'PROD_NAME';*/
		}
		
		function Delete($Id) {
			$this->SQL_Delete = "UPDATE ##TABLE## SET ##DELETED##=1 WHERE ##TABLE_PK##=" . (int) $Id;
			return parent::Delete();
		}

		function LoadLiteralDatasource() {
			$this->LiteralList['status'] = 'Ativo#Inativo';
		}

		function GetById($Id, $IsArray = false) {
			$this->SQL_GetById = "SELECT * FROM ##TABLE## WHERE ##TABLE_PK##=" . (int) $Id . " AND ##DELETED##=0";			
			return parent::GetById($IsArray);
		}
		
		function GetAll() {
			global $dbGeleia;
			return $dbGeleia->GetObjectList("SELECT * FROM ##TABLE## WHERE ##DELETED##=0 ORDER BY ##ORDERBY##");
		}
		
		function Listing($_field = "##ORDERBY## ASC", $limit = 0, $total_per_page = 50, $search = '') {
			global $dbGeleia;
			
			$sql = "SELECT * FROM ##TABLE## WHERE ##DELETED##=0 ";
			
			if($search != "") {
				$search = str_replace("%", "", $search);
				$search = str_replace("?", "", $search);
				if( strlen($search) > 3) {
					$str_search = " '%$search%' ";
				} else if ( strlen($search) <= 3 ) {
					$str_search = " '$search%' ";
				}

				$sql .= " AND ( (##ORDERBY## LIKE ". $str_search . ") ) ";
			}
			
		
			$sql .= " ORDER BY $_field LIMIT $limit, " . $total_per_page;
			
			if($rset = $dbGeleia->ExecSQL($sql)) {
				return $dbGeleia->GetObjectList($rset);
			} else {
				error_log(__CLASS__."." . __METHOD__);
				return false;
			}			
			
		}
		
		function GetTotal() {
			global $dbGeleia;
			
			$sql = "SELECT COUNT(##TABLE_PK##) FROM ##TABLE## WHERE ##DELETED##=0";
			
			if($rset = $dbGeleia->ExecSQL($sql)) {
				$Obj = $dbGeleia->GetObject($rset);
				return $Obj->TOTAL;
			} else {
				error_log(__CLASS__."." . __METHOD__);
				return false;
			}			
			
		}
		
		
}


class ##CLASS## extends P##CLASS## {
		function Save() {
			//$_POST['status'] = 'Em andamento';
			return parent::Save();
		}
		
		function Update() {
			return parent::Update();
		}
}
&#63>
