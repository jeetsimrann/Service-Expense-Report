<?php
    // Server-side code to add empty task line

    // requesting ServiceReportID
    $request = $_REQUEST;
    $SID = $request['SID'];
    
    // establish connection 
	include "dbconnect.php";

    // query to add empty task line and get TaskLineID 
	$sql = "INSERT INTO dbo.tblServiceTaskLines (ServiceID,Notes) VALUES (".$SID.",'');
            SELECT SCOPE_IDENTITY()";

    // executing query
	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}

    //free statement
    sqlsrv_next_result($stmt); 

    // get TaskLineID 
    sqlsrv_fetch($stmt);
    echo sqlsrv_get_field($stmt, 0);
?>