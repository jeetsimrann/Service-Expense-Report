<?php
    session_start();
    if($_SESSION['userLoginStatus']==0){
        echo '<script>alert("User Not Logged In!");window.location.href="../index.php"</script>';
        // header('Location:../index.php');
    }  
?>
<!DOCTYPE html>
<html>
<head>
<title>AFA Expenses</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes" />
<!-- afa icon -->
<script id='wpacu-combined-js-head-group-1' type='text/javascript' src='https://www.afasystemsinc.com/wp-content/cache/asset-cleanup/js/head-5e3e4d2c92fdd7fbfd909d433c07b6d9193b10e1.js'></script><link rel="https://api.w.org/" href="https://www.afasystemsinc.com/wp-json/" /><link rel="alternate" type="application/json" href="https://www.afasystemsinc.com/wp-json/wp/v2/pages/11" /><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /><meta name="google-site-verification" content="U_fWjqoTqoM87P1nyU91rpuLqqR0v2Yq6ZxPgKTOHF8"><link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-32x32.png" sizes="32x32" />
<link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-192x192.png" sizes="192x192" />
<link rel="apple-touch-icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-180x180.png" />
<meta name="msapplication-TileImage" content="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-270x270.png" />

 <link rel="stylesheet" href="..\assets\css\style.css"/>
 <!-- Google Fonts -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700"/>


 <!-- Datatables -->
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/r-2.2.9/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.css"/>
 <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/dt-1.11.5/r-2.2.9/sc-2.0.5/sb-1.3.2/sp-2.0.0/datatables.min.js"></script>
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

 <!-- Bootstrap CDN -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

 <!-- Bootstrap CDN -->
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
 <script type="text/javascript" charset="utf-8" src="../assets/vendor/js.cookie.js"></script>

</head>

<body>

<?php require 'sp_newSR.php'; ?>
<?php require 'sp_qryCustOrderService.php'; ?>
<?php require 'googleapikey.php'; ?>

<header class="header-transparent" id="header">
			<nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-bottom:2px solid #0000001a">
				<div class="container-fluid justify-content-end">
					<!-- <a href="../index.php" class="navbar-brand m-1">
						<img src="../assets/img/logo.png" height="55" alt="AFA Systems">
					</a> -->

                    <a href="../logout.php">
                       <input type="submit" name="logout" id="logout" value="Logout" class="btn btn-primary" style="margin-right:0.5rem;">
                    </a>
				</div>
			</nav>
</header><!-- End Header -->

<div class="submitmain">

