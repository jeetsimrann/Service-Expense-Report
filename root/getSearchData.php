<?php
    // Server-side code to get orders based entered text

    // establish connection
    require_once('dbconnect.php');

    // get entered text from search bar 
    $searchData = $_GET['searchData'];

    // query to retireve orders
    $sqlQuery = "SELECT TOP (30) dbo.tblCustOrders.*, dbo.tblCustomers.CustomerName 
                FROM dbo.tblCustOrders LEFT JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID 
                 WHERE (OrderNo LIKE '%" .$searchData . "%' 
                 OR dbo.tblCustomers.CustomerName LIKE '%" .$searchData . "%'
                 OR dbo.tblCustOrders.Title LIKE '%" .$searchData . "%');";

    // execute query
    $result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");

    // fetching results and creating cards for orders to be displayed
    while ($row= sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
        $content = $row['OrderNo'];
?>
        <label class="post-item" style="width:100%;" id="<?php echo $row['OrderID']; ?>">
            <p class="post-title" style="margin-bottom:0!important;">
                <input type="radio" class="form-check-input me-1" name="orderno" value="<?php echo $row['OrderNo']; ?>">
                <?php echo $row['OrderNo']; ?> - 
                <span style="color:grey;important;font-size:0.8rem;">
                    <?php if($row['CustomerName']!=null){echo $row['CustomerName']; }?>
                </span>
                <div  style="color:grey;important;font-size:0.8rem;width:100%">
                    <?php if($row['Title']!=null){echo $row['Title']; } ?>
                </div>
            </p>
        </label>
<?php
    }
?>