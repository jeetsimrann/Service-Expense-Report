<?php
    // Server-side code to duplicate Service Report

    // get ServiceReportID from dashboard.php
    $request = $_REQUEST;
    $srid = $request['SRID'];
    
    // establish connection
	include "dbconnect.php";

    // set timezone
    date_default_timezone_set('America/New_York');

    // get today's date
    $today = date("Y-m-d H:i:s");

    // insert row same as $srid (selected service report) 
    $sql = "INSERT INTO dbo.tblService
                (EmployeeID, ServiceDate, TravelFrom, TravelTo, 
                OrderID, MileageAllowance, MileageAllowanceBillable, 
                kmTraveled, USExchange, MileageBillable, Processed, 
                ProcessedDate, Submitted, SubmittedDate, Reviewed, 
                ReviewedDate, ReviewedBy, Notes) 
            SELECT 
                EmployeeID, '".$today."' , TravelFrom, TravelTo, 
                OrderID, MileageAllowance, MileageAllowanceBillable, 
                kmTraveled, USExchange, MileageBillable, 0, ProcessedDate, 
                0, SubmittedDate, 0, ReviewedDate, ReviewedBy, Notes
            FROM dbo.tblService 
            WHERE ServiceID = '".$srid."';";
            
    // execute query 
	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}    

    // free statement
    sqlsrv_free_stmt($stmt); 

    // close connection
    sqlsrv_close($conn);

    // response after successfully duplicated 
    echo "Succesfully Duplicate the Service Report!";
?>