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

 <!-- lightbox -->
 <link rel="stylesheet" href="..\assets\vendor\lightbox\css\lightbox.min.css">
 <script src="..\assets\vendor\lightbox\js\lightbox-plus-jquery.min.js"></script>

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


<?php require 'getSRDetails.php'; ?>
<?php require 'getExpenseLines.php'; ?>
<?php require 'getTaskLines.php'; ?>
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
<?php
            // perform actions for each file found
            // foreach (glob("../uploads/expenselines/10912 13.*") as $filename) {
            //     if (file_exists($filename)) {
            //         echo "The file $filename exists";
            //         echo "<img src='".$filename."' style='width:100px;height:100px'>";
            //     } else {
            //         echo "The file $filename does not exist";
            //     }
            // }
            
        ?>
<div class="submitmain">
<form id="fupForm" name="fupForm" method="post" action="sp_tblService_NewItem.php"  onsubmit="return validateForm()" autocomplete="off" enctype="multipart/form-data">
<div class="form-row row">
                        <div class="col form-group mb-3">
                            <label for="name">Service ID</label>
                            <input type="text" class="form-control" id="ServiceID" name="ServiceID" placeholder="Enter ID" readonly
                            value="<?php echo $ServiceID;?>"/>
                        </div> 
                        <div class="col form-group mb-3">
                            <label for="servicedate">Service Date</label>
                            <input type="date" class="form-control" id="servicedate" name="servicedate" placeholder="Enter Service Date" value="<?php echo $ServiceDate;?>"/>
                        </div>
                </div>
        <div class="form-group mb-3  ">
            <label for="orderno">Order Number</label>
            <input class="form-control" name="ordernos" data-toggle="modal" data-target="#OrderNoModal"  placeholder="Select Order Number" id="ordernos" readonly style="background-color: #ffffff;"
            value="<?php echo $OrderNo;?>"/>
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





                            
                                <!-- <div class="list-group">

                                    <?php
                                        // require "dbconnect.php";
                                        // $sql = "SELECT * FROM dbo.tblCustOrders INNER JOIN tblCustomers on (tblCustOrders.CustID = tblCustomers.CustID)";
                                        // $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
                                        // while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                                        // echo '<label class="list-group-item" style="width:100%;border-top-width:1px;margin-bottom:-0.2rem;">';
                                        // echo '<input type="radio" class="form-check-input me-1" name="orderno" value="';
                                        // echo $data['OrderNo'];
                                        // echo '">';
                                        // echo $data['OrderNo'];
                                        // echo '<span style="color:grey;font-weight:light;font-size:0.8rem;"> ';
                                        // echo $data['CustomerName'];
                                        // echo '</span></label>';
                                        // }
                                    ?>
                                </div> -->
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
            <input type="text" class="form-control" id="travelto" name="travelto" placeholder="Enter Travel To"  value="<?php echo $TravelTo;?>"  />
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
                        src="https://www.google.com/maps/embed/v1/directions?key=<?php echo $api_key;?>
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
            <input type="text" class="form-control" id="Customer" name="Customer" placeholder="Enter Customer" value="<?php echo $CustomerName;?>" />
        </div>
        <!-- <div class="form-group mb-3 inputfield">
            <label for="file">Scan Receipt</label>
            <input type="file" class="form-control" id="file" name="file" />
        </div> -->

        <div class="form-row row">
            <div class="col mb-3">
                <label for="kmTraveled">Km Traveled</label>
                <input type=number min="0" inputmode="decimal" pattern="[0-9]*" ng-model="vm.decimalNumbers" class="form-control" id="kmTraveled" name="kmTraveled" placeholder="" value="<?php echo $kmTraveled;?>" />
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
            <!-- <div class="card mb-2">
                <div class="card-header btn btn-link collapsed expandform" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="text-align: left; text-underline-offset:  1px; padding-bottom: 0.9rem;">
                        File Atachment
                </div>

                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group mb-3  ">
                            <label for="filedsp">File Description</label>
                            <input type="text" class="form-control" id="filedsp" name="filedsp" placeholder="Enter File Description"/>
                        </div>

                        <div class="form-group mb-3  ">
                            <label for="file">Select File</label>
                            <input type="file" class="form-control" id="file" name="file" />
                        </div>
                        
                    </div>
                </div>
            </div> -->
        </div>
        <!-- collapse form ended -->

        <div class="formbutton mt-3">
            <input type="submit" name="exit" class="btn btn-primary submitBtn" value="Save & Exit" style="height:2.6rem;margin-right: 10px;"/>
            <input type="submit" name="submit" class="btn btn-primary submitBtn" value="Submit" style="height:2.6rem"/>
        </div>
        <div id="alert_message" class="mt-2"></div>
