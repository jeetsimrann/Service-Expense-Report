<?php
    // Check if cookie exists
    $request = $_REQUEST;
    $selID = $request['selID'];
    
	include "dbconnect.php";
	$sql = "DELETE FROM dbo.tblServiceExpenseLines WHERE ServiceExpenseLineID ='".$selID."'";
	unlink("../../ExpenseLineFiles/".$selID.".jpg");

	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    
    echo "Succesfully deleted Expense Line!";
?>