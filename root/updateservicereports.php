<!-- updates Service Report  -->
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
    <!-- lightbox CDN -->
    <link rel="stylesheet" href="..\assets\vendor\lightbox\css\lightbox.min.css">
    <script src="..\assets\vendor\lightbox\js\lightbox-plus-jquery.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="../assets/vendor/js.cookie.js"></script>
</head>

<body>
    <!-- import data from server side files -->
    <?php require 'getSRDetails.php'; ?>
    <?php require 'getExpenseLines.php'; ?>
    <?php require 'getTaskLines.php'; ?>
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
        <!-- service report form  -->
        <form id="fupForm" name="fupForm" method="post" action="sp_tblService_NewItem.php"  onsubmit="return validateForm()" autocomplete="off" enctype="multipart/form-data">
            <div class="form-row row">
                <!-- serviceID field -->
                <div class="col form-group mb-3">
                    <label for="name">Service ID</label>
                    <input type="text" class="form-control" id="ServiceID" name="ServiceID" placeholder="Enter ID" readonly
                    value="<?php echo $ServiceID;?>"/>
                </div> 
                <!-- servicedate field -->
                <div class="col form-group mb-3">
                    <label for="servicedate">Service Date</label>
                    <input type="date" class="form-control" id="servicedate" name="servicedate" placeholder="Enter Service Date" value="<?php echo $ServiceDate;?>"/>
                </div>
            </div>
            <!-- order number field with order list fetched from database -->
            <div class="form-group mb-3  ">
                <label for="orderno">Order Number</label>
                <!-- input field containing order number also targets modal $OrderNoModal  -->
                <input class="form-control" name="ordernos" data-toggle="modal" data-target="#OrderNoModal"  placeholder="Select Order Number" id="ordernos" readonly style="background-color: #ffffff;" value="<?php echo $OrderNo;?>"/>
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
                <input type="text" class="form-control" id="travelto" name="travelto" placeholder="Enter Travel To"  value="<?php echo $TravelTo;?>"  />
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
                                src="https://www.google.com/maps/embed/v1/directions?key=<?php echo $api_key;?>
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
                <input type="text" class="form-control" id="Customer" name="Customer" placeholder="Enter Customer" value="<?php echo $CustomerName;?>" />
            </div>

            <!-- kilometers traveled, automatically generated via google API based on from and to addresses  -->
            <div class="form-row row">
                <div class="col mb-3">
                    <label for="kmTraveled">Km Traveled</label>
                    <input type=number min="0" inputmode="decimal" pattern="[0-9]*" ng-model="vm.decimalNumbers" class="form-control" id="kmTraveled" name="kmTraveled" placeholder="" value="<?php echo $kmTraveled;?>" />
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
            <div id="accordion">
                <div class="card mb-2">
                    <div class="card-header btn btn-link collapsed expandform" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="text-align: left; text-underline-offset:  1px; padding-bottom: 0.9rem;">
                            Expenses
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">

                        <div class="card-body">
                            <div id="expense-accordion">
                                <div class="wrapper-expenseline">
                                    <button class="btn btn-primary add-btn-expenseline">Add More</button>
                                    
                                </div>  
                            </div>  
                        </div> 
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header btn btn-link collapsed expandform" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-align: left; text-underline-offset:  1px; padding-bottom: 0.9rem;">
                                Hours
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">

                            <div id="task-accordion">
                                <div class="wrapper-taskline">
                                    <button class="btn btn-primary add-btn-taskline">Add More</button>
                                    
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- form submit button, redirects to dashboard.php on submit  -->
            <div class="formbutton mt-3">
                <!-- save and exit button, submitted = 0 -->
                <input type="submit" name="exit" class="btn btn-primary submitBtn" value="Save & Exit" style="height:2.6rem;margin-right: 10px;"/>
                <!-- submit button redirect, submitted = 1 -->
                <input type="submit" name="submit" class="btn btn-primary submitBtn" value="Submit" style="height:2.6rem"/>
            </div>
            <!-- field to throw errors  -->
            <div id="alert_message" class="mt-2"></div>
        </form>
    </div>
