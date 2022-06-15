<?php
session_start();
?>
<?php
        require "dbconnect.php";
        $sqlupdt = "SELECT * FROM dbo.tblService 
                  INNER JOIN dbo.tblCustOrders ON dbo.tblService.OrderID = dbo.tblCustOrders.OrderID 
                  INNER JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID
                  WHERE ServiceID=".$_COOKIE["SRID"];
        $resultupdt = sqlsrv_query($conn,$sqlupdt) or die("Couldn't execut query");
        while ($dataupdt=sqlsrv_fetch_array($resultupdt, SQLSRV_FETCH_ASSOC)){
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