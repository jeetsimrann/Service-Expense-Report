<!DOCTYPE html>
<html>
<head>
<title>How to Create Facebook Like Infinite Scroll Pagination using PHP
    and jQuery</title>
    <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<style type="text/css">
body {
    font-family: Arial;
    background: #e9ebee;
    font-size: 0.9em;
}

.post-wall {
    background: #FFF;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 5px;
    margin: 0 auto;
    width: 500px;
}

.post-item {
    padding: 10px;
    border: #f3f3f3 1px solid;
    border-radius: 5px;
    margin-bottom: 30px;
}

.post-title {
    color: #4faae6;
}

.ajax-loader {
    display: block;
    text-align: center;
}
.ajax-loader img {
    width: 50px;
    vertical-align: middle;
}
</style>
</head>
<body>

    <div class="post-wall">
            <div id="post-list">
                <?php
                include "dbconnect.php";

                $sqlQuery = "SELECT * FROM dbo.tblCustOrders ;";
                $params = array();
                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                $result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");
                $total_count = sqlsrv_num_rows( $result )  ;
                $sqlQuery = "SELECT TOP (7) dbo.tblCustOrders.*, dbo.tblCustomers.CustomerName FROM dbo.tblCustOrders LEFT JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID ORDER BY dbo.tblCustOrders.OrderID DESC";
                $result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");
                ?>
                <input type="hidden" name="total_count" id="total_count"
                value="<?php echo $total_count; ?>" />

                <?php
                while ($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                        $content = $row['OrderNo'];
                    ?>
                <div class="post-item" id="<?php echo $row['OrderID']; ?>">
                    <p class="post-title">
                        <input type="radio" class="form-check-input me-1" name="orderno" value="<?php echo $row['OrderNo']; ?>">
                        <?php echo $row['OrderNo']; ?>
                        <span style="color:grey;font-weight:light;font-size:0.8rem;">
                            <?php echo " ".$row['CustomerName']; ?>
                        </span>
                    </p>
                    
                </div>
                <?php
                }
                ?>
            </div>
            <div class="ajax-loader text-center">
                <img src="LoaderIcon.gif"> Loading more orders...
            </div>
    </div>
    
<script type="text/javascript">
$(document).ready(function(){
        windowOnScroll();
});
function windowOnScroll() {
       $(window).on("scroll", function(e){
        if ($(window).scrollTop() == $(document).height() - $(window).height()){
            if($(".post-item").length < $("#total_count").val()) {
                var lastId = $(".post-item:last").attr("id");
                getMoreData(lastId);
            }
        }
    });
}

function getMoreData(lastId) {
       $(window).off("scroll");
    $.ajax({
        url: 'getMoreData.php?lastId=' + lastId,
        type: "get",
        beforeSend: function ()
        {
            $('.ajax-loader').show();
        },
        success: function (data) {
        	   setTimeout(function() {
                $('.ajax-loader').hide();
            $("#post-list").append(data);
            windowOnScroll();
        	   }, 1000);
        }
   });
}
</script>
</body>
</html>