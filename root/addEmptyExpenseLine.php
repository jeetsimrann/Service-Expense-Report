<?php
    // Server-side code to add empty expense line
    
    // requesting ServiceReportID
    $request = $_REQUEST;
    $SID = $request['SID'];
    
    // establish connection 
	include "dbconnect.php";

    // query to add empty expense line and get ExpenseLineID 
	$sql = "INSERT INTO dbo.tblServiceExpenseLines (ServiceID,Notes) VALUES (".$SID.",'');
            SELECT SCOPE_IDENTITY()";

    // executing query
	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    
    //free statement
    sqlsrv_next_result($stmt); 

    // get ExpenseLineID
    sqlsrv_fetch($stmt);
    echo sqlsrv_get_field($stmt, 0);
?>