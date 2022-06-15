<?php
    // Check if cookie exists
    $request = $_REQUEST;
    $stlID = $request['stlID'];
    
	include "dbconnect.php";
	$sql = "DELETE FROM dbo.tblServiceTaskLines WHERE ServiceTaskLineID ='".$stlID."'";

	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    
    echo "Succesfully deleted Task Line!";
?>