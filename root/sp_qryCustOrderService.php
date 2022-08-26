 <?php  
    // Server-side code to get customer details
    
    // establish connection 
    include "dbconnect.php";
    // calling stored procedure sp_qryCustOrderService
    $tsql_callSP1 = "{call sp_qryCustOrderService};";
            
    $stmtOrderInfo = sqlsrv_query($conn, $tsql_callSP1) or die("Couldn't execut query");
    //  initiating arrays 
    $onlyOrderNo = array();
    $onlyCustomerName = array(); 
    $onlyFullAddress = array();
    $onlyCurrencyID = array();
    // pushing data to array 
    while ($data1=sqlsrv_fetch_array($stmtOrderInfo , SQLSRV_FETCH_ASSOC)){
        array_push($onlyOrderNo, $data1['OrderNo']);
        array_push($onlyCustomerName, $data1['CustomerName']);
        array_push($onlyFullAddress, $data1['FullAddress']);
        array_push($onlyCurrencyID, $data1['CurrencyID']);
    } 
    // combining customer name, full address and currency array seperately with order number
    $combineCustomerName = array_combine($onlyOrderNo, $onlyCustomerName);
    $combineFullAddress = array_combine($onlyOrderNo, $onlyFullAddress);
    $combineCurrencyID = array_combine($onlyOrderNo, $onlyCurrencyID);
    
    // converting arrays to json format
    $arrCustomerName = json_encode($combineCustomerName, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $arrFullAddress = json_encode($combineFullAddress, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $arrCurrencyID = json_encode($combineCurrencyID, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $arrOrderNo = json_encode($onlyOrderNo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>  