<?php
 error_reporting(E_ALL); ini_set('display_errors', 1);

if ( ($handle = fopen("utils/dbconf", "r") ) !== FALSE ) {
	
	$data = fgetcsv($handle, 1050, ",");
    
    $db = mysqli_connect($data[0], $data[1], $data[2], $data[3]);

    fclose($handle);
}
?>
