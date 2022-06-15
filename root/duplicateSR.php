<?php
     // Check if cookie exists
    $request = $_REQUEST;
    $srid = $request['SRID'];
    
	include "dbconnect.php";
date_default_timezone_set('America/New_York');
    $today = date("Y-m-d H:i:s");

    $sql = "INSERT INTO dbo.tblService
        (	 EmployeeID
            ,ServiceDate
            ,TravelFrom
            ,TravelTo
            ,OrderID
            ,MileageAllowance
            ,MileageAllowanceBillable
            ,kmTraveled
            ,USExchange
            ,MileageBillable
            ,Processed
            ,ProcessedDate
            ,Submitted
            ,SubmittedDate
            ,Reviewed
            ,ReviewedDate
            ,ReviewedBy
            ,Notes
        ) 

        SELECT 
             EmployeeID
            ,'".$today."' 
            ,TravelFrom
            ,TravelTo
            ,OrderID
            ,MileageAllowance
            ,MileageAllowanceBillable
            ,kmTraveled
            ,USExchange
            ,MileageBillable
            ,0
            ,ProcessedDate
            ,0
            ,SubmittedDate
            ,0
            ,ReviewedDate
            ,ReviewedBy
            ,Notes
        FROM dbo.tblService 
        WHERE ServiceID = '".$srid."';";

	$stmt = sqlsrv_query( $conn, $sql);
	if( $stmt === false ) {
		die( print_r( sqlsrv_errors(), true));
	}    
    echo $today."Succesfully Duplicate the Service Report!";
?>