</form>
</div>

</body>
</html>

<script>
    var ExpenseLineArr  = <?php echo JSON_encode($ExpenseLineArr);?>;
    var TaskLineArr  = <?php echo JSON_encode($TaskLineArr);?>;
    // document.write("ExpenseLineArr of 2nd person : " + ExpenseLineArr[1][2] + "<br>");
    // document.write("ExpenseLineArr of 4th person : " + ExpenseLineArr[2][2] + "<br>");
    console.log(TaskLineArr);
    console.log(ExpenseLineArr);

    
</script>		

<script type="text/javascript">
  $(document).ready(function () {

    // allowed maximum input fields
    var max_input = 8;
    // initialize the counter for textbox
    var x = 1;
    var index = 1;
    // handle click event on Add More button

      while (x <= ExpenseLineArr.length) { // validate the condition
        x++; // increment the counter
        $('.wrapper-expenseline').append(`
            <?php require 'addExpenseLines.php'; ?>
        `); 
        index++;
      }


    $('.add-btn-expenseline').click(function (e) {
      e.preventDefault();

      
        
      var SID = parseInt($("#ServiceID").val());

      function addEL(response){
        //   alert(response);
            response = parseInt(response);
            if (x < max_input) { // validate the condition
                x++; // increment the counter
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
                `); // add input field
                index++;
            }
        var test = [response,SID,0,0.00,0,0,0,'',0,''];
        ExpenseLineArr.push(test);
        console.log(ExpenseLineArr);
        };

        $.ajax({
                type: "GET", //we are using GET method to get data from server side
                url: 'addEmptyExpenseLine.php', // get the route value
                data: {SID:SID}, //set data
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    
                },
                success: function (response) {//once the request successfully process to the server side it will return result here
                    // console.log(response);
                    // Cookies.set("elID", response, { expires: 7, path: '/' });
                    // $honey = response;
                    addEL(response);
                }
        });
        // alert(Cookies.get('selID'));

        // $elID = parseInt(Cookies.get('elID'))+1;
        // console.log($honey);
        // var test = [$selID,SID,0,0.00,0,0,0,null,0,null];
        // ExpenseLineArr.push(test);
        // console.log(ExpenseLineArr);
    });

    // handle click event of the remove link
    $('.wrapper-expenseline').on("click", ".remove-btn-expenseline", function (e) {
      e.preventDefault();
      var selID = $(this).closest('div').find('#expID').val();
      console.log(selID);
    //   $(this).parent('div').remove();  // remove input field
        
        if(selID!=0){
            if (confirm("Are you sure you want to delete this Expense Line?")) {
                $(this).parent('div').remove();
                // Ajax config
                $.ajax({
                    type: "GET", //we are using GET method to get data from server side
                    url: 'deleteExpenseLine.php', // get the route value
                    data: {selID:selID}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                        
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
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

    // function exptag() {
    //     var x = document.getElementById("exptype").value;
    //     console.log(x);
    //     document.getElementById("demo").innerHTML = "You selected: " + x;
    // }

    // $('body').on('change', 'input[name="exptype[]"]', () => {   
    //         // var result =  $(this).val();
    //         var result = $(this).val();
    //         console.log(result);
    //         // $("#ordernos").val(result);
    //         // $("#Customer").attr("value", passedArray[result]);
    //         // $("#travelto").attr("value", passedArray2[result]);
    //     });
});
</script>

<script type="text/javascript">
  $(document).ready(function () {

    // allowed maximum input fields
    var max_inputhours = 5;

    // initialize the counter for textbox
    var y = 1;
    var indexhours = 1;

    while (y <= TaskLineArr.length) { // validate the condition
        y++; // increment the counter
        $('.wrapper-taskline').append(`
            <?php require 'addTaskLines.php'; ?>
        `); 
        indexhours++;
    }
    // handle click event on Add More button
    $('.add-btn-taskline').click(function (e) {
      e.preventDefault();

      var SID = parseInt($("#ServiceID").val());

      function addTL(response){
        //   alert(response);
            response = parseInt(response);
            if (y < max_inputhours) { // validate the condition
                y++; // increment the counter
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
                `); // add input field
                indexhours++;
            }
            var tlArr = [response,0,0.00,''];
            TaskLineArr.push(tlArr);
            console.log(TaskLineArr);
        };

        $.ajax({
                type: "GET", //we are using GET method to get data from server side
                url: 'addEmptyTaskLine.php', // get the route value
                data: {SID:SID}, //set data
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    
                },
                success: function (response) {//once the request successfully process to the server side it will return result here
                    // console.log(response);
                    // Cookies.set("elID", response, { expires: 7, path: '/' });
                    // $honey = response;
                    addTL(response);
                }
        });



    //   if (y < max_inputhours) { // validate the condition
    //     y++; // increment the counter
        
        
    //     $('.wrapper-taskline').append(`
    //           <div class="card mt-2" style="position: relative;">
    //               <div class="card-header btn btn-link collapsed expandform" id="taskhead`+indexhours+`" data-toggle="collapse" data-target="#task`+indexhours+`" aria-expanded="false" aria-controls="task`+indexhours+`" style="text-align: left; font-weight:500; color: #000000; text-decoration:none;">
    //                                         Task Line
    //                                         <span style="color:grey;font-weight:light;font-size:0.8rem;" id="taskheadtag`+indexhours+`" name="taskheadtag[]">                           
    //                                         </span>
                                            
    //               </div>
    //               <span class="btn btn-danger remove-btn-taskline w-25" style="position: absolute; left: 75%;"> Delete</span>
    //               <div id="task`+indexhours+`" class="collapse" aria-labelledby="taskhead`+indexhours+`" data-parent="#task-accordion">
    //                   <div class="card-body">
                        //   <?php 
                                //  require '../taskline.php'; 
                             ?>
    //                       <div class="btn btn-danger collapsed" data-toggle="collapse" data-target="#task`+indexhours+`" aria-controls="task`+indexhours+`">
    //                           Close
    //                       </div> 
    //                   </div> 
    //               </div>
    //           </div>
    //     `); // add input field
    //     indexhours++;

    //   }
    });

    // handle click event of the remove link
    $('.wrapper-taskline').on("click", ".remove-btn-taskline", function (e) {
      e.preventDefault();
    //   $(this).parent('div').remove();  // remove input field
      var stlID = $(this).closest('div').find('#taskID').val();
      console.log(stlID);
    //   $(this).parent('div').remove();  // remove input field
        
        if(stlID!=0){
            if (confirm("Are you sure you want to delete this Task Line?")) {
                $(this).parent('div').remove();
                // Ajax config
                $.ajax({
                    type: "GET", //we are using GET method to get data from server side
                    url: 'deleteTaskLine.php', // get the route value
                    data: {stlID:stlID}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                        
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
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

    const task_ID = $('[name="taskID[]"]');
    const task_type = $('[name="tasktype[]"]');
    const task_hours = $('[name="taskhours[]"]');
    const task_notes = $('[name="tasknotes[]"]');
    const task_head = $('[name="taskheadmain[]"]');
    const task_tag = $('[name="taskheadtag[]"]');

    var j = 0;
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
    lightbox.option({
        disableScrolling:true
    });

</script>



<script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".list-group label").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>

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

<script>
    function validateForm() {
        let x = document.forms["fupForm"][".taskhour-validation"].value;
        if (x == "") {
            alert("Name must be filled out");
            return false;
        }
    }
</script>