</body>
</html>

<!-- JS begins -->

<script>
    // assign enpense and taskline arrays fetched from getExpenseLines.php 
    var ExpenseLineArr  = <?php echo JSON_encode($ExpenseLineArr);?>;
    var TaskLineArr  = <?php echo JSON_encode($TaskLineArr);?>;
    // console.log(TaskLineArr);
    // console.log(ExpenseLineArr);
</script>		

<!-- functions related to expense lines  -->
<script type="text/javascript">
  $(document).ready(function () {
    // variable max expense lines per service report
    var max_input = 8;
    // initialize the counter and index
    var x = 1;
    var index = 1;
    // add expense lines from database
    while (x <= ExpenseLineArr.length) { 
      x++; // increment the counter
      $('.wrapper-expenseline').append(`
          <?php require 'addExpenseLines.php'; ?>
      `); 
      index++;
    } 
    // add expense lines when add more button is triggered
    $('.add-btn-expenseline').click(function (e) {
      e.preventDefault();
      // get serviceID 
      var SID = parseInt($("#ServiceID").val());
        // function to append expense line, parameter: serviceID
        function addEL(response){
            e.preventDefault();
            response = parseInt(response);
            // if condition, expense line count less than max_input
            if (x < max_input) { 
                x++; // increment the counter
                // append expense line 
                $('.wrapper-expenseline').append(`
                    <div class="card exp-holder`+index+` mt-2" style="position: relative;">
                        <div class="card-header btn btn-link collapsed expandform" id="exphead`+index+`" data-toggle="collapse" data-target="#expense`+index+`" aria-expanded="false" aria-controls="expense`+index+`" style="text-align: left; font-weight:500; color: #000000; text-decoration:none;">
                                                    <span id="expheadmain`+index+`" name="expheadmain[]"> Expense Line </span>
                                                    <span style="color:grey;font-weight:light;font-size:0.8rem;" id="expheadtag`+index+`" name="expheadtag[]">                           
                                                    </span>
                        </div>
                        <span class="btn btn-danger remove-btn-expenseline w-25" style="position: absolute; left: 75%;"> Delete</span>
                        <div id="expense`+index+`" class="collapse" aria-labelledby="exphead`+index+`" data-parent="#expense-accordion">
                            <div class="card-body">
                                <input type="hidden" class="form-control" id="expID" name="expID[]" value="`+response+`"/>
                                <?php require 'addNewExpenseLine.php'; ?>
                                <div class="btn btn-danger collapsed" data-toggle="collapse" data-target="#expense`+index+`" aria-controls="expense`+index+`">
                                    Close
                                </div> 
                            </div> 
                        </div>
                    </div>
                `); 
                index++; //increment index value of expense line
            }
            // update expenselinearr 
            var el = [response,SID,0,0.00,0,0,0,'',0,''];
            ExpenseLineArr.push(el);
        };

        // ajax call to run query, when success calling function addEL 
        $.ajax({
                type: "GET", 
                url: 'addEmptyExpenseLine.php', 
                data: {SID:SID}, 
                beforeSend: function () {},
                success: function (response) {
                    // if success, add Expense line 
                    addEL(response);
                }
        });
    });

    // function removes expense line
    $('.wrapper-expenseline').on("click", ".remove-btn-expenseline", function (e) {
        e.preventDefault();
        //   get the selected expenseID 
        var selID = $(this).closest('div').find('#expID').val();
        // ajax call to delete expense line from database 
        if(selID!=0){
            if (confirm("Are you sure you want to delete this Expense Line?")) {
                $(this).parent('div').remove();
                $.ajax({
                    type: "GET", 
                    url: 'deleteExpenseLine.php',
                    data: {selID:selID}, 
                    beforeSend: function () {},
                    success: function (response) {
                        alert(response);
                    }
                });
            }
        }
        else{
            $(this).parent('div').remove();
        }
      x--; // decrement the counter
    });

    // fetching and displaying existing expense lines from database
    // initating variables for expense lines fields 
    const exp_ID = $('[name="expID[]"]');
    const exp_type = $('[name="exptype[]"]');
    const exp_amount = $('[name="expamount[]"]');
    const exp_curr = $('[name="expcurr[]"]');
    const exp_afacc = $('[name="check1[]"]');
    const exp_receipt = $('[name="check2[]"]');
    const exp_billable = $('[name="check3[]"]');
    const exp_notes = $('[name="expnotes[]"]');
    const exp_url = $('[name="img_url[]"]');
    const exp_preview = $('[name="img-preview[]"]');
    const exp_card = $('[name="img-card[]"]');
    const exp_head = $('[name="expheadmain[]"]');
    const exp_tag = $('[name="expheadtag[]"]');

    var j = 0;
    // iteration to fill expense line fields 
    for ( let i = 0; i < exp_type.length; i += 1 ) {
        $( exp_ID[ i ] ).val( ExpenseLineArr[i][0] );
        $( exp_type[ i ] ).val( ExpenseLineArr[i][2] );
        $( exp_amount[ i ] ).val( ExpenseLineArr[i][3] );
        $( exp_curr[ i ] ).val( ExpenseLineArr[i][4] );
        if(ExpenseLineArr[i][5] == 1){
            $(exp_afacc[ j ]).prop('checked', true);
            $(exp_afacc[ j+1 ]).prop('disabled', true);
        };
        if(ExpenseLineArr[i][6] == 1){
            $(exp_receipt[ j ]).prop('checked', true);
            $(exp_receipt[ j+1 ]).prop('disabled', true);
        };
        if(ExpenseLineArr[i][8] == 1){
            $(exp_billable[ j ]).prop('checked', true);
            $(exp_billable[ j+1 ]).prop('disabled', true);
        };
        j+=2;
        $( exp_notes[ i ] ).val( ExpenseLineArr[i][7] );

        if($(".exptype1 option[value='"+ExpenseLineArr[i][2]+"']").val() != 0){ 
            $(exp_head[i] ).text($(".exptype1 option[value='"+ExpenseLineArr[i][2]+"']").text());
            $(exp_tag[i] ).text("$" + ExpenseLineArr[i][3].toFixed(2));
        }

        if(ExpenseLineArr[i][9] != ''){
            $(exp_card[ i ]).css('display', 'block');
            $(exp_url[ i ]).prop('src', ExpenseLineArr[i][9]);
            $(exp_preview[ i ]).prop('href', ExpenseLineArr[i][9]);
        }
    }
});
</script>

