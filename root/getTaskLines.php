<?php
session_start();
?>
<?php
        require "dbconnect.php";
        $sql = "SELECT * FROM dbo.tblServiceTaskLines
                    WHERE ServiceID=".$_COOKIE["SRID"];
        $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
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
