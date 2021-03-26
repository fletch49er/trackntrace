<?php
/*
 * ===================================================================
 * Function:	formBlocks()
 * Purpose:		function to create form select options
 * Author:		Mark Fletcher
 * Date:			20.10.2020
 *
 * Input:
 *    $dataArray, $offset, $length
 *
 * Output:
 *    echo - <fieldset><input></fieldset> blocks
 *
 * Notes:
 *
 * ==================================================================
*/
function formBlocks($dataArray, $offset, $length) {
	$data = array_slice($dataArray, $offset, $length);
	foreach($data as $name => $value) {
		echo <<<EOT
		<fieldset>
			<label for="$name">$value[0]: </label><br />
			<input autocomplete="$value[4]" id="$name" type="$value[1]" name="$name" value="$value[3]" placeholder="$value[2]" required />
		</fieldset>\n
EOT;
	}
}

/*
 * ===================================================================
 * Function:	selectList()
 * Purpose:		function to create form select options
 * Author:		Mark Fletcher
 * Date:			20.10.2020
 *
 * Input:
 *    $sql - data from database table
 *
 * Output:
 *    echo - <option></option> tags
 *
 * Notes:
 *
 * ==================================================================
*/
function selectList($sql) {
 global $pdo;
 if ($result = $pdo->query($sql)) {
	  while($row = $result->fetch()) {
     echo '<option value="'.$row['id'].'">'.$row['text'].'</option>'.PHP_EOL;
   }
 } else {
   echo "ERROR: Could not execute $sql. " . print_r($pdo->errorInfo());
 }
}

 /*
  * ===================================================================
  * Function:	updateRecords()
  * Purpose:	function to create INPUT sql string
  * Author:		Mark Fletcher
  * Date:			25.03.2021
  *
  * Input:
  * 	$record from forn entries
  *
  * Output:
  * 	$sql string
  *
  * Notes:
  *
  * ==================================================================
*/
function updateRecords($record) {
	array_pop($record);
	$nameStr = "";
	$valueStr = "";
	$count = 1;
	foreach($record as $name => $value) {
		$nameStr .= "`$name`";
		$valueStr .= "'$value'";
		if ($count < count($record)) {
			$nameStr .= ", ";
			$valueStr .= ", ";
		}
		$count++;
	}
	$sql = "INSERT INTO track_visitors ($nameStr) VALUES ($valueStr)";
	return $sql;
}

/*
 * ===================================================================
 * Function:	copyright()
 * Purpose:		function to create a copyright notice
 * Author:		Mark Fletcher
 * Date:			18.04.2018
 *
 * Input:
 * 	$company, $year
 *
 * Output:
 *  echo copyright notice
 *
 * Notes:
 *
 * ==================================================================
*/
function copyright($company, $year) {
	if ($year == date('Y')) {
		$date = $year;
	} else {
		$date = $year.' - '.date('Y');
	}
	echo '&copy; '.$date.' '.$company.'. All rights reserved.';
}
?>
