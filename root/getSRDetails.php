<?php
    // Server-side code to get service report data

    // session started
    session_start();
    // establish connection 
    require "dbconnect.php";
    // query to retrieve Service Report
    $sqlupdt = "SELECT * FROM dbo.tblService 
              INNER JOIN dbo.tblCustOrders ON dbo.tblService.OrderID = dbo.tblCustOrders.OrderID 
              INNER JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID
              WHERE ServiceID=".$_COOKIE["SRID"];
    // executing query
    $result = sqlsrv_query($conn,$sqlupdt) or die("Couldn't execut query");
    // assigning fetched data to variables
    while ($dataupdt=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
        $ServiceID = $dataupdt['ServiceID'];
        $ServiceDate = date_format($dataupdt['ServiceDate'], 'Y-m-d');
        $OrderNo = $dataupdt['OrderNo'];
        $TravelFrom = $dataupdt['TravelFrom'];
        $TravelTo = $dataupdt['TravelTo'];
        $CustomerName = $dataupdt['CustomerName'];
        $kmTraveled = $dataupdt['kmTraveled'];
        $MileageAllowance = $dataupdt['MileageAllowance'];
        $MileageAllowanceBillable = $dataupdt['MileageAllowanceBillable'];
        $USExchange = $dataupdt['USExchange'];

        $MileageBillable = $dataupdt['MileageBillable'];
        $Processed = $dataupdt['Processed'];
        $ProcessedDate = $dataupdt['ProcessedDate'];
        $Submitted = $dataupdt['Submitted'];
        $SubmittedDate = $dataupdt['SubmittedDate'];
        $Reviewed = $dataupdt['Reviewed'];
        $ReviewedDate = $dataupdt['ReviewedDate'];
        $ReviewedBy = $dataupdt['ReviewedBy'];
        $Notes = $dataupdt['Notes'];

        $EmployeeID = $dataupdt['EmployeeID'];
    }
?>