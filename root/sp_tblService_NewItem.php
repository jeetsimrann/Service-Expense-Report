<?php
        // Server-side code to update service report and to add expense and task lines

        // establish connection
        include "dbconnect.php";
        // set timezone 
        date_default_timezone_set('America/New_York');
        // get Service Report data 
        include "getSRDetails.php";
        // query to get orderID from selected order number 
        $tsql1 = "SELECT OrderID FROM dbo.tblCustOrders where OrderNo = ?";
        $getName1 = sqlsrv_query($conn, $tsql1, array($_POST['ordernos']));

        if( $getName1 === false )  
                die( FormatErrors( sqlsrv_errors() ) );  
        if ( sqlsrv_fetch( $getName1 ) === false )  
                die( FormatErrors( sqlsrv_errors() ) ); 
        
        // getting form data        
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

        // calling stored procedure sp_tblService_SaveItem
        $sql_ServiceLine = "{call sp_tblService_SaveItem(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)};";
        // pushing data to array 
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

        // executing query
        $stmt_ServiceLine = sqlsrv_query( $conn, $sql_ServiceLine, $params_ServiceLine);  
        if( $stmt_ServiceLine === false ) {  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        // free statement 
        sqlsrv_next_result($stmt_ServiceLine); 
        sqlsrv_free_stmt( $stmt_ServiceLine); 

        // getting form data for expense lines
        $input_expID = $_POST['expID'];             
        $input_exptype = $_POST['exptype'];
        $input_expamount = $_POST["expamount"];
        $input_expcurr = $_POST['expcurr'];
        $input_check1 = $_POST['check1'];
        $input_check2 = $_POST['check2'];
        $input_check3 = $_POST['check3'];
        $input_expnotes = &$_POST['expnotes'];

        // get markup percentage based on selected expense type 
        $input_markuppercent = array();
        foreach ($input_exptype as &$value) {
                $sql = "SELECT MarkupPercent FROM dbo.tblServiceExpenses where ExpenseID ='".$value."'";
	        $stmt = sqlsrv_query( $conn, $sql);
	        if( $stmt === false ) {
	        	die( print_r( sqlsrv_errors(), true));
	        }
	        if( sqlsrv_fetch( $stmt ) === false) {
	        	die( print_r( sqlsrv_errors(), true));
	        }

	        $mp = sqlsrv_get_field( $stmt, 0);
	        array_push($input_markuppercent,$mp);
        }

        // executing query
        $sql_ExpenseLine = "";  
        $params_ExpenseLine = array();     
        for($index = 0 ; $index < count($input_exptype); $index ++){
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
            }
        // pushing data to array 
        for($index = 0 ; $index < count($input_exptype); $index ++){
                array_push($params_ExpenseLine, $input_exptype[$index],
                                                $input_expamount[$index],
                                                $input_expcurr[$index],
                                                $input_check1[$index],
                                                $input_check2[$index],
                                                $input_expnotes[$index],
                                                $input_check3[$index],
                                                $input_markuppercent[$index]
                        );
        }
        // executing query
        $stmt_ExpenseLine = sqlsrv_query( $conn, $sql_ExpenseLine, $params_ExpenseLine);  
        if( $stmt_ExpenseLine === false ){  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

        // free statement 
        sqlsrv_next_result($stmt_ExpenseLine); 
        sqlsrv_free_stmt( $stmt_ExpenseLine); 


        // getting form data for task lines
        $input_taskID = $_POST['taskID']; 
        $input_tasktype = $_POST['tasktype'];
        $input_taskhours = $_POST['taskhours'];
        $input_tasknotes = $_POST['tasknotes'];

        // executing query
        $sql_TaskLine = "";
        $params_TaskLine = array(); 
        for($index = 0 ; $index < count($input_tasktype); $index ++){
                // if task line exists, update with new data 
                if($input_taskID[$index] != 0){
                        $sql_TaskLine .= "UPDATE tblServiceTaskLines 
                                          SET TaskID = (?),
                                              Hours = (?),
                                              Notes = (?)
                                          WHERE ServiceTaskLineID ='".$input_taskID[$index]."';";
                }
                // if task line does not exists, create new task line by calling stoed procedure sp_InserttblServiceTaskLines
                else{
                        $sql_TaskLine .= "{call sp_InserttblServiceTaskLines(?,?,?,?)};";
                }
        }
        // pushing data to array 
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

        // executing query
        $stmt_TaskLine = sqlsrv_query( $conn, $sql_TaskLine, $params_TaskLine);  
        if( $stmt_TaskLine === false ){  
            echo "Error in executing statement 3.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  
        // free statement 
        sqlsrv_next_result($stmt_TaskLine); 
        sqlsrv_free_stmt( $stmt_TaskLine);

        // script to upload expense receipt image to \\team\wwwroot\ExpenseLineFiles
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
                                } 
                        else {
                        echo "Upload failed";
                        }
                        echo "</p>";
                        echo '<pre>';
                        echo 'Here is some more debugging info:';
                        print_r($_FILES);
                        print "</pre>";
                }
        } 

        // if submit button is clicked, set submitted field in table tblService equals 1
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
        // if ssave and exit button is clicked, redirect to dashboard
        else{
                sqlsrv_close( $conn);
                header("Location: /ServiceReport/root/dashboard.php", true, 301);
                exit();
        }
?>  