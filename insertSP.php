<?php  
        include "dbconnect.php";
        
        $tsql = "SELECT OrderID FROM dbo.tblCustOrders where OrderNo = ?";
        $getName = sqlsrv_query($conn, $tsql, array($_POST['ordernos']));
        if( $getName === false )  
                die( FormatErrors( sqlsrv_errors() ) );  
        if ( sqlsrv_fetch( $getName ) === false )  
                die( FormatErrors( sqlsrv_errors() ) ); 
        $name = sqlsrv_get_field( $getName, 0);  

        $input_exptype = $_POST['exptype'];
        $input_expamount = $_POST["expamount"];
        $input_expcurr = $_POST['expcurr'];
        $input_check1 = $_POST['check1'];
        $input_check2 = $_POST['check2'];
        $input_check3 = $_POST['check3'];
        $input_expnotes = &$_POST['expnotes'];

        $input_tasktype = $_POST['tasktype'];
        $input_taskhours = $_POST['taskhours'];
        $input_tasknotes = $_POST['tasknotes'];

        $tsql_callSP = "";

        for($index = 0 ; $index < count($input_exptype); $index ++){
            $tsql_callSP .= "{call sp_InserttblServiceExpenseLines(?,?,?,?,?,?,?,?,?)};";
        }

        for($index = 0 ; $index < count($input_tasktype); $index ++){
            $tsql_callSP .= "{call sp_InserttblServiceTaskLines(?,?,?,?)};";
        }

        $ServiceID = &$_POST['ServiceID'];
        $ExpenseID = &$_POST['exptype'];
        $Amount = &$_POST['expamount'];
        $CurrencyID = &$_POST['expcurr'];
        $AFACreditCard = isset($_POST['check1']) ? 1 : 0;
        $Receipt = isset($_POST['check2']) ? 1 : 0;
        $MarkupPercent = 0;
        $Billable = isset($_POST['check3']) ? 1 : 0;
        $Notes = &$_POST['expnotes'];
        $params1 = array();

        for($index = 0 ; $index < count($input_exptype); $index ++){
            array_push($params1,array($ServiceID, SQLSRV_PARAM_IN),
                                array($input_exptype[$index], SQLSRV_PARAM_IN), 
                                array($name, SQLSRV_PARAM_IN),
                                array($input_expcurr[$index], SQLSRV_PARAM_IN),
                                array($input_check1[$index], SQLSRV_PARAM_IN),
                                array($input_check2[$index], SQLSRV_PARAM_IN),
                                array($MarkupPercent, SQLSRV_PARAM_IN),
                                array($input_check3[$index], SQLSRV_PARAM_IN),
                                array($input_expnotes[$index], SQLSRV_PARAM_IN));
        }

        for($index = 0 ; $index < count($input_tasktype); $index ++){
            array_push($params1,array($ServiceID, SQLSRV_PARAM_IN),
                                array($input_tasktype[$index], SQLSRV_PARAM_IN), 
                                array($input_taskhours[$index], SQLSRV_PARAM_IN),
                                array($input_tasknotes[$index], SQLSRV_PARAM_IN));
        }

        $stmt3 = sqlsrv_query( $conn, $tsql_callSP, $params1);  
        if( $stmt3 === false )  
        {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        sqlsrv_next_result($stmt3); 
        echo "Registration Complete";  
        sqlsrv_free_stmt( $stmt3); 
        
        sqlsrv_close( $conn);
?>  