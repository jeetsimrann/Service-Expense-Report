<?php
session_start();
?>
<?php
        require "dbconnect.php";
        $sql = "SELECT * FROM dbo.tblServiceExpenseLines
                    WHERE ServiceID=".$_COOKIE["SRID"];
        $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
        $ExpenseLineArr = array();
        $exp_img = "";
        while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){

            foreach (glob("../../ExpenseLineFiles/".$data['ServiceExpenseLineID'].".*") as $filename) {
                if (file_exists($filename)) {
                    // echo "The file $filename exists";
                    // echo "<img src='".$filename."' style='width:100px;height:100px'>";
                    $exp_img = $filename;
                } else {
                    // echo "The file $filename does not exist";
                    $exp_img = "";
                }
            }

        array_push($ExpenseLineArr,array(
                    $data['ServiceExpenseLineID'],
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
