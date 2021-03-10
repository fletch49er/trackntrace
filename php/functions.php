<?php
/*
 * ===================================================================
 * Function:	selectList()
 * Purpose:		function to create form select options
 * Author:		Mark Fletcher
 * Date:			27.11.2018
 *
 * Input:
 * 	$_SERVER['PHP_SELF'] - current page URL
 *
 * Output:
 * 	pageName
 *
 * Notes:
 *
 * ==================================================================
 */
 function selectList($sql) {
   global $pdo;
   if ($result = $pdo->query($sql)) {
 	  while($row = $result->fetch()) {
       echo '<option name="'.$row['value'].'">'.$row['text'].'</option>'.PHP_EOL;
     }
   } else {
     echo "ERROR: Could not execute $sql. " . print_r($pdo->errorInfo());
   }
 }
 
 /*
  *******************************************************************************
  * File:		copyright()
  * Purpose:	function to create copyright notice for webpages
  *
  * Author:	Mark Fletcher
  * Date:		18.04.2018
  *
  * Notes:
  *
  * Revision:
  *		18.04.2018	1st issue.
  *
  *******************************************************************************
 */
 //create a copyright notice
 function copyright($company, $year) {
 	if ($year == date('Y')) {
 		$date = $year;
 	} else {
 		$date = $year.' - '.date('Y');
 	}
 	echo '&copy; '.$date.' '.$company.'. All rights reserved.';
 }
?>
