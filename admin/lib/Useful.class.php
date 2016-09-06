<?php

	class Useful {

		/**
		 * Format date from 0000-00-00 to 00/00/0000
		 *
		 * @param date $date
		 */
		static function DateFormatDefault($date) {
			if(strlen($date)<10)
				return "";

			$newdate		=		explode ("-", $date);
			return $newdate[2] . "/" . $newdate[1] . "/" . $newdate[0];
		}

		/**
		 * Format date from 00/00/0000 to 0000-00-00
		 *
		 * @param date $date
		 */
		static function DateFormatBD($date) {
			if(strlen($date)<10)
				return "";

			$newdate		=		explode ("/", $date);

			//return $newdate[2] . "-" . $newdate[1] . "-" . $newdate[0];
			return $newdate[0];
		}

		static function JsRedirect( $url ) {
			echo "<script>location.href='$url'</script>";
		}

		static function JsAlert($msg) {
			echo "<script>alert('" . $msg . "');</script>";
		}

		static function JsClose() {
			echo "<script>window.close();opener.window.focus();</script>";
		}

		static function CreateComboBox( $name, $obj_array, $label, $value, $css='' , $js='', $selected_item='', $initial_text='', $initial_value='') {
			if(sizeof($obj_array) == 0)
				return "";

			$html = "\n<select" . $javascript  . " class=\"" . $css . "\" name=\"" . $name ."\" id=\"" . $name ."\" $js $style >\n";

			if($initial_text != "") {
				$html .= "<option value='" . $initial_value . "'>" . $initial_text . "</option>\n";
			} else {
				$html .= "<option></option>\n";
			}


			foreach ($obj_array as $obj ) {

	             if( $selected_item == $obj->$value )
	                    $html    .=    "<option selected value=\"" . $obj->$value . "\">" .($obj->$label) ."</option>\n";
	             else
	                    $html    .=    "<option value=\"" . $obj->$value . "\">" . ($obj->$label) ."</option>\n";

			}
			return $html .=  "</select>";

		}

		static function CreateComboBoxResponsivo( $name, $obj_array, $label, $value, $css='' , $js='', $selected_item='', $initial_text='', $initial_value='') {
			if(sizeof($obj_array) == 0)
				return "";


			$html .= "<div class='form-group'>";
			$html .= "\n<select class=\"form-control\"" . $javascript  . "  name=\"" . $name ."\" id=\"" . $name ."\" $js $style >\n";

			if($initial_text != "") {
				$html .= "<option value='" . $initial_value . "'>" . $initial_text . "</option>\n";
			} else {
				$html .= "<option></option>\n";
			}


			foreach ($obj_array as $obj ) {

				if( $selected_item == $obj->$value )
					$html    .=    "<option selected value=\"" . $obj->$value . "\">" .($obj->$label) ."</option>\n";
				else
					$html    .=    "<option value=\"" . $obj->$value . "\">" . ($obj->$label) ."</option>\n";

			}
			return $html .=  "</select>

					</div>";

		}

		/**
		* Create an combobox using array
		* @return String
		*/
		function CreateComboBoxArray ($_array, $name, $selected_item = NULL, $js=NULL, $css=NULL, $default_text=NULL) {
				if(sizeof($_array) == 0)
					return "";

	        	$combo    =    "<select  " . $js  . " class=\"" . $css . "\" name=\"" . $name ."\" id=\"" . $name ."\">\n";

	        	if($default_text != "") {
	        		$i_temp = 0;
	        		$combo .= "<option value=\"\">" . $default_text . "</option>";
	        	} else {
	        		$i_temp = -1;
	        	}

	            for($i = $i_temp; $i<sizeof($_array); $i++)
	                {
	                    if( ( $selected_item ) == $_array[$i] )
	                        $combo    .=    "<option selected value=\"" . ($_array[$i]) . "\">" . ($_array[$i]) ."</option>\n";
	                    else
	                        $combo    .=    "<option value=\"" . ($_array[$i]) . "\">" . ($_array[$i]) ."</option>\n";
	                }
	            $combo    .=    "</select>";
	            return $combo;
	   }

	   /**
	    * Create an combobox using array
	    * @return String
	    */
	   function CreateComboBoxArrayResponsivo ($_array, $name, $selected_item = NULL, $js=NULL, $css=NULL, $default_text=NULL) {
	   	if(sizeof($_array) == 0)
	   		return "";


	   	$combo .= "<div class='form-group'>";
	   	$combo .= "\n<select class=\"form-control\"" . $js  . " class=\"" . $css . "\" name=\"" . $name ."\" id=\"" . $name ."\">\n";

	   	if($default_text != "") {
	   		$i_temp = 0;
	   		$combo .= "<option value=\"\">" . $default_text . "</option>";
	   	} else {
	   		$i_temp = -1;
	   	}

	   	for($i = $i_temp; $i<sizeof($_array); $i++)
	   	{
	   		if( ( $selected_item ) == $_array[$i] )
	   			$combo    .=    "<option selected value=\"" . ($_array[$i]) . "\">" . ($_array[$i]) ."</option>\n";
	   		else
	   			$combo    .=    "<option value=\"" . ($_array[$i]) . "\">" . ($_array[$i]) ."</option>\n";
	   	}
	   	$combo    .=    "</select>";
	   	$combo .= "
	   			</div>";

	   	return $combo;
	   }

		/**
		* Create an combobox using array
		* @return String
		*/
		function CreateComboBoxArrayByKey ($_array, $name, $selected_item = NULL, $js=NULL, $css=NULL, $default_text=NULL) {
				if(sizeof($_array) == 0)
					return "";



	        	$combo    =    "<select  " . $js  . " class=\"" . $css . "\" name=\"" . $name ."\" id=\"" . $name ."\">\n";

	        	if($default_text != "") {
	        		$i_temp = 0;
	        		$combo .= "<option value=\"\">" . $default_text . "</option>";
	        	} else {
	        		$i_temp = 0;
	        	}

	        	$keys = array_keys($_array);

	            for($i = $i_temp; $i<sizeof($keys); $i++)
	                {
	                    if( ( $selected_item ) == $keys[$i] )
	                        $combo    .=    "<option selected value=\"" . $keys[$i] . "\">" . $_array[$keys[$i]] ."</option>\n";
	                    else
	                        $combo    .=    "<option value=\"" . $keys[$i] . "\">" . $_array[$keys[$i]] ."</option>\n";
	                }
	            $combo    .=    "</select>";
	            return $combo;
	   }


	   /**
	    * Create an combobox using array
	    * @return String
	    */
	   function CreateComboBoxArrayByKeyResponsivo ($_array, $name, $selected_item = NULL, $js=NULL, $css=NULL, $default_text=NULL) {
	   	if(sizeof($_array) == 0)
	   		return "";

		$combo .= "<div class='form-group'>";
		$combo .= "\n<select class=\"form-control\"". $js  . " class=\"" . $css . "\" name=\"" . $name ."\" id=\"" . $name ."\">\n";

	   	if($default_text != "") {
	   		$i_temp = 0;
	   		$combo .= "<option value=\"\">" . $default_text . "</option>";
	   	} else {
	   		$i_temp = 0;
	   	}

	   	$keys = array_keys($_array);

	   	for($i = $i_temp; $i<sizeof($keys); $i++)
	   	{
	   		if( ( $selected_item ) == $keys[$i] )
	   			$combo    .=    "<option selected value=\"" . $keys[$i] . "\">" . $_array[$keys[$i]] ."</option>\n";
	   		else
	   			$combo    .=    "<option value=\"" . $keys[$i] . "\">" . $_array[$keys[$i]] ."</option>\n";
	   	}
	   	$combo    .=    "</select>";
	   	$combo .= "
	   			</div>";

	   	return $combo;
	   }


	   function GetComboMonth($name, $selected = "", $js="", $css="", $text="") {

	   		$month = array("01"=>"Jan", "02"=>"Feb", "03"=>"Mar", "04"=>"Apr", "05"=>"May", "06"=>"Jun",
	   				   "07"=>"Jul", "08"=>"Aug", "09"=>"Sep", "10"=>"Oct", "11"=>"Nov", "12"=>"Dec");

	   		return Utilful::CreateComboBoxArrayByKey($month, $name, $selected, $js, $css, "Month");

	   }


	   function GetComboYear($name, $start, $end = "", $selected = "", $js="", $css="", $text="") {

		   	if($end == "")
		   		$end = date("Y");


	   		for($i = $end ; $i>=$start; $i--) {
	   			$year[$i] = $i;
	   		}

	   		return Utilful::CreateComboBoxArrayByKey($year, $name, $selected, $js, $css, "Year");

	   }



	   function GetComboDay($name, $selected = "", $js="", $css="", $text="") {

	   		for($i = 1 ; $i<=31; $i++) {
	   			$day[strlen($i)==1 ? "0" . $i : $i] = ( strlen($i)==1 ? "0" . $i : $i );
	   		}

	   		return Utilful::CreateComboBoxArrayByKey($day, $name, $selected, $js, $css, "Day");

	   }



		/**
		 * Codec an value
		 *
		 * @param string $_value
		 * @return string
		 */
		function Codec ($_value)
		{

			return base64_encode(serialize($_value));

		}

		function Encode($_value) {
			return Useful::Codec($_value);
		}

		/**
		 * Decode an value...
		 *
		 * @param string $_value
		 * @return string
		 */
		function Decode ($_value)
		{

			return unserialize(base64_decode($_value));
		}

	/*
    * PHP port of Ruby on Rails famous distance_of_time_in_words method.
    *  See http://api.rubyonrails.com/classes/ActionView/Helpers/DateHelper.html for more details.
    *
    * Reports the approximate distance in time between two timestamps. Set include_seconds
    * to true if you want more detailed approximations.
    *
    */
    function distanceOfTimeInWords($from_time, $to_time = 0, $include_seconds = true) {


    	$to_time = strtotime($to_time);
        $from_time = strtotime($from_time);

    	$distance_in_minutes = round(abs($to_time - $from_time) / 60);
        $distance_in_seconds = round(abs($to_time - $from_time));

	        if ($distance_in_minutes >= 0 and $distance_in_minutes <= 1) {
	            if (!$include_seconds) {
	                return ($distance_in_minutes == 0) ? 'less than a min' : '1 min';
	            } else {
	                if ($distance_in_seconds >= 0 and $distance_in_seconds <= 4) {
	                    return 'less than 5 sec';
	                } elseif ($distance_in_seconds >= 5 and $distance_in_seconds <= 9) {
	                    return 'less than 10 sec';
	                } elseif ($distance_in_seconds >= 10 and $distance_in_seconds <= 19) {
	                    return 'less than 20 sec';
	                } elseif ($distance_in_seconds >= 20 and $distace_in_seconds <= 39) {
	                    return 'half a min';
	                } elseif ($distance_in_seconds >= 40 and $distance_in_seconds <= 59) {
	                    return 'less than a min';
	                } else {
	                    return '1 min';
	                }
	            }
	        } elseif ($distance_in_minutes >= 2 and $distance_in_minutes <= 44) {
	            return $distance_in_minutes . ' min';
	        } elseif ($distance_in_minutes >= 45 and $distance_in_minutes <= 89) {
	            return 'about 1 h';
	        } elseif ($distance_in_minutes >= 90 and $distance_in_minutes <= 1439) {
	            return 'about ' . round(floatval($distance_in_minutes) / 60.0) . ' h';
	        } elseif ($distance_in_minutes >= 1440 and $distance_in_minutes <= 2879) {
	            return '1 day';
	        } elseif ($distance_in_minutes >= 2880 and $distance_in_minutes <= 43199) {
	            return 'about ' . round(floatval($distance_in_minutes) / 1440) . ' day';
	        } elseif ($distance_in_minutes >= 43200 and $distance_in_minutes <= 86399) {
	            return 'about 1 month';
	        } elseif ($distance_in_minutes >= 86400 and $distance_in_minutes <= 525599) {
	            return round(floatval($distance_in_minutes) / 43200) . ' months';
	        } elseif ($distance_in_minutes >= 525600 and $distance_in_minutes <= 1051199) {
	            return 'about 1 year';
	        } else {
	            return 'over ' . round(floatval($distance_in_minutes) / 525600) . ' years';
	        }

		}

		/**
		 * http://uk2.php.net/manual/en/function.strip-tags.php#86964
		 *
		 * @param unknown_type $text
		 * @param unknown_type $tags
		 * @param unknown_type $invert
		 * @return unknown
		 */
		function RemoveTagsHTML($text, $tags = '', $invert = FALSE) {
			  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
			  $tags = array_unique($tags[1]);

			  if(is_array($tags) AND count($tags) > 0) {
			    if($invert == FALSE) {
			      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
			    } else {
			      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
			    }
			  } elseif($invert == FALSE) {
			    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
			  }
			  return $text;
		}

		/**
		* This method create an SQL IN clausul
		* @example FIELD_ID IN (1,2,3,4) AND 'or' OR
		*/
		function PrepareIN( $_field, $_array, $_condition ) {
			$str_in = "";

			$element = 0;
			if(sizeof($_array)>0) {
				for( $i = 0; $i<sizeof($_array); $i++ ) {

					if(trim($_array[$i]) != "") {
						$str_in .= "'" . $_array[$i] . "',";
						$element++;
					}

				}

				if($element>0) {
					return $_field . " IN (" . substr($str_in, 0, -1) . ") " . $_condition . " ";
				}

			}
			return "";
		}


		static function PrintFirstName($name) {
			$_temp = explode(" ", $name);
			return $_temp[0];
		}


		static function GetCountryList() {
		 $countries = array(
		 	"United Kingdom",
		 	"United States",
		 	"Canada",
		 	"Afghanistan",
			"Albania",
			"Algeria",
			"American Samoa",
			"Andorra",
			"Angola",
			"Anguilla",
			"Antarctica",
			"Antigua and Barbuda",
			"Argentina",
			"Armenia",
			"Aruba",
			"Australia",
			"Austria",
			"Azerbaijan",
			"Bahamas",
			"Bahrain",
			"Bangladesh",
			"Barbados",
			"Belarus",
			"Belgium",
			"Belize",
			"Benin",
			"Bermuda",
			"Bhutan",
			"Bolivia",
			"Bosnia and Herzegovina",
			"Botswana",
			"Bouvet Island",
			"Brazil",
			"British Indian Ocean Territory",
			"Brunei Darussalam",
			"Bulgaria",
			"Burkina Fasov",
			"Burundi",
			"Cambodiav",
			"Cameroon",
			"Cape Verde",
			"Cayman Islands",
			"Central African Republic",
			"Chad",
			"Chile",
			"China",
			"Christmas Island",
			"Cocos (Keeling) Islands",
			"Colombia",
			"Comoros",
			"Congo",
			"Congo, the Democratic Republic of the",
			"Cook Islands",
			"Costa Rica",
			"Cote D'Ivoire",
			"Croatia",
			"Cuba",
			"Cyprus",
			"Czech Republic",
			"Denmark",
			"Djibouti",
			"Dominica",
			"Dominican Republic",
			"Ecuador",
			"Egypt",
			"El Salvador",
			"Equatorial Guinea",
			"Eritrea",
			"Estonia",
			"Ethiopia",
			"Falkland Islands (Malvinas)",
			"Faroe Islands",
			"Fiji",
			"Finland",
			"France",
			"French Guiana",
			"French Polynesia",
			"French Southern Territories",
			"Gabon",
			"Gambia",
			"Georgia",
			"Germany",
			"Ghana",
			"Gibraltar",
			"Greece",
			"Greenland",
			"Grenada",
			"Guadeloupe",
			"Guam",
			"Guatemala",
			"Guinea",
			"Guinea-Bissau",
			"Guyana",
			"Haiti",
			"Heard Island and Mcdonald Islands",
			"Holy See (Vatican City State)",
			"Honduras",
			"Hong Kong",
			"Hungary",
			"Iceland",
			"India",
			"Indonesia",
			"Iran, Islamic Republic of",
			"Iraq",
			"Ireland",
			"Israel",
			"Italy",
			"Jamaica",
			"Japan",
			"Jordan",
			"Kazakhstan",
			"Kenya",
			"Kiribati",
			"Korea, Democratic People's Republic of",
			"Korea, Republic of",
			"Kuwait",
			"Kyrgyzstan",
			"Lao People's Democratic Republic",
			"Latvia",
			"Lebanon",
			"Lesotho",
			"Liberia",
			"Libyan Arab Jamahiriya",
			"Liechtenstein",
			"Lithuania",
			"Luxembourg",
			"Macao",
			"Macedonia, the Former Yugoslav Republic of",
			"Madagascar",
			"Malawi",
			"Malaysia",
			"Maldives",
			"Mali",
			"Malta",
			"Marshall Islands",
			"Martinique",
			"Mauritania",
			"Mauritius",
			"Mayotte",
			"Mexico",
			"Micronesia, Federated States of",
			"Moldova, Republic of",
			"Monaco",
			"Mongolia",
			"Montserrat",
			"Morocco",
			"Mozambique",
			"Myanmar",
			"Namibia",
			"Nauru",
			"Nepal",
			"Netherlands",
			"Netherlands Antilles",
			"New Caledonia",
			"New Zealand",
			"Nicaragua",
			"Niger",
			"Nigeria",
			"Niue",
			"Norfolk Island",
			"Northern Mariana Islands",
			"Norway",
			"Oman",
			"Pakistan",
			"Palau",
			"Palestinian Territory, Occupied",
			"Panama",
			"Papua New Guinea",
			"Paraguay",
			"Peru",
			"Philippines",
			"Pitcairn",
			"Poland",
			"Portugal",
			"Puerto Rico",
			"Qatar",
			"Reunion",
			"Romania",
			"Russian Federation",
			"Rwanda",
			"Saint Helena",
			"Saint Kitts and Nevis",
			"Saint Lucia",
			"Saint Pierre and Miquelon",
			"Saint Vincent and the Grenadines",
			"Samoa",
			"San Marino",
			"Sao Tome and Principe",
			"Saudi Arabia",
			"Senegal",
			"Serbia and Montenegro",
			"Seychelles",
			"Sierra Leone",
			"Singapore",
			"Slovakia",
			"Slovenia",
			"Solomon Islands",
			"Somalia",
			"South Africa",
			"South Georgia and the South Sandwich Islands",
			"Spain",
			"Sri Lanka",
			"Sudan",
			"Suriname",
			"Svalbard and Jan Mayen",
			"Swaziland",
			"Sweden",
			"Switzerland",
			"Syrian Arab Republic",
			"Taiwan, Province of China",
			"Tajikistan",
			"Tanzania, United Republic of",
			"Thailand",
			"Timor-Leste",
			"Togo",
			"Tokelau",
			"Tonga",
			"Trinidad and Tobago",
			"Tunisia",
			"Turkey",
			"Turkmenistan",
			"Turks and Caicos Islands",
			"Tuvalu",
			"Uganda",
			"Ukraine",
			"United Arab Emirates",
			"United States",
			"United States Minor Outlying Islands",
			"Uruguay",
			"Uzbekistan",
			"Vanuatu",
			"Venezuela",
			"Viet Nam",
			"Virgin Islands, British",
			"Virgin Islands, U.s.",
			"Wallis and Futuna",
			"Western Sahara",
			"Yemen",
			"Zambia",
			"Zimbabwe"
	 		);
	 	return ($countries);
	}


	function GeneratePassword ($length = 8) {

	  // start with a blank password
	  $password = "";

	  // define possible characters
	  $possible = "0123456789bcdfghjkmnpqrstvwxyz%$!@)(+=_}{";

	  // set up a counter
	  $i = 0;

	  // add random characters to $password until $length is reached
	  while ($i < $length) {

		    // pick a random character from the possible ones
		    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

		    // we don't want this character if it's already in the password
		    if (!strstr($password, $char)) {
		      $password .= $char;
		      $i++;
		    }

	  	}
		  // done!
		  return $password;
	 }

		function padLeft($_str, $_caracter, $_qtdeCaracter) {
	   		$qtdeStr = $_qtdeCaracter - strlen($_str);

	   		if($qtdeStr > 0)
	   			return str_repeat($_caracter, $qtdeStr) . $_str;
	 		else
				return substr($_str,0,$_qtdeCaracter);

	   		return $_str;

	   }

		function padRight($_str, $_caracter, $_qtdeCaracter) {

	   		$qtdeStr = $_qtdeCaracter - strlen($_str);

	  		if($qtdeStr > 0)
		  		return $_str . str_repeat($_caracter, $qtdeStr);
			else
				return substr($_str,0,$_qtdeCaracter);


	   }


		function GetTimezoneList($orderby = "timezone") {
			$timezone_abbreviations = timezone_abbreviations_list();

			foreach ($timezone_abbreviations as $ta) {
				foreach ($ta as $t) {
					$hours = floor($t[offset] / 3600);
					$minutes = abs($t[offset] % 3600) / 60;

					if($hours > 0) {
						$diff_hour = "+" . Useful::padLeft(abs($hours), "0", 2);
					} else if ($hours<0) {
						$diff_hour = "-" . Useful::padLeft(abs($hours), "0", 2);
					} else {
						$diff_hour = Useful::padLeft(abs($hours), "0", 2);
					}

					$diff = $diff_hour . ":" . Useful::padLeft($minutes, "0",2);

					if($orderby == "timezone") {
						$timezone[$t[timezone_id]] = array(
						"offset"=>$t[offset],
						"timezone_id"=>$t[timezone_id],
						"dst"=> $t[dst],
						"diff"=> $diff
						);
					} else {
						$timezone[$t[offset]] = array(
						"offset"=>$t[offset],
						"timezone_id"=>$t[timezone_id],
						"dst"=> $t[dst],
						"diff"=> $diff
						);
					}


				}
			}
			ksort($timezone);
			unset($timezone[""]); //cleaning rubbish
			return $timezone;
		}


		function CreateTimezoneComboBox($name, $css = "", $js = "", $selected = "", $initial_text = "", $initial_value = "") {

			$timezones = Useful::GetTimezoneList();

			$html = "<select id='".$name."' name='".$name."' $js $css >";

			foreach ($timezones as $zone) {

				if($zone[timezone_id] == $selected) {
					$html .= "<option selected value=\"".$zone[timezone_id]."\">(GMT " . $zone[diff] .")   " .$zone[timezone_id]."</option>";
				} else {
					$html .= "<option value=\"".$zone[timezone_id]."\">(GMT " . $zone[diff] .")   " .$zone[timezone_id]."</option>";
				}


			}

			$html .= "</select>";
			return $html;
		}

		function HourToSec($time) {
			$t = explode(":", $time);
			return $t[0]*3600 + $t[1]*60;
		}

		function SecondToHour($sec) {
			$h = $sec / 3600;
			$h_minutes = $sec % 3600;
			$hour = floor($h);
			$m = floor($h_minutes / 60);
			return  Useful::padLeft($hour, 0, 2) . ":" . Useful::padLeft($m,0,2);
		}

		function CreateComboBoxWithTime($start, $end, $interval, $name, $selectedItem = '', $css = '', $js='', $initial_value='', $initial_text = '') {
			$time_from = Useful::HourToSec($start);
			$time_to = Useful::HourToSec($end);

			$html = "\n<select name=\"" . $name ."\" id=\"" . $name ."\" $js $css>\n";

			if($initial_text != "") {
				$html .= "<option value='" . $initial_value . "'>" . $initial_text . "</option>\n";
			} else {
				$html .= "<option></option>\n";
			}

			while($time_from <= $time_to) {
				$t = Useful::SecondToHour($time_from);

				if( $selectedItem == $t )
	                    $html    .=    "<option selected value=\"" . $t . "\">" .$t ."</option>\n";
	             else
	                    $html    .=    "<option value=\"" . $t . "\">" . $t ."</option>\n";

	           $time_from += $interval;
			}

			return $html .= "</select>";

		}


		function GenerateIntervalOfTime($start, $end, $interval) {
			$time_from = Useful::HourToSec($start);
			$time_to = Useful::HourToSec($end);

			$Period = array();
			while($time_from <= $time_to) {
				//$Period[$time_from] = Useful::SecondToHour($time_from);
				$Period[$time_from] = ($time_from);
			 	$time_from += $interval;
			}

			return $Period;
		}

		function GenerateOptionsForFilter($ObjectList, $FieldValue, $FieldLabel = "") {

				$FilterOptionsTemp = array();

				foreach ( ($ObjectList ? $ObjectList: array()) as $Obj ) {
					if($FieldLabel == "") {
						if($Obj->$FieldValue != "") {
							$FilterOptionsTemp[$Obj->$FieldValue] = $Obj->$FieldValue;
						}
					} else {
						if($Obj->$FieldValue != "") {
							$FilterOptionsTemp[$Obj->$FieldValue] = $Obj->$FieldLabel;
						}
					}
				}
				return $FilterOptionsTemp;

			}



		function CreateComboboxWithReadableDate ($name, $selectedItem = '', $css = '', $js='', $initial_value='', $initial_text = '') {
			global $langg;

			$L = __CLASS__ . ".". __METHOD__ . ".";

			$Today = strtotime(date("Y-m-d"));
			$OneDay = 86400;
			$Dates = Array();


			$Dates[$langg->_($L."Option.1")] = $Today + $OneDay;
			$Dates[$langg->_($L."Option.2")] = $Today;
			$Dates[$langg->_($L."Option.3")] = $Today - $OneDay;
			$Dates[$langg->_($L."Option.4")] = $Today - ($OneDay * 2);
			$Dates[$langg->_($L."Option.5")] = $Today - ($OneDay * 2);
			$Dates[$langg->_($L."Option.6")] = $Today - ($OneDay * 7);
			$Dates[$langg->_($L."Option.7")] = $Today - ($OneDay * 14);
			$Dates[$langg->_($L."Option.8")] = $Today - ($OneDay * 30);

			$html = "\n<select name=\"" . $name ."\" id=\"" . $name ."\" $js $css>\n";

				if($initial_text != "") {
					$html .= "<option value='" . $initial_value . "'>" . $initial_text . "</option>\n";
				} else {
					$html .= "<option></option>\n";
				}

				foreach ($Dates as $Value=>$Key) {
					if( $selectedItem == $Key )
	                    $html    .=    "<option selected value=\"" . $Key . "\">" .$Value ."</option>\n";
	             	else
	                    $html    .=    "<option value=\"" . $Key . "\">" . $Value ."</option>\n";
				}
				return $html .= "</select>";

			}


		function FormatMultiDimensionArrayToCSV($Array, $Name = '') {

			$CVSString = "";

			if($Name == '') {
				foreach ( ($Array ? $Array: array()) as $A) {
					$CVSString .= "'" . $A . "',";
				}
			} else {
				foreach ( ($Array[$Name] ? $Array[$Name] : array()) as $A) {
					$CVSString .= "'" . $A . "',";
				}
			}

			return substr($CVSString, 0, strlen($CVSString)-1);

		}

		function CheckEmail($email, $domain = "boomering.me", $from = "boomering@boomering.me") {
		  $err = '';

		  if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $email)) {
		    list($alias, $host) = split("@", $email);
		    if (checkdnsrr($host, "MX")) {
		      getmxrr($host, $mxhosts);
		      for ($i=0;$i<count($mxhosts);$i++) {
		        if ($socket = @fsockopen ($mxhosts[$i], 25, $errno, $errstr, 10)) break;
		      }
		      if ($socket) {
		        if (ereg("^220", $out = fgets($socket, 1024))) {
		          fputs ($socket, "HELO $domain\r\n");
		          $out = fgets ( $socket, 1024);
		          fputs ($socket, "MAIL FROM: <{$from}>\r\n");
		          $from = fgets ( $socket, 1024);
		          fputs ($socket, "RCPT TO: <{$email}>\r\n");
		          $to = fgets ($socket, 1024);
		          fputs ($socket, "QUIT\r\n");
		          fclose($socket);
		          if (!ereg ("^250", $from) || !ereg ("^250", $to)) {
		            $err = 'Server rejected address';
		          }
		        } else {
		          $err = 'No response from server';
		        }
		      } else {
		        $err = 'Can not connect E-Mail server.';
		      }
		    } else {
		      $err = 'no mx record/invalid domain';
		    }
		  } else {
		    $err = 'Invalid email format';
		  }

		  return $err;
		}

		function UploadSingleFile($File, $LocalFolder) {

			if($File['size']>0) {
				$t = explode(".", $File['name']);
				$ext = $t[sizeof($t)-1];

				$filename = str_replace(" ", "_",$t[0]) . "_". (time() . rand(10,666)) . "." . $ext;

				//VERIFIQUE SEMPRE SE TEM PERMISS�O
				if(move_uploaded_file($File['tmp_name'], $LocalFolder . $filename )) {
					return $filename;
				} else {
					return -666;
				}
			}

			return false;
		}

		function DiferencaEntreHoras($HoraInicial, $HoraFinal) {

			$HoraInicialTemp = strtotime(date('Y-m-d') . ' ' . $HoraInicial);
			$HoraFinalTemp = strtotime(date('Y-m-d') . ' ' . $HoraFinal);
			$Diff = 0;

			if($HoraInicialTemp > 0) {
				$Diff = ($HoraFinalTemp - $HoraInicialTemp) / 3600;

				if($Diff > 0) {
					$ParteIneira = floor($Diff);
					$ParteFloat =  $Diff - $ParteIneira;

					$TempMinutos = ($ParteFloat * 60);

					if($TempMinutos > 0) {
						return $ParteIneira . 'h ' . $TempMinutos . 'min';
					} else {
						return $ParteIneira . 'h ';
					}

				} else {
					return '0h';
				}

			} else {
				return '0h';
			}

		}

	function stripAccents($stripAccents){
  return strtr($stripAccents,'���������������������������������������������������','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

	}

?>