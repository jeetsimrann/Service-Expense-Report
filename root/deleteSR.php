<?php
     // Check if cookie exists
    $request = $_REQUEST;
    $srid = $request['SRID'];
    
	include "dbconnect.php";

	$query_select = "SELECT ServiceExpenseLineID FROM dbo.tblServiceExpenseLines WHERE ServiceID = '".$srid."';"; 
	$result = sqlsrv_query($conn,$query_select) or die("Couldn't execut query");
    
	while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
        unlink("../../ExpenseLineFiles/".$data['ServiceExpenseLineID'].".jpg");
		// echo "../../ExpenseLineFiles/".$data['ServiceExpenseLineID'].".jpg";
    }

	$sql = "DELETE FROM dbo.tblService WHERE ServiceID ='".$srid."';";
	$sql .= "DELETE FROM dbo.tblServiceExpenseLines WHERE ServiceID ='".$srid."';";
	$sql .= "DELETE FROM dbo.tblServiceTaskLines WHERE ServiceID ='".$srid."';";

	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}
    
    echo "Succesfully deleted Service Report!";
?>