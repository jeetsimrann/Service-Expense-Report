 <?php  
        include "dbconnect.php";

        $tsql_callSP1 = "{call sp_qryCustOrderService};";

        $stmtOrderInfo = sqlsrv_query( $conn, $tsql_callSP1) or die("Couldn't execut query");

        $onlyOrderNo = array();
        $onlyCustomerName = array(); 
        $onlyFullAddress = array();
        $onlyCurrencyID = array();
        
        $arr = array();
        while ($data1=sqlsrv_fetch_array($stmtOrderInfo , SQLSRV_FETCH_ASSOC)){
            array_push($onlyOrderNo, $data1['OrderNo']);
            array_push($onlyCustomerName, $data1['CustomerName']);
            array_push($onlyFullAddress, $data1['FullAddress']);
            array_push($onlyCurrencyID, $data1['CurrencyID']);

            // array_push($arr, array($data1['OrderNo'],$data1['CustomerName'], $data1['FullAddress'],$data1['CurrencyID']));
        } 

        $arrCustomerName1 = array_combine($onlyOrderNo, $onlyCustomerName);
        $arrFullAddress1 = array_combine($onlyOrderNo, $onlyFullAddress);
        $arrCurrencyID1 = array_combine($onlyOrderNo, $onlyCurrencyID);

        $arrCustomerName = json_encode($arrCustomerName1, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $arrFullAddress = json_encode($arrFullAddress1, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $arrCurrencyID = json_encode( $arrCurrencyID1, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // $array_test = json_decode(json_decode($cart_items));
        // print_r($onlyOrderNo);
        $arrOrderNo = json_encode($onlyOrderNo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>  