<form id="fupForm" method="post" action="sp_tblService_SaveItem.php" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="EmployeeID" name="EmployeeID" value="<?php echo $_SESSION['EmployeeID']?>"/>
            <div class="form-row row">
                        <div class="col form-group mb-3">
                            <label for="name">Service ID</label>
                            <input type="text" class="form-control" id="ServiceID" name="ServiceID" placeholder="Enter ID" readonly value="0"/>
                        </div> 
                        <div class="col form-group mb-3">
                            <label for="servicedate">Service Date</label>
                            <input type="date" class="form-control" id="servicedate" name="servicedate" placeholder="Enter Service Date" value="<?php echo $SRDate;?>"/>
                        </div>
                </div>

        <div class="form-group mb-3  ">
            <label for="orderno">Order Number</label>
            <input class="form-control" name="ordernos" data-toggle="modal" data-target="#OrderNoModal"  placeholder="Select Order Number" id="ordernos" readonly style="background-color: #ffffff;" required/>
            <div class="modal fade" id="OrderNoModal" tabindex="-1" role="dialog" aria-labelledby="OrderNoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="margin-top: 5rem;">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close" aria-label="Close" style="float:right;margin-bottom:1rem;" data-dismiss="modal"></button>
                            <input class="form-control" id="myInput" type="text" placeholder="Search..">
                            <br>
                            <div class="">


                                <div class="post-wall">
                                    <div id="post-list">
                                        <?php
                                        include "dbconnect.php";

                                        $sqlQuery = "SELECT * FROM dbo.tblCustOrders ;";
                                        $params = array();
                                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                                        $result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");
                                        $total_count = sqlsrv_num_rows( $result )  ;
                                        $sqlQuery = "SELECT TOP (10) dbo.tblCustOrders.*, dbo.tblCustomers.CustomerName FROM dbo.tblCustOrders LEFT JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID ORDER BY dbo.tblCustOrders.OrderID DESC";
                                        $result = sqlsrv_query($conn,$sqlQuery, $params, $options) or die("Couldn't execut query");
                                        ?>
                                        <input type="hidden" name="total_count" id="total_count"
                                        value="<?php echo $total_count; ?>" />

                                        <?php
                                        while ($row=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
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
                                        <!-- <label class="post-item" style="width:100%;" id="<?php echo $row['OrderID']; ?>">
                                            <p class="post-title">
                                                <input type="radio" class="form-check-input me-1" name="orderno" value="<?php echo $row['OrderNo']; ?>">
                                                <?php 
                                                    // echo $row['OrderNo']; 
                                                ?>
                                                <span style="color:grey;font-weight:light;font-size:0.8rem;">
                                                <?php 
                                                    // echo " ".$row['CustomerName'];
                                                ?>
                                                </span>
                                            </p>
                                        </label> -->
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="post-list2" >
                                        <p>Hello</p>
                                    </div>
                                    <div class="ajax-loader text-center">
                                        <img src="LoaderIcon.gif"> Loading more orders...
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Select</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group mb-3  ">
            <label for="travelfrom">Travel From</label>
            <input type="text" class="form-control" id="travelfrom" name="travelfrom" placeholder="Enter Travel From" value="<?php echo $TravelFrom;?>"   />
        </div>
        <div class="form-group mb-3  ">
            <label for="travelto">Travel To</label>
            <input type="text" class="form-control" id="travelto" name="travelto" placeholder="Enter Travel To"   />
            <a href="#" id="mapurl" data-toggle="modal" data-target="#myModal" style="float: right;">Show Directions</a>
        </div>

        <!-- google map link -->

            <!-- The Modal -->
            <div class="modal" id="myModal">
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
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
                </div>  
            </div>


        <div class="form-group mb-3  ">
            <label for="Customer">Customer</label>
            <input type="text" class="form-control" id="Customer" name="Customer" placeholder="Enter Customer"  />
        </div>
        <!-- <div class="form-group mb-3 inputfield">
            <label for="file">Scan Receipt</label>
            <input type="file" class="form-control" id="file" name="file" />
        </div> -->

        <div class="form-row row">
            <div class="col mb-3">
                <label for="kmTraveled">Km Traveled</label>
                <input type=number min="0" inputmode="decimal" pattern="[0-9]*" ng-model="vm.decimalNumbers" class="form-control" id="kmTraveled" name="kmTraveled" placeholder="Enter Km Traveled" />
            </div>
            <div class="col mb-3">
                <label for="MileageAllowance">Mileage Allowance</label>
                <input type="text" class="form-control" id="MileageAllowance" name="MileageAllowance" placeholder="" readonly value="<?php echo $MileageAllowance;?>" />
            </div>
        </div>


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


        <!-- collapse form for expense line, hours and file attachment -->

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
            <!-- <div class="card mb-2 disabled" data-bs-toggle="tooltip" title="Save And Continue to add File Attachment" style="cursor: not-allowed;">
                <div class="card-header btn btn-link collapsed expandform" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="text-align: left; text-underline-offset:  1px; padding-bottom: 0.9rem;cursor: not-allowed;">
                        File Atachment
                </div>
            </div> -->
        <!-- collapse form ended -->

        <div class="formbutton mt-3">
            <input type="submit" name="exit" class="btn btn-primary submitBtn" value="Save & Exit" style="height:2.6rem;margin-right: 10px;"/>
            <input type="submit" name="submit" class="btn btn-primary submitBtn" value="Save & Continue" style="height:2.6rem"/>
        </div>
        <div id="alert_message" class="mt-2"></div>
</form>
</div>

</body>
</html>

<script type="text/javascript">

$(document).ready(function(){
        windowOnScroll();
});

function windowOnScroll() {
    // if($("#myInput").val() != ""){
            $(".post-wall").on("scroll", function(e){
                // if ($(".post-wall").scrollTop() ==$(document).height() - $(window).height()){
                    if ($(".post-wall")[0].scrollHeight - $(".post-wall").scrollTop() <= $(".post-wall").outerHeight()){
                        if($(".post-item").length < $("#total_count").val()) {
                            var lastId = $(".post-item:last").attr("id");
                            getMoreData(lastId);
                        }
                // }
                    }
            });
    // }
}

function getMoreData(lastId) {
       $(".post-wall").off("scroll");
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
        	   }, 200);
        }
   });
}
</script>