<!-- functions related to task lines  -->
<script type="text/javascript">

$(document).ready(function () {

    // variable max task lines per service report
    var max_inputhours = 5;

    // initialize the counter and index
    var y = 1;
    var indexhours = 1;
    // add task lines from database
    while (y <= TaskLineArr.length) { 
        y++; // increment the counter
        $('.wrapper-taskline').append(`
            <?php require 'addTaskLines.php'; ?>
        `); 
        indexhours++;
    }

    // add task lines when add more button is triggered
    $('.add-btn-taskline').click(function (e) {
        e.preventDefault();
        // get serviceID 
        var SID = parseInt($("#ServiceID").val());
        // function to append task line, parameter: serviceID 
        function addTL(response){
            response = parseInt(response);
            // if condition, task line count less than max_inputhours
            if (y < max_inputhours) { // validate the condition
                y++; // increment the counter
                // append task line 
                $('.wrapper-taskline').append(`
                <div class="card task-holder`+indexhours+` mt-2" style="position: relative;">
                <div class="card-header btn btn-link collapsed expandform" id="taskhead`+indexhours+`" data-toggle="collapse" data-target="#task`+indexhours+`" aria-expanded="false" aria-controls="task`+indexhours+`" style="text-align: left; font-weight:500; color: #000000; text-decoration:none;">
                    <span id="taskheadmain`+indexhours+`" name="taskheadmain[]"> Task Line </span>
                    <span style="color:grey;font-weight:light;font-size:0.8rem;" id="taskheadtag`+indexhours+`" name="taskheadtag[]">                           
                    </span>
                </div>
                        <span class="btn btn-danger remove-btn-taskline w-25" style="position: absolute; left: 75%;"> Delete</span>
                        <div id="task`+indexhours+`" class="collapse" aria-labelledby="taskhead`+indexhours+`" data-parent="#task-accordion">
                            <div class="card-body">
                                <input type="hidden" class="form-control" id="taskID" name="taskID[]" value="`+response+`"/>
                                <?php require 'addNewTaskLine.php'; ?>
                                <div class="btn btn-danger collapsed" data-toggle="collapse" data-target="#task`+indexhours+`" aria-controls="task`+indexhours+`">
                                   Close
                                </div> 
                            </div> 
                        </div>
                    </div>
                `); 
                indexhours++; //increment index value of task line
            }
            // update tasklinearr 
            var tlArr = [response,0,0.00,''];
            TaskLineArr.push(tlArr);
        };

        // ajax call to run query, when success calling function addTL 
        $.ajax({
                type: "GET", 
                url: 'addEmptyTaskLine.php', 
                data: {SID:SID}, 
                beforeSend: function () {},
                success: function (response) {
                    // if success, add Task line 
                    addTL(response);
                }
        });
    });

    // function removes task line
    $('.wrapper-taskline').on("click", ".remove-btn-taskline", function (e) {
        e.preventDefault();
        // get the selected taskID 
        var stlID = $(this).closest('div').find('#taskID').val();
        console.log(stlID);
        // ajax call to delete expense line from database 
        if(stlID!=0){
            if (confirm("Are you sure you want to delete this Task Line?")) {
                $(this).parent('div').remove();
                $.ajax({
                    type: "GET", 
                    url: 'deleteTaskLine.php',
                    data: {stlID:stlID},
                    beforeSend: function () {},
                    success: function (response) {
                        alert(response);
                    }
                });
            }
        }
        else{
            $(this).parent('div').remove();
        }
      y--; // decrement the counter
    })

    // fetching and displaying existing task lines from database
    // initating variables for task lines fields 
    const task_ID = $('[name="taskID[]"]');
    const task_type = $('[name="tasktype[]"]');
    const task_hours = $('[name="taskhours[]"]');
    const task_notes = $('[name="tasknotes[]"]');
    const task_head = $('[name="taskheadmain[]"]');
    const task_tag = $('[name="taskheadtag[]"]');

    var j = 0;
    // iteration to fill task line fields 
    for ( let i = 0; i < task_type.length; i += 1 ) {
        $( task_ID[ i ] ).val( TaskLineArr[i][0] );
        $( task_type[ i ] ).val( TaskLineArr[i][1] );
        $( task_hours[ i ] ).val( TaskLineArr[i][2] );
        $( task_notes[ i ] ).val( TaskLineArr[i][3] );
        if($(".tasktype1 option[value='"+TaskLineArr[i][1]+"']").val() != 0){ 
            $( task_head[ i ] ).text($(".tasktype1 option[value='"+TaskLineArr[i][1]+"']").text());
            $( task_tag[ i ] ).text(TaskLineArr[i][2].toFixed(2) + " hrs");
        }

    }
  });
</script>

<script>
    // initiating lightbox to preview uploaded images 
    lightbox.option({
        disableScrolling:true;
    });
</script>

<script>
    // function filters the order list 
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".list-group label").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    $(document).ready(function(){
        // function fills travelfrom, travelto, customer name based on order selection
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
            e.preventDefault(); 
            var strFrom = $("#travelfrom").val();
            strFrom = strFrom.replace(/\s+/g, '+');
            var strTo = $("#travelto").val();
            strTo = strTo.replace(/\s+/g, '+');
            var strUrl = "https://www.google.com/maps/embed/v1/directions?key="+<?php echo $api_key;?>+"&origin="+strFrom+"&destination="+strTo+"";
            $("#mapframe").attr("src", strUrl);         
        });

    });
</script>

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