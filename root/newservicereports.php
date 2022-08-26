<!-- creates new Service Report  -->
<?php
    // redirect to login page if user not logged in 
    session_start();
    if($_SESSION['userLoginStatus']==0){
        echo '<script>alert("User Not Logged In!");window.location.href="../index.php"</script>';
    }  
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
    <title>AFA Expenses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- afa icon -->
    <script id='wpacu-combined-js-head-group-1' type='text/javascript' src='https://www.afasystemsinc.com/wp-content/cache/asset-cleanup/js/head-5e3e4d2c92fdd7fbfd909d433c07b6d9193b10e1.js'></script><link rel="https://api.w.org/" href="https://www.afasystemsinc.com/wp-json/" /><link rel="alternate" type="application/json" href="https://www.afasystemsinc.com/wp-json/wp/v2/pages/11" /><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /><meta name="google-site-verification" content="U_fWjqoTqoM87P1nyU91rpuLqqR0v2Yq6ZxPgKTOHF8"><link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-180x180.png" />
    <meta name="msapplication-TileImage" content="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-270x270.png" />
    <!-- css file  -->
    <link rel="stylesheet" href="..\assets\css\style.css"/>
    <!-- font family  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700"/>
    <!-- datatables CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/r-2.2.9/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/r-2.2.9/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="../assets/vendor/js.cookie.js"></script>
</head>

