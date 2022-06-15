<?php  
        include "dbconnect.php";

        $tsql_callSPNewSR = "{call sp_tblService_NewItem(?)};";
        $EmployeeID = 199;
        $paramsNewSR = array(array($EmployeeID, SQLSRV_PARAM_IN));

        $stmtNewSR = sqlsrv_query($conn, $tsql_callSPNewSR, $paramsNewSR); 

        if( $stmtNewSR === false ){  
            echo "Error in executing statement 3.\n";
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                    echo "code: ".$error[ 'code']."<br />";
                    echo "message: ".$error[ 'message']."<br />";
                }
            }  
            die( print_r( sqlsrv_errors(), true));  
        }  

        if( sqlsrv_fetch( $stmtNewSR ) === false){
            echo "Error in retrieving row.\n";
            die( print_r( sqlsrv_errors(), true));
        }

        $TravelFrom = sqlsrv_get_field( $stmtNewSR, 0);
        $MileageAllowance= sqlsrv_get_field( $stmtNewSR, 1);
        $MileageAllowanceBillable= sqlsrv_get_field( $stmtNewSR, 2);
        $USExchange= sqlsrv_get_field( $stmtNewSR, 3);
        $ServiceDateTime= sqlsrv_get_field( $stmtNewSR, 4, SQLSRV_PHPTYPE_STRING("UTF-8"));
        $MileageBillable= sqlsrv_get_field( $stmtNewSR, 5);
        $Processed= sqlsrv_get_field( $stmtNewSR, 6);
        $Submitted= sqlsrv_get_field( $stmtNewSR, 7);
        $Reviewed= sqlsrv_get_field( $stmtNewSR, 8);
        
        // trim the datetime to just date 
        $SRDate = explode(' ', trim($ServiceDateTime))[0];

        sqlsrv_free_stmt( $stmtNewSR);
        sqlsrv_close( $conn);
?>  