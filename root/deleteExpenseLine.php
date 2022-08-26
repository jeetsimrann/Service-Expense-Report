<?php
	// Server-side code to delete expense line
    	
	// requesting ExpenseLineID
    $request = $_REQUEST;
    $selID = $request['selID'];
    
	// establish connection 
	include "dbconnect.php";

	// query to delete expense line 
	$sql = "DELETE FROM dbo.tblServiceExpenseLines WHERE ServiceExpenseLineID ='".$selID."'";

	// remove expense receipt image if exists
	unlink("../../ExpenseLineFiles/".$selID.".jpg");

	// execute query
	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    
	// free statement
	sqlsrv_free_stmt($stmt); 
		
	// close connection
	sqlsrv_close($conn);

	// response after deleting expense line successfully 
    echo "Succesfully deleted Expense Line!";
?>