<body>
    <!-- import data from server side files -->
    <?php require 'sp_newSR.php'; ?>
    <?php require 'sp_qryCustOrderService.php'; ?>
    <?php require 'googleapikey.php'; ?>

    <!-- header -->
    <header class="header-transparent" id="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-bottom:2px solid #0000001a">
            <div class="container-fluid justify-content-end">
                <a href="../logout.php">
                <input type="submit" name="logout" id="logout" value="Logout" class="btn btn-primary" style="margin-right:0.5rem;">
                </a>
            </div>
        </nav>
    </header>

    <!-- main form container  -->
    <div class="submitmain">
        <!-- new service report form  -->
        <form id="fupForm" method="post" action="sp_tblService_SaveItem.php" autocomplete="off" enctype="multipart/form-data">
            <!-- hidden field containing employeeID  -->
            <input type="hidden" class="form-control" id="EmployeeID" name="EmployeeID" value="<?php echo $_SESSION['EmployeeID']?>"/>
            <div class="form-row row">
                <!-- serviceID field value = 0 indicates to generate new serviceID on submit  -->
                <div class="col form-group mb-3">
                    <label for="name">Service ID</label>
                    <input type="text" class="form-control" id="ServiceID" name="ServiceID" placeholder="Enter ID" readonly value="0"/>
                </div> 
                <!-- servicedate field, by default value = today's date  -->
                <div class="col form-group mb-3">
                    <label for="servicedate">Service Date</label>
                    <input type="date" class="form-control" id="servicedate" name="servicedate" placeholder="Enter Service Date" value="<?php echo $SRDate;?>"/>
                </div>
            </div>
            <!-- order number field with order list fetched from database -->
            <div class="form-group mb-3  ">
                <label for="orderno">Order Number</label>
                <!-- input field containing order number also targets modal $OrderNoModal  -->
                <input class="form-control" name="ordernos" data-toggle="modal" data-target="#OrderNoModal"  placeholder="Select Order Number" id="ordernos" readonly style="background-color: #ffffff;" required/>
                <!-- modal $OrderNoModal containing list of orders  -->
                <div class="modal fade" id="OrderNoModal" tabindex="-1" role="dialog" aria-labelledby="OrderNoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="margin-top: 5rem;">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="btn-close" aria-label="Close" style="float:right;margin-bottom:1rem;" data-dismiss="modal"></button>
                                <!-- search bar to filter orders  -->
                                <input class="form-control" id="myInput" type="text" placeholder="Search..">
                                <br>
                                <div class="">
                                    <!-- container to display order list with infintie scroll  -->
                                    <div class="post-wall">
                                        <div id="post-list">
                                            <!-- php script to fetch order list  -->
                                            <?php
                                                // connect established 
                                                include "dbconnect.php";
                                                // sql query
                                                $sqlQuery = "SELECT * FROM dbo.tblCustOrders ;";
                                                $params = array();
                                                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                                                $result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");
                                                $total_count = sqlsrv_num_rows( $result )  ;
                                                $sqlQuery = "SELECT TOP (10) dbo.tblCustOrders.*, dbo.tblCustomers.CustomerName FROM dbo.tblCustOrders LEFT JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID ORDER BY dbo.tblCustOrders.OrderID DESC";
                                                $result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");
                                            ?>
                                            <!-- hidden field containing total number of rows -->
                                            <input type="hidden" name="total_count" id="total_count" value="<?php echo $total_count; ?>" />

                                            <!-- loop itterating through order lists  -->
                                            <?php
                                                while ($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                                                    $content = $row['OrderNo'];
                                            ?>
                                                <!-- label cards with containing order information -->
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
                                        </div>
                                        <div id="post-list2" >
                                            <p>Hello</p>
                                        </div>
                                        <!-- icon before rendering order lists  -->
                                        <div class="ajax-loader text-center">
                                            <img src="LoaderIcon.gif"> Loading more orders...
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- submit button for order list modal  -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Select</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- from and to addresses fields  -->
            <div class="form-group mb-3  ">
                <label for="travelfrom">Travel From</label>
                <input type="text" class="form-control" id="travelfrom" name="travelfrom" placeholder="Enter Travel From" value="<?php echo $TravelFrom;?>"   />
            </div>
            <div class="form-group mb-3  ">
                <label for="travelto">Travel To</label>
                <input type="text" class="form-control" id="travelto" name="travelto" placeholder="Enter Travel To"   />
                <!-- directions between from and to addresses, targets #directionsModal -->
                <a href="#" id="mapurl" data-toggle="modal" data-target="#directionsModal" style="float: right;">Show Directions</a>
            </div>

            <!-- directions link generated via google API-->
            <div class="modal" id="directionsModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <iframe
                                id="mapframe"
                                width="100%"
                                height="500"
                                style="border:0"
                                loading="lazy" $string = ;
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps/embed/v1/directions?key= <?php echo $api_key;?>
                                    &origin= <?php echo preg_replace('/\s+/', '+', $TravelFrom);?> 
                                    &destination=<?php echo preg_replace('/\s+/', '+', $TravelTo);?>">
                            </iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>  
            </div>

            <!-- Customer field, automatically fetched from DB based upon order selection  -->
            <div class="form-group mb-3  ">
                <label for="Customer">Customer</label>
                <input type="text" class="form-control" id="Customer" name="Customer" placeholder="Enter Customer"  />
            </div>

            <!-- kilometers traveled, automatically generated via google API based on from and to addresses  -->
            <div class="form-row row">
                <div class="col mb-3">
                    <label for="kmTraveled">Km Traveled</label>
                    <input type=number min="0" inputmode="decimal" pattern="[0-9]*" ng-model="vm.decimalNumbers" class="form-control" id="kmTraveled" name="kmTraveled" placeholder="Enter Km Traveled" />
                </div>
                <!-- field for mileage allowance  -->
                <div class="col mb-3">
                    <label for="MileageAllowance">Mileage Allowance</label>
                    <input type="text" class="form-control" id="MileageAllowance" name="MileageAllowance" placeholder="" readonly value="<?php echo $MileageAllowance;?>" />
                </div>
            </div>

            <!-- currently display:none, fields for mileage billable and US exchange -->
            <div class="form-row row" style="display:none;">
                <div class="col mb-3">
                    <label for="MileageAllowanceBillable">Mileage Billable</label>
                    <input type="text" class="form-control" id="MileageAllowanceBillable" name="MileageAllowanceBillable" placeholder="" readonly value="<?php echo $MileageAllowanceBillable;?>" />
                </div>
                <div class="col mb-3">
                    <label for="USExchange">US Exchange</label>
                    <input type="text" class="form-control" id="USExchange" name="USExchange" placeholder="" readonly value="<?php echo $USExchange;?>" />
                </div>
            </div>


            <!-- collapsable form for expense and task lines -->
                <div class="card mb-2 disabled" data-bs-toggle="tooltip" title="Save And Continue to add Expense Lines" style="cursor: not-allowed;">
                    <div class="card-header btn btn-link collapsed expandform " id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="text-align: left; text-underline-offset:  1px; padding-bottom: 0.9rem;cursor: not-allowed;">
                            Expenses
                    </div>
                </div>
                <div class="card mb-2 disabled" data-bs-toggle="tooltip" title="Save And Continue to add Task Lines" style="cursor: not-allowed;">
                    <div class="card-header btn btn-link collapsed expandform" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-align: left; text-underline-offset:  1px; padding-bottom: 0.9rem;cursor: not-allowed;">
                                Hours
                    </div>
                </div>

            <!-- form submit button  -->
            <div class="formbutton mt-3">
                <!-- save and exit button will redirect to dashboard.php -->
                <input type="submit" name="exit" class="btn btn-primary submitBtn" value="Save & Exit" style="height:2.6rem;margin-right: 10px;"/>
                <!-- save and continue button redirect to updateservicereport.php to update expense and task lines -->
                <input type="submit" name="submit" class="btn btn-primary submitBtn" value="Save & Continue" style="height:2.6rem"/>
            </div>
            <!-- field to throw errors  -->
            <div id="alert_message" class="mt-2"></div>
        </form>
    </div>
</body>
</html>

<!-- JS begins -->

<!-- gets order lists using ajax call  -->
<script type="text/javascript">
    // calling windowOnScroll function when page loads 
    $(document).ready(function(){
            windowOnScroll();
    });

    // function keeps track of scroll bar, function getMoreData executes if scroll reaches end
    function windowOnScroll() {
        $(".post-wall").on("scroll", function(e){
                if ($(".post-wall")[0].scrollHeight - $(".post-wall").scrollTop() <= $(".post-wall").outerHeight()){
                    if($(".post-item").length < $("#total_count").val()) {
                        var lastId = $(".post-item:last").attr("id");
                        getMoreData(lastId);
                    }
                }
        });
    }
    // function returns 10 orders when called
    function getMoreData(lastId) {
        $(".post-wall").off("scroll");
        $.ajax({
            url: 'getMoreData.php?lastId=' + lastId,
            type: "get",
            beforeSend: function (){
                $('.ajax-loader').show();
            },
            success: function (data) {
                setTimeout(function() {
                    $('.ajax-loader').hide();
                    $("#post-list").append(data);
                    windowOnScroll();
                }, 200);
            }
    });
    }
</script>

<script>
    // initiating tooltips for submit buttons when page loads 
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>

<script type="text/javascript">
    // calling filterList function when page loads 
    $(document).ready(function(){
        $("#post-list2").hide();
        filterList();
    });
    // funtcion displays the filtered list for orders
    function filterList() {
        $("#myInput").on("keyup", function() {
            $("#post-list2").empty();
            if($("#myInput").val() == ""){
                $("#post-list").show();
                $("#post-list2").hide();
            }
            else{
                $("#post-list").hide();
                $("#post-list2").show();
                var searchData = $("#myInput").val();
                getSearchData(searchData);
            }
        });
    };

    // function returns the orders based on entered text  
    function getSearchData(searchData) {
       $(".post-wall").off("scroll");
        $.ajax({
            url: 'getSearchData.php?searchData=' + searchData,
            type: "get",
            beforeSend: function ()
            {
                $('.ajax-loader').show();
            },
            success: function (data) {
                    $('.ajax-loader').hide();
                    $("#post-list2").append(data);
                    windowOnScroll();
            }
        });
    }
</script>

<script>
    // function fills travelfrom, travelto, customer name based on order selection
    $(document).ready(function(){
        var passedArray = <?php echo $arrCustomerName; ?>;
        var passedArray2 = <?php echo $arrFullAddress; ?>;

        $('body').on('change', 'input[name="orderno"]', () => {   
            var result = $("input[type='radio'][name='orderno']:checked").val();
            $("#ordernos").val(result);
            $("#Customer").attr("value", passedArray[result]);
            $("#travelto").attr("value", passedArray2[result]);
            
            var from = '8 Tilbury Ct, Brampton, ON L6T 3T4'; 
            var to = passedArray2[result];
            // ajax call to calculate distance between from and to addresses using googleAPI
            $.ajax({
                    type: "GET", 
                    url: 'getDistance.php', 
                    data: {from : from, to : to},
                    beforeSend: function () {},
                    success: function (response) {
                        $("#kmTraveled").attr("value", response);
                    }
            });
        });
        // function to get distance if travelfrom field is entered manually 
        $("#travelfrom").focus(function() {}).blur(function() {
            var from = $("#travelfrom").val(); 
            var to = $("#travelto").val();
            // ajax call to calculate distance between from and to addresses using googleAPI
            $.ajax({
                    type: "GET", 
                    url: 'getDistance.php',
                    data: {from : from, to : to}, 
                    beforeSend: function () {},
                    success: function (response) {
                        $("#kmTraveled").attr("value", response);
                    }
            });
        });

        // function to get distance if travelto field is entered manually 
        $("#travelto").focus(function() {}).blur(function() {
            var from = $("#travelfrom").val(); 
            var to = $("#travelto").val();
            // ajax call to calculate distance between from and to addresses using googleAPI
            $.ajax({
                    type: "GET",
                    url: 'getDistance.php',
                    data: {from : from, to : to},
                    beforeSend: function () {},
                    success: function (response) {
                        $("#kmTraveled").attr("value", response);
                    }
            });
        });

        // function generates google map link showing directions for from and to addresses
        $("#mapurl").click(function(e) {
            e.preventDefault(); //Prevent the default behaviour of <a>
            var strFrom = $("#travelfrom").val();
            strFrom = strFrom.replace(/\s+/g, '+');
            var strTo = $("#travelto").val();
            strTo = strTo.replace(/\s+/g, '+');
            var strUrl = "https://www.google.com/maps/embed/v1/directions?key="+<?php echo $api_key;?>+"&origin="+strFrom+"&destination="+strTo+"";
            $("#mapframe").attr("src", strUrl);         
        });
    });
</script>