<?php
    $EmptyExpenseLineArr = array();

    $request = $_REQUEST;
    $SID = $request['SID'];
    
	include "dbconnect.php";
	$sql = "INSERT INTO dbo.tblServiceExpenseLines (ServiceID,Notes) VALUES (".$SID.",'');
            SELECT SCOPE_IDENTITY()";

	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    sqlsrv_next_result($stmt); 
    sqlsrv_fetch($stmt);

    echo sqlsrv_get_field($stmt, 0);


    // $EmptyExpenseLineArr = array($selID, $SID, 0, 0.00, 0, 0, 0, NULL, 0, null);
?>