<?php  
        // Server-side code to create new service report

        // establish connection
        include "dbconnect.php";
        // set timezone 
        date_default_timezone_set('America/New_York');

        // query to get orderID from selected order number 
        $tsql1 = "SELECT OrderID FROM dbo.tblCustOrders where OrderNo = ?";
        $OrderID = sqlsrv_query($conn, $tsql1, array($_POST['ordernos']));
        
        if( $OrderID === false )  
                die( FormatErrors( sqlsrv_errors() ) );  
        if ( sqlsrv_fetch( $OrderID ) === false )  
                die( FormatErrors( sqlsrv_errors() ) ); 
        
        // getting form data 
        $EmpID = $_POST['EmployeeID'];
        $input_OrderID = sqlsrv_get_field( $OrderID, 0); 
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

        // calling stored procedure sp_tblService_SaveItem
        $tsql_callSP = "{call sp_tblService_SaveItem(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)};";
        // pushing data to array 
        $params = array();
        array_push($params,array($input_ServiceID, SQLSRV_PARAM_IN),
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
                            
        // executing query
        $stmt = sqlsrv_query( $conn, $tsql_callSP, $params);  
        if( $stmt === false )  
        {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        sqlsrv_next_result($stmt);

        //if submit and continue button is clicked
        if (isset($_POST['submit'])) { 
                setcookie("SRStatus", 1, time() + (86400 * 30), "/"); 
                setcookie("SRID", $NewServiceID, time() + (86400 * 30), "/"); 
                sqlsrv_free_stmt($stmt); 
                sqlsrv_close($conn);
                $ServiceID = $NewServiceID;
                header("Location: /ServiceReport/root/updateservicereports.php");
        }
        //else if submit and exit button is clicked
        else{
                sqlsrv_close( $conn);
                header("Location: /ServiceReport/root/dashboard.php", true, 301);
                exit();
        }
?>