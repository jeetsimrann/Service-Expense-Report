<?php
    // Server-side code to get existing task lines for given service report

    // session started
    session_start();
    // establish connection 
    require "dbconnect.php";
    // query to retrieve task lines from tblServiceTaskLines    
    $sql = "SELECT * FROM dbo.tblServiceTaskLines WHERE ServiceID=".$_COOKIE["SRID"];
    // executing query
    $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
    // pushing data to array 
    $TaskLineArr = array();
    while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    array_push($TaskLineArr,array(
                $data['ServiceTaskLineID'],
                $data['TaskID'],
                $data['Hours'],
                $data['Notes']
            )
        );
    
    }
?>