<!-- <script>
    
    var arrON  = <?php echo $arrOrderNo;?>;
    var start = new Date(); 
    $.each(arrON, function(index, value) {
        $('.list-group').append(`
                    <label class="list-group-item" style="width:100%;border-top-width:1px;margin-bottom:-0.2rem;">
                    <input type="radio" class="form-check-input me-1" name="orderno" value="`+value+`">
                         `+value+`
                    </label>
        `);
    }); 

    var end = new Date();
    var duration = (end - start)/1000;
    console.log(duration);
</script> -->

<script>
$(document).ready(function(){
    $('[data-bs-toggle="tooltip"]').tooltip()
});
</script>



<script type="text/javascript">
$(document).ready(function(){
    $("#post-list2").hide();
    filterList();
});

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


<!-- <script>
        $(document).ready(function(){
          $("#myInput").on("keyup", function() {
            // var value = $(this).val().toLowerCase();
            var value = $("input[type='radio'][name='orderno']:checked").val().toLowerCase();
            $("#post-list .post-item").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
</script> -->

<script>
    $(document).ready(function(){
        var passedArray = <?php echo $arrCustomerName; ?>;
        var passedArray2 = <?php echo $arrFullAddress; ?>;
        // $("input:radio").change(function() {
        $('body').on('change', 'input[name="orderno"]', () => {   
            // var result =  $(this).val();
            var result = $("input[type='radio'][name='orderno']:checked").val();
            $("#ordernos").val(result);
            $("#Customer").attr("value", passedArray[result]);
            $("#travelto").attr("value", passedArray2[result]);
            
            var from = '8 Tilbury Ct, Brampton, ON L6T 3T4'; 
            var to = passedArray2[result];
            $.ajax({
                    type: "GET", //we are using GET method to get data from server side
                    url: 'getDistance.php', // get the route value
                    data: {from : from, to : to}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                        
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
                        $("#kmTraveled").attr("value", response);
                    }
            });
        });

        $("#travelfrom").focus(function() {
            // console.log('in');
        }).blur(function() {
            // console.log('out');
            var from = $("#travelfrom").val(); 
            var to = $("#travelto").val();
            $.ajax({
                    type: "GET", //we are using GET method to get data from server side
                    url: 'getDistance.php', // get the route value
                    data: {from : from, to : to}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
                        $("#kmTraveled").attr("value", response);
                    }
            });
        });

        $("#travelto").focus(function() {
            // console.log('in');
        }).blur(function() {
            // console.log('out');
            var from = $("#travelfrom").val(); 
            var to = $("#travelto").val();
            $.ajax({
                    type: "GET", //we are using GET method to get data from server side
                    url: 'getDistance.php', // get the route value
                    data: {from : from, to : to}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
                        $("#kmTraveled").attr("value", response);
                    }
            });
        });


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