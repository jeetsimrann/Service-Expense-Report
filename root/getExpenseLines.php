<?php
    // Server-side code to get existing expense lines for given service report

    // session started
    session_start();
    // establish connection 
    require "dbconnect.php";
    // query to retrieve expense lines from tblServiceTaskLines  
    $sql = "SELECT * FROM dbo.tblServiceExpenseLines WHERE ServiceID=".$_COOKIE["SRID"];
    // executing query
    $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");

    // pushing data to array 
    $ExpenseLineArr = array();
    $exp_img = "";

    while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
        // iteration to check if exepense receipt image exists
        foreach (glob("../../ExpenseLineFiles/".$data['ServiceExpenseLineID'].".*") as $filename) {
            if (file_exists($filename)) {
                $exp_img = $filename;
            } else {
                $exp_img = "";
            }
        }

        array_push($ExpenseLineArr,array($data['ServiceExpenseLineID'],
                                         $data['ServiceID'],
                                         $data['ExpenseID'],
                                         round($data['Amount'], 2),
                                         $data['CurrencyID'],
                                         $data['AFACreditCard'],
                                         $data['Receipt'],
                                         $data['Notes'],
                                         $data['Billable'],
                                         $exp_img
                )
        );

        $exp_img = "";
    }
?>
