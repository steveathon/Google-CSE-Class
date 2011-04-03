<?

class CSearch {

	var $Domain = 'www.google.com';
	var $Path = '/cse?';//
	var $Vars = array (	'cx' => 'YOUR-CX-CODE',
							'client' => 'google-csbe',
							'output' => 'xml_no_dtd',
							'q' => '',
							'as_q' => '',
							'num' => '10',
							'start' => '0',
							'filter' => '0',
							'hl' => 'en',
							'ie' => 'utf8',
							'oe' => 'utf8');

	var $Q = "";


	var $Results = array (	'context' => '',
								'tm' => '',
								'q' => '',
								'data' => '');

	var $BuiltQuery;

	function LoadSearch($Keywords = NULL,$Start = NULL, $Num = NULL,$Sort = NULL) {
		$return = false;
		
		if ( is_numeric($Start) && $Start> 0 ) {
			$this->Vars['start'] = $Start;
		}
		else {
			$this->Vars['start'] = 0;
		}
		
		if ( is_numeric($Num) && $Num > 10 && $Num <= 100 ) {
			$this->Vars['num'] = $Num;
		}
		else {
			$this->Vars['num'] = 10;
		}
		
		if ( isset($Sort) ) {
			$this->Vars['sort'] = $Sort;
		}
		
		if ( strlen($Keywords) > 0 ) {
			$Words = explode('+',$Keywords);
			foreach ( $Words as $Word ) {
				$Counter = 1;
				if ( $Counter > 1 ) {
					$this->Vars['q'] .= ' ';
				}
				$this->Vars['q'] .= urlencode($Word);
				$Counter++;
					
				$return = true;
			}
		}
		return $return;
	}


	function ExecuteSearch() {
		$return = false;
		if ( $this->BuildQuery() && $Data = @file_get_contents($this->BuiltQuery)) {
			$XML = simplexml_load_string($Data);
			$XMLCounter = 0;

			while ( isset($XML->PARAM->{$XMLCounter}) ) {
				if ( (string)$XML->PARAM->{$XMLCounter}->attributes()->name == 'q' ) {
					$XML->Q = (string)$XML->PARAM->{$XMLCounter}->attributes()->value;
					$XMLSave[] = array ( 'name' => (string)$XML->PARAM->{$XMLCounter}->attributes()->name,
											'value' => (string)$XML->PARAM->{$XMLCounter}->attributes()->value,
											'orig' => (string)$XML->PARAM->{$XMLCounter}->attributes()->original_value);
				}
				elseif ( (string)$XML->PARAM->{$XMLCounter}->attributes()->name == 'num' ) {
					
					$XMLSave[] = array ( 'name' => (string)$XML->PARAM->{$XMLCounter}->attributes()->name,
											'value' => (string)$XML->PARAM->{$XMLCounter}->attributes()->value,
											'orig' => (string)$XML->PARAM->{$XMLCounter}->attributes()->original_value);
				}
				elseif ( (string)$XML->PARAM->{$XMLCounter}->attributes()->name == 'start' ) {
					
					$XMLSave[] = array ( 'name' => (string)$XML->PARAM->{$XMLCounter}->attributes()->name,
											'value' => (string)$XML->PARAM->{$XMLCounter}->attributes()->value,
											'orig' => (string)$XML->PARAM->{$XMLCounter}->attributes()->original_value);
				}
				elseif ( (string)$XML->PARAM->{$XMLCounter}->attributes()->name == 'oe' ) {
					
					$XMLSave[] = array ( 'name' => (string)$XML->PARAM->{$XMLCounter}->attributes()->name,
											'value' => (string)$XML->PARAM->{$XMLCounter}->attributes()->value,
											'orig' => (string)$XML->PARAM->{$XMLCounter}->attributes()->original_value);
				}
				elseif ( (string)$XML->PARAM->{$XMLCounter}->attributes()->name == 'ie' ) {
					
					$XMLSave[] = array ( 'name' => (string)$XML->PARAM->{$XMLCounter}->attributes()->name,
											'value' => (string)$XML->PARAM->{$XMLCounter}->attributes()->value,
											'orig' => (string)$XML->PARAM->{$XMLCounter}->attributes()->original_value);
				}
				elseif ( (string)$XML->PARAM->{$XMLCounter}->attributes()->name == 'filter' ) {
					
					$XMLSave[] = array ( 'name' => (string)$XML->PARAM->{$XMLCounter}->attributes()->name,
											'value' => (string)$XML->PARAM->{$XMLCounter}->attributes()->value,
											'orig' => (string)$XML->PARAM->{$XMLCounter}->attributes()->original_value);
				}
				elseif ( (string)$XML->PARAM->{$XMLCounter}->attributes()->name == 'sort' ) {
					
					$XMLSave[] = array ( 'name' => (string)$XML->PARAM->{$XMLCounter}->attributes()->name,
											'value' => (string)$XML->PARAM->{$XMLCounter}->attributes()->value,
											'orig' => (string)$XML->PARAM->{$XMLCounter}->attributes()->original_value);
				}
				
				$XMLCounter++;
			}
			$XMLCounter = 0;
			while ( isset($XML->PARAM->{$XMLCounter}) ) {
				unset($XML->PARAM->{$XMLCounter});
			}
			
			// Now reload the params
			foreach ( $XMLSave as $ParamPush ) {
				$Rank = $XML->addChild('PARAM');
				$Rank->addAttribute('name',$ParamPush['name']);
				$Rank->addAttribute('value',$ParamPush['value']);
				$Rank->addAttribute('original_value',$ParamPush['orig']);
			}
			
			$return = $XML->asXML();

		}
		return $return;
	}

	function BuildQuery() {
		$return = false;
		$this->BuiltQuery = "http://" . $this->Domain . $this->Path;
		$Counter = 1;
		foreach ( array_keys($this->Vars) as $LoadVar) {
			if ( $Counter > 1 ) {
				$this->BuiltQuery .= '&';
			}
			$this->BuiltQuery .= $LoadVar . "=" . $this->Vars[$LoadVar];
			$Counter++;
		}
			
		if ( strlen($this->BuiltQuery) > 0 ) {
			$return = true;
		}
		return $return;
	}


}

?>
