<?php
	// Server-side code to delete Service Report 
	
    // get ServiceReportID from dashboard.php
    $request = $_REQUEST;
    $srid = $request['SRID'];
    
	// establish connection
	include "dbconnect.php";

	//query to delete expense images
	$sqlImg = "SELECT ServiceExpenseLineID FROM dbo.tblServiceExpenseLines WHERE ServiceID = '".$srid."';"; 
	$result = sqlsrv_query($conn,sqlImg) or die("Couldn't execut query");
	while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
        unlink("../../ExpenseLineFiles/".$data['ServiceExpenseLineID'].".jpg");
    }

	// query to delete ServiceReport, ServiceExpenseLines and ServiceTaskLines
	$sql = "DELETE FROM dbo.tblService WHERE ServiceID ='".$srid."';";
	$sql .= "DELETE FROM dbo.tblServiceExpenseLines WHERE ServiceID ='".$srid."';";
	$sql .= "DELETE FROM dbo.tblServiceTaskLines WHERE ServiceID ='".$srid."';";

	// execute query 
	$stmt = sqlsrv_query( $conn, $sql);

	// throw error if failed to excute query
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}

	// free statements
	sqlsrv_free_stmt($sqlImg);
    sqlsrv_free_stmt($stmt); 

    // close connection
    sqlsrv_close($conn);
    
    // response after successfully deleted 
    echo "Succesfully deleted Service Report!";
?>