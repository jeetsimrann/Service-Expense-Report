<?php
require_once('dbconnect.php');

$lastId = $_GET['lastId'];
$sqlQuery = "SELECT TOP (7) dbo.tblCustOrders.*, dbo.tblCustomers.CustomerName FROM dbo.tblCustOrders LEFT JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID WHERE dbo.tblCustOrders.OrderID < '" .$lastId . "' ORDER BY dbo.tblCustOrders.OrderID DESC";
$result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");



// $sqlQuery = "SELECT * FROM tbl_posts WHERE id < '" .$lastId . "' ORDER BY id DESC LIMIT 7";

// $result = mysqli_query($conn, $sqlQuery);

while ($row= sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    $content = $row['OrderNo'];
// while ($row = mysqli_fetch_assoc($result))
//  {
    // $content = substr($row['content'],0,100);
    ?>
    <div class="post-item" id="<?php echo $row['OrderID']; ?>">
        <p class="post-title">
            <input type="radio" class="form-check-input me-1" name="orderno" value="<?php echo $row['OrderNo']; ?>">
            <?php echo $row['OrderNo']; ?>
            <span style="color:grey;font-weight:light;font-size:0.8rem;">
                <?php echo $row['CustomerName']; ?>
            </span>
        </p>
    </div>
    <?php
}
?>