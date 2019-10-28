<?php
class CGI 
{
	function get($property) 
	{
		if (isset ($_SESSION[$property])) 	{ return $_SESSION[$property]; }
		else 								{ return NULL; }
	}

	function testActionRequest($testvalue) 
	{
		$result = (isset ($_REQUEST['-action']) && $_REQUEST['-action'] == $testvalue);
		return $result;
	}

	function storeFile() 
	{
		$path = $_SERVER['PHP_SELF'];
		$nodes = split('/', $path);
		$this->store('file', $nodes[count($nodes)-1]);
	}
	
	function checkStoredFile() 
	{
		if(isset($_SESSION))
		{
			if(array_key_exists('file', $_SESSION))
			{
				$f = $_SESSION['file'];
				$pos = strpos($f, '?');
				if(!($pos === false)){
					$f = substr($f, 0, $pos - 1);
				}
				if($f == 'authentication.php'){
					$this->store('file', 'home.php?');
				}
			}
			else
			{
				$this->store('file', 'home.php?');
			}
		}
	}
		
	function store($property, $value) 
	{
		if ($property == '-delete') 		{ $_SESSION['-action'] = 'delete'; } 
		elseif ($property == '-duplicate') 	{ $_SESSION['-action'] = 'duplicate'; } 
		else 								{ $_SESSION[$property] = $value; }
	}

	function clear($property) { unset ($_SESSION[$property]); }

	function __construct() 
	{
		// Request parameters are saved in the session and accessed via the CGI.
		foreach ($_GET as $key => $value) { $this->store($key, $value); }

		// the record data submitted
		$recordData = array ();

		foreach ($_POST as $key => $value) 
		{

		/*  If a key does not start with '-' then it is a field parameter.
		Capture the field value pairs in a record data array
		and store it in the session separately under the key 'storedfindrequest'
		when handling a '-find' request, or in the 'recorddata' key for '-edit' or '-new'  */
			
			if(strpos($key, '-', 0) === 0)	{ $isCommand = true; }
			else							{ $isCommand = false; }

			if ($key === "userName" || $key === "passWord" || $isCommand ) { $this->store($key, $value); } 
			else { $recordData[$key] = $value; }
		} // end foreach

		// get the field names
		$fieldEditRecords = $this->get("fieldEditRecords");

		// always replace the existing find request
		if ($this->testActionRequest("find")) 
		{
			$displayDateFormat = '%m/%d/%Y';
			if (isset($fieldEditRecords) === true) 
			{
				// move the submitted data to the stored find request; an array, keys: field names, values: submitted query
				$storedFind = array();
				foreach($recordData as $index => $value) 
				{
					if(!($index % 2 == 0))
					{
						// Convert any time/date formatted field 
						if(array_key_exists($index, $fieldEditRecords)){ $fieldEditRecord = $fieldEditRecords[$index]; }
						if(is_null($fieldEditRecord) === false && $fieldEditRecord->isEditBox())
						{
							$resultType = $fieldEditRecord->getResultType();
							if ($resultType == "date") 				{ $value = submitDate($value, $displayDateFormat); }
							else if ($resultType == "timestamp") 	{  $value = submitTimeStampForSearch($value, $displayDateFormat); }
						}
                     }
                     $storedFind[$fieldEditRecords[$index]->getFieldName()] = $value;
                }     
				$this->store('storedfindrequest', $storedFind);
			}
		} 
		else 
		{
			// clear it for a findall
			if ($this->testActionRequest("findall")) { $this->clear('storedfindrequest'); }

			
			else
			{
				// 	store edit or new request record data
				if ($this->testActionRequest("edit") || $this->testActionRequest("new")) { $this->store('recorddata', $recordData); } 
				else { $this->clear('recorddata'); } // 	clear out recorddata if not an edit	
			}
		}
	}

	function reset() 
	{
		$this->clear('recorddata');
		$this->clear('storedfindrequest');
		$this->clear('fieldEditRecords');
		$_SESSION = array();
	}
} // end class CGI
?>