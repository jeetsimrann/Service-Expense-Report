<?php  
include "dbconnect.php";
        date_default_timezone_set('America/New_York');
        $tsql1 = "SELECT OrderID FROM dbo.tblCustOrders where OrderNo = ?";
        $getName1 = sqlsrv_query($conn, $tsql1, array($_POST['ordernos']));
        if( $getName1 === false )  
                die( FormatErrors( sqlsrv_errors() ) );  
        if ( sqlsrv_fetch( $getName1 ) === false )  
                die( FormatErrors( sqlsrv_errors() ) ); 
        
        $EmpID = $_POST['EmployeeID'];
        $input_OrderID = sqlsrv_get_field( $getName1, 0); 
        $input_ServiceID = 0;
        $input_ServiceDate = $_POST["servicedate"]." ".date("H:i:s");
        $input_TravelFrom = $_POST['travelfrom'];
        $input_TravelTo = $_POST['travelto'];
        $input_MileageAllowance = $_POST['MileageAllowance'];
        $input_MileageAllowanceBillable = $_POST['MileageAllowanceBillable'];
        $input_kmTraveled = $_POST['kmTraveled'];
        $input_USExchange = $_POST['USExchange'];
        $responseMessage = "Success"; 
        $NewServiceID = 1;  

        $tsql_callSP1 = "{call sp_tblService_SaveItem(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)};";
       
        $params11 = array();

        array_push($params11,array($input_ServiceID, SQLSRV_PARAM_IN),
                            array($EmpID, SQLSRV_PARAM_IN), 
                            array($input_ServiceDate, SQLSRV_PARAM_IN),
                            array($input_TravelFrom, SQLSRV_PARAM_IN),
                            array($input_TravelTo, SQLSRV_PARAM_IN),
                            array($input_OrderID, SQLSRV_PARAM_IN),
                            array($input_MileageAllowance, SQLSRV_PARAM_IN),
                            array($input_MileageAllowanceBillable, SQLSRV_PARAM_IN),
                            array($input_kmTraveled, SQLSRV_PARAM_IN),
                            array($input_USExchange, SQLSRV_PARAM_IN),
                            array(1, SQLSRV_PARAM_IN),
                            array(0, SQLSRV_PARAM_IN),
                            array(NULL, SQLSRV_PARAM_IN),
                            array(0, SQLSRV_PARAM_IN),
                            array(NULL, SQLSRV_PARAM_IN),
                            array(0, SQLSRV_PARAM_IN),
                            array(NULL, SQLSRV_PARAM_IN),
                            array(NULL, SQLSRV_PARAM_IN),
                            array(NULL, SQLSRV_PARAM_IN),
                            array(&$responseMessage, SQLSRV_PARAM_INOUT),
                            array(&$NewServiceID, SQLSRV_PARAM_INOUT));
                            
 
        $stmt31 = sqlsrv_query( $conn, $tsql_callSP1, $params11);  
        if( $stmt31 === false )  
        {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        sqlsrv_next_result($stmt31);


if (isset($_POST['submit'])) {
        // echo "Service Report Submitted" . $NewServiceID; 
        setcookie("SRStatus", 1, time() + (86400 * 30), "/"); 
        setcookie("SRID", $NewServiceID, time() + (86400 * 30), "/"); 
        sqlsrv_free_stmt( $stmt31); 
        sqlsrv_close( $conn);
        $ServiceID = $NewServiceID;
        header("Location: /ServiceReport/root/updateservicereports.php");
        // window.location.replace("/ServiceReport/root/updateservicereports.php");
}
else{
        sqlsrv_close( $conn);
        header("Location: /ServiceReport/root/dashboard.php", true, 301);
        exit();
}
?>