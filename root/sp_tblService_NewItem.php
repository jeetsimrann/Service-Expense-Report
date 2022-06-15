<?php  
        include "getSRDetails.php";
?>        
<?php  
        include "dbconnect.php";
        date_default_timezone_set('America/New_York');

        // Add Service Line
        $tsql1 = "SELECT OrderID FROM dbo.tblCustOrders where OrderNo = ?";
        $getName1 = sqlsrv_query($conn, $tsql1, array($_POST['ordernos']));
        if( $getName1 === false )  
                die( FormatErrors( sqlsrv_errors() ) );  
        if ( sqlsrv_fetch( $getName1 ) === false )  
                die( FormatErrors( sqlsrv_errors() ) ); 
        
        $input_OrderID = sqlsrv_get_field( $getName1, 0); 
        $today = date("Y-m-d H:i:s");
        $input_ServiceID = $_POST['ServiceID'];
        $input_ServiceDate = $_POST["servicedate"]." ".date("H:i:s");
        $input_TravelFrom = $_POST['travelfrom'];
        $input_TravelTo = $_POST['travelto'];
        $input_MileageAllowance = $_POST['MileageAllowance'];
        $input_MileageAllowanceBillable = $_POST['MileageAllowanceBillable'];
        $input_kmTraveled = $_POST['kmTraveled'];
        $input_USExchange = $_POST['USExchange'];
        $responseMessage = "Success"; 
        $NewServiceID = 1;  

        $sql_ServiceLine = "{call sp_tblService_SaveItem(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)};";
       
        $params_ServiceLine = array();

        array_push($params_ServiceLine,array($input_ServiceID, SQLSRV_PARAM_IN),
                            array($EmployeeID, SQLSRV_PARAM_IN), 
                            array($input_ServiceDate, SQLSRV_PARAM_IN),
                            array($input_TravelFrom, SQLSRV_PARAM_IN),
                            array($input_TravelTo, SQLSRV_PARAM_IN),
                            array($input_OrderID, SQLSRV_PARAM_IN),
                            array($input_MileageAllowance, SQLSRV_PARAM_IN),
                            array($input_MileageAllowanceBillable, SQLSRV_PARAM_IN),
                            array($input_kmTraveled, SQLSRV_PARAM_IN),
                            array($input_USExchange, SQLSRV_PARAM_IN),
                            array($MileageBillable , SQLSRV_PARAM_IN),
                            array($Processed, SQLSRV_PARAM_IN),
                            array($ProcessedDate, SQLSRV_PARAM_IN),
                            array($Submitted, SQLSRV_PARAM_IN),
                            array($SubmittedDate, SQLSRV_PARAM_IN),
                            array($Reviewed, SQLSRV_PARAM_IN),
                            array($ReviewedDate, SQLSRV_PARAM_IN),
                            array($ReviewedBy, SQLSRV_PARAM_IN),
                            array($Notes, SQLSRV_PARAM_IN),
                            array(&$responseMessage, SQLSRV_PARAM_INOUT),
                            array(&$NewServiceID, SQLSRV_PARAM_INOUT));

        $stmt_ServiceLine = sqlsrv_query( $conn, $sql_ServiceLine, $params_ServiceLine);  
        if( $stmt_ServiceLine === false )  
        {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        sqlsrv_next_result($stmt_ServiceLine); 
        sqlsrv_free_stmt( $stmt_ServiceLine); 


        // Add Expense Line

        $input_expID = $_POST['expID'];             
        $input_exptype = $_POST['exptype'];
        $input_expamount = $_POST["expamount"];
        $input_expcurr = $_POST['expcurr'];
        $input_check1 = $_POST['check1'];
        $input_check2 = $_POST['check2'];
        $input_check3 = $_POST['check3'];
        $input_expnotes = &$_POST['expnotes'];

        $input_markuppercent = array();
        foreach ($input_exptype as &$value) {
            $sql = "SELECT MarkupPercent FROM dbo.tblServiceExpenses where ExpenseID ='".$value."'";
                            
	        $stmt = sqlsrv_query( $conn, $sql);
	        if( $stmt === false ) {
	        	die( print_r( sqlsrv_errors(), true));
	        }

	        // Make the first (and in this case, only) row of the result set available for reading.
	        if( sqlsrv_fetch( $stmt ) === false) {
	        	die( print_r( sqlsrv_errors(), true));
	        }

	        // Get the row fields. Field indices start at 0 and must be retrieved in order.
	        // Retrieving row fields by name is not supported by sqlsrv_get_field.
	        $mp = sqlsrv_get_field( $stmt, 0);
	        array_push($input_markuppercent,$mp);
        }

        $sql_ExpenseLine = "";  
        $params_ExpenseLine = array();     
        for($index = 0 ; $index < count($input_exptype); $index ++){
                // if($input_expID[$index] != 0){
                     $sql_ExpenseLine .= "UPDATE tblServiceExpenseLines 
                                          SET ExpenseID = (?),
                                              Amount = (?),
                                              CurrencyID = (?),
                                              AFACreditCard = (?),
                                              Receipt = (?),
                                              Notes = (?),
                                              Billable = (?),
                                              MarkupPercent = (?)
                                          WHERE ServiceExpenseLineID ='".$input_expID[$index]."';";
                // }
                // else{
                //         $tsql_callSP1 .= "{call sp_InserttblServiceExpenseLines(?,?,?,?,?,?,?,?,?)};";
                // }
            }

        for($index = 0 ; $index < count($input_exptype); $index ++){
        //     if($input_expID[$index] != 0){
                array_push($params_ExpenseLine,$input_exptype[$index],
                                     $input_expamount[$index],
                                     $input_expcurr[$index],
                                     $input_check1[$index],
                                     $input_check2[$index],
                                     $input_expnotes[$index],
                                     $input_check3[$index],
                                     $input_markuppercent[$index]
                                     );
        //     }
        //     else{
        //         array_push($params11,array($ServiceID, SQLSRV_PARAM_IN),
        //                                 array($input_exptype[$index], SQLSRV_PARAM_IN), 
        //                                 array($input_expamount[$index], SQLSRV_PARAM_IN),
        //                                 array($input_expcurr[$index], SQLSRV_PARAM_IN),
        //                                 array($input_check1[$index], SQLSRV_PARAM_IN),
        //                                 array($input_check2[$index], SQLSRV_PARAM_IN),
        //                                 array($input_markuppercent[$index], SQLSRV_PARAM_IN),
        //                                 array($input_check3[$index], SQLSRV_PARAM_IN),
        //                                 array($input_expnotes[$index], SQLSRV_PARAM_IN));
        //     }
        }

        $stmt_ExpenseLine = sqlsrv_query( $conn, $sql_ExpenseLine, $params_ExpenseLine);  
        if( $stmt_ExpenseLine === false )  
        {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        sqlsrv_next_result($stmt_ExpenseLine); 
        sqlsrv_free_stmt( $stmt_ExpenseLine); 


        // Add Task Line
        $input_taskID = $_POST['taskID']; 
        $input_tasktype = $_POST['tasktype'];
        $input_taskhours = $_POST['taskhours'];
        $input_tasknotes = $_POST['tasknotes'];

        $sql_TaskLine = "";
        $params_TaskLine = array(); 
        for($index = 0 ; $index < count($input_tasktype); $index ++){
                if($input_taskID[$index] != 0){
                        $sql_TaskLine .= "UPDATE tblServiceTaskLines 
                                          SET TaskID = (?),
                                              Hours = (?),
                                              Notes = (?)
                                          WHERE ServiceTaskLineID ='".$input_taskID[$index]."';";
                }
                else{
                        $sql_TaskLine .= "{call sp_InserttblServiceTaskLines(?,?,?,?)};";
                }
        }

        for($index = 0 ; $index < count($input_tasktype); $index ++){
                if($input_taskID[$index] != 0){
                        array_push($params_TaskLine,$input_tasktype[$index],
                                             $input_taskhours[$index],
                                             $input_tasknotes[$index]
                                             );
                }
                else{
                        array_push($params_TaskLine,array($input_ServiceID, SQLSRV_PARAM_IN),
                                    array($input_tasktype[$index], SQLSRV_PARAM_IN), 
                                    array($input_taskhours[$index], SQLSRV_PARAM_IN),
                                    array($input_tasknotes[$index], SQLSRV_PARAM_IN));
                }
        }

        $stmt_TaskLine = sqlsrv_query( $conn, $sql_TaskLine, $params_TaskLine);  
        if( $stmt_TaskLine === false )  
        {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        sqlsrv_next_result($stmt_TaskLine); 
        sqlsrv_free_stmt( $stmt_TaskLine);



        // $uploaddir = '../uploads/expenselines/';
        // // $uploadfile = $uploaddir . basename("$_FILES['userfile']['name']");
        // $temp = explode(".", $_FILES["di"]["name"]);
        // $newfilename = $uploaddir .round(microtime(true)) . '.' . end($temp);
        // echo "<p>";

        // if (move_uploaded_file($_FILES['di']['tmp_name'], $newfilename)) {
        // echo "File is valid, and was successfully uploaded.\n";
        // } else {
        // echo "Upload failed";
        // }
        // echo "</p>";
        // echo '<pre>';
        // echo 'Here is some more debugging info:';
        // print_r($_FILES);
        // print "</pre>";

        $uploaddir = '../../ExpenseLineFiles/';
        $files = array_filter($_FILES['file']['name']);

        for( $i=0 ; $i < count($input_exptype) ; $i++ ) {
                //The temp file path is obtained
                $tmpFilePath = $_FILES['file']['tmp_name'][$i];
                //A file path needs to be present
                if ($tmpFilePath != ""){
                   //Setup our new file path
                   $temp = explode(".", $_FILES["file"]["name"][$i]);
                   $newFilePath = $uploaddir. $input_expID[$i]. '.jpg' ;
                   //File is uploaded to temp dir
                   echo "<p>";
                   if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        echo "File is valid, and was successfully uploaded.\n";
                        } else {
                        echo "Upload failed";
                   }
                   echo "</p>";
                   echo '<pre>';
                   echo 'Here is some more debugging info:';
                   print_r($_FILES);
                   print "</pre>";
                }
        } 

        if (isset($_POST['submit'])) {
                $sql_submit = "UPDATE tblService SET Submitted = (?) WHERE ServiceID ='".$input_ServiceID."';";
                $params_submit = array(1); 
                $stmt_submit = sqlsrv_query( $conn, $sql_submit, $params_submit);  
                if( $stmt_submit === false ){  
                echo "Error in executing statement 3.\n";  
                 die( print_r( sqlsrv_errors(), true));  
                }  
                sqlsrv_next_result($stmt_submit); 
                sqlsrv_free_stmt( $stmt_submit);
                sqlsrv_close( $conn);
                header("Location: /ServiceReport/root/dashboard.php", true, 301);
                exit();
        }
        else{
                sqlsrv_close( $conn);
                header("Location: /ServiceReport/root/dashboard.php", true, 301);
                exit();
        }
?>  