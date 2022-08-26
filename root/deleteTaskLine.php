<?php
	// Server-side code to delete task line

    // requesting TaskLineID
    $request = $_REQUEST;
    $stlID = $request['stlID'];
    
	// establish connection 
	include "dbconnect.php";

	// query to delete task line 
	$sql = "DELETE FROM dbo.tblServiceTaskLines WHERE ServiceTaskLineID ='".$stlID."'";

	// execute query
	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    
	// free statement
	sqlsrv_free_stmt($stmt); 
		
	// close connection
	sqlsrv_close($conn);

	// response after deleting task line successfully 
    echo "Succesfully deleted Task Line!";
?>