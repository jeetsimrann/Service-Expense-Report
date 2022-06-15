<?php
session_start();
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

 <link rel="stylesheet" href="assets\css\style.css"/>
 <!-- Google Fonts -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700"/>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

 <!-- Bootstrap CDN -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

 <!-- Bootstrap CDN -->
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
 <script type="text/javascript" charset="utf-8" src="assets/vendor/js.cookie.js"></script>

</head>

<body>
<?php require 'utilities/header.php'; ?>
<?php require 'root/sp_newSR.php'; ?>
<?php require 'root/sp_qryCustOrderService.php'; ?>
<div class="submitmain">

<form id="fupForm" method="post" action="root/sp_tblService_SaveItem.php" autocomplete="off" enctype="multipart/form-data">
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
        <!-- <div class="form-group mb-3  ">
            <label for="orderno">Order Number</label>

            <input list="orderno" name="ordernos" id="ordernos" class="form-control" placeholder="Select Order Number"/>
            <datalist id="orderno">
             <?php
            //  $serverName = 'tcp:teamoffline.database.windows.net,1433';
            //  $uid = 'sim1999';
            //  $pwd = 'simran@99';
            //  $databaseName = 'TEAMOffline';
            //  $connectionInfo = array('UID'=>$uid,
            //                          'PWD'=>$pwd,
            //                          'Database'=>$databaseName);
            //  $conn = sqlsrv_connect($serverName,$connectionInfo);
            //  if($conn){
            //      echo '';
            //  }else{
            //      echo 'Connection failure<br />';
            //  die(print_r(sqlsrv_errors(),TRUE));
            //  }
            //      $sql = "SELECT * FROM dbo.tblCustOrders INNER JOIN tblCustomers on (tblCustOrders.CustID = tblCustomers.CustID)";
            //      $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
            //      $array1 = array();
            //      $array2 = array();
            //      while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
            //     //  echo '<option value="'.$data['OrderID'].'">';
            //     //  echo $data['OrderNo']; 
            //     //  echo " || ".$data['CustomerName'];
            //     array_push($array1, $data['OrderNo']);
            //     array_push($array2, $data['CustomerName']);
            //      echo '<option value="'.$data['OrderNo']  .  ' ('. $data['CustomerName'] .')'  . '">';
            //      echo "</option>";
            //     }
            //  $array3 = array_combine($array1, $array2);
             ?>
             </datalist>
        </div> -->

        <!-- <div class="form-group mb-3  ">
            <label for="orderno">Order Number</label>      
        
            <input type="text" class="form-control" placeholder="Enter Order Number" data-toggle="modal" data-target="#exampleModal"  id="destination">
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-bo\dy">
                        <input class="form-control" id="myInput" type="text" placeholder="Search..">
                            <br>
                        <select id="myList" class="form-select form-control" size="5" aria-label="size 6 multiple select example" onChange="copyTextValue(this);">
                            <option style="display:none"></option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Select</button>
                    </div>
                    </div>
                </div>
                </div>
    
        </div> -->

        <div class="form-group mb-3  ">
            <label for="orderno">Order Number</label>
            <input class="form-control" name="ordernos" data-toggle="modal" data-target="#OrderNoModal"  placeholder="Select Order Number" id="ordernos" readonly style="background-color: #ffffff;"/>
            <div class="modal fade" id="OrderNoModal" tabindex="-1" role="dialog" aria-labelledby="OrderNoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="margin-top: 5rem;">
                    <div class="modal-content">
                        <div class="modal-body">
                            <input class="form-control" id="myInput" type="text" placeholder="Search..">
                            <br>
                            <div class="">
                                <div class="list-group">

                                    <?php
                                        include "dbconnect.php";
                                        $sql = "SELECT * FROM dbo.tblCustOrders INNER JOIN tblCustomers on (tblCustOrders.CustID = tblCustomers.CustID)";
                                        $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");
                                        while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                                        echo '<label class="list-group-item" style="width:100%;border-top-width:1px;margin-bottom:-0.2rem;">';
                                        echo '<input type="radio" class="form-check-input me-1" name="orderno" value="';
                                        echo $data['OrderNo'];
                                        echo '">';
                                        echo $data['OrderNo'];
                                        echo '<span style="color:grey;font-weight:light;font-size:0.8rem;"> ';
                                        echo $data['CustomerName'];
                                        echo '</span></label>';
                                        }
                                    ?>
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
                <label for="MileageAllowance">Mileage Allowance</label>
                <input type="text" class="form-control" id="MileageAllowance" name="MileageAllowance" placeholder="" readonly value="<?php echo $MileageAllowance;?>" />
            </div>
            <div class="col mb-3">
                <label for="MileageAllowanceBillable">Mileage Billable</label>
                <input type="text" class="form-control" id="MileageAllowanceBillable" name="MileageAllowanceBillable" placeholder="" readonly value="<?php echo $MileageAllowanceBillable;?>" />
            </div>
        </div>


        <div class="form-row row">
            <div class="col mb-3">
                <label for="kmTraveled">Km Traveled</label>
                <input type="text" class="form-control" id="kmTraveled" name="kmTraveled" placeholder="Enter Km Traveled" />
            </div>
            <div class="col mb-3">
                <label for="USExchange">US Exchange</label>
                <input type="text" class="form-control" id="USExchange" name="USExchange" placeholder="" readonly value="<?php echo $USExchange;?>" />
            </div>
        </div>

        <div>
        <p id="demo"></p>
            <?php
                // echo "<pre>";
                // print_r($arrCustomerName["SP-5820"]);
                // echo "</pre>";
                // echo "<pre>";
                // var_export($arrCustomerName);
                // echo "</pre>";
                // echo "<pre>";
                // var_export($array3);
                // echo "</pre>";
                // echo "<pre>";
                // var_export($arrCurrencyID);
                // echo "</pre>";
                // echo print_r($array3["SP-5820"]);
            ?>
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
                    <!-- <div class="card-body">
                        <div id="expense-accordion">
                            <div class="wrapper">
                                <div class="input-box d-flex">
                                <input type="text" name="input_name[]" class="form-control">
                                <div>
                                </div>
                                <button class="btn btn-primary add-btn w-25">Add More</button>
                                
                            </div> 
                        </div>  
                    </div>  -->
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

                        <!-- <div class="form-group mb-3 inputfield">
                            <label for="exptype">Task</label>
                            <input type="text" class="form-control" id="taskhours" name="taskhours" placeholder="Select Task"/>
                        </div>
                        <div class="form-group mb-3 inputfield">
                            <label for="taskhours">Hours</label>
                            <input type="text" class="form-control" id="taskhours" name="taskhours" placeholder="Enter Hours"/>
                        </div>

                        <div class="form-group mb-3 inputfield">
                            <label for="tasknotes">Notes</label>
                            <textarea type="text" class="form-control" id="tasknotes" name="tasknotes" rows="3"></textarea>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="card mb-2">
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
            </div>
        </div>
        <!-- collapse form ended -->

        <div class="formbutton mt-3">
            <input type="submit" name="submit" class="btn btn-primary submitBtn" value="SUBMIT" style="height:2.6rem"/>
        </div>
        <div id="alert_message" class="mt-2"></div>
</form>
</div>

</body>
</html>

<script type="text/javascript">
  $(document).ready(function () {

    // allowed maximum input fields
    var max_input = 5;

    // initialize the counter for textbox
    var x = 1;
    var index = 1;
    // handle click event on Add More button
    $('.add-btn-expenseline').click(function (e) {
      e.preventDefault();
      if (x < max_input) { // validate the condition
        x++; // increment the counter
        
        
        $('.wrapper-expenseline').append(`
              
              <div class="card mt-2" style="position: relative;">
                  <div class="card-header btn btn-link collapsed expandform" id="exphead`+index+`" data-toggle="collapse" data-target="#expense`+index+`" aria-expanded="false" aria-controls="expense`+index+`" style="text-align: left; text-underline-offset:  1px; padding-top: 0.2rem;">
                                            Expenses Line `+index+`
                                            
                  </div>
                  <span class="btn btn-danger remove-btn-expenseline w-25" style="position: absolute; left: 75%;"> Delete</span>
                  <div id="expense`+index+`" class="collapse" aria-labelledby="exphead`+index+`" data-parent="#expense-accordion">
                      <div class="card-body">
                          <?php require 'expenseline.php'; ?>
                          <div class="btn btn-danger collapsed" data-toggle="collapse" data-target="#expense`+index+`" aria-controls="expense`+index+`">
                              Close
                          </div> 
                      </div> 
                  </div>

                  
              </div>
        `); // add input field
        index++;
        // $('.wrapper').append(`
        //   <div>
        //     <a href="#" class="remove-lnk">Remove</a>
        //      php require 'expenseline.php'; ?>
        //     <div class="btn btn-danger collapsed" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne">
        //                     Close
        //     </div> 
        //   </div>
        // `); // add input field
       
        // $('.wrapper').append(`
        //   <div class="input-box d-flex">
        //     <input type="text" name="input_name[]" class="form-control"/>
        //     <a href="#" class="remove-lnk">Remove</a>
        //   </div>
        // `); // add input field
      }
    });

    // handle click event of the remove link
    $('.wrapper-expenseline').on("click", ".remove-btn-expenseline", function (e) {
      e.preventDefault();
      index--;
      $(this).parent('div').remove();  // remove input field
      x--; // decrement the counter
    })
  });
</script>

<script type="text/javascript">
  $(document).ready(function () {

    // allowed maximum input fields
    var max_input = 5;

    // initialize the counter for textbox
    var x = 1;
    var index = 1;
    // handle click event on Add More button
    $('.add-btn-taskline').click(function (e) {
      e.preventDefault();
      if (x < max_input) { // validate the condition
        x++; // increment the counter
        
        
        $('.wrapper-taskline').append(`
              
              <div class="card mt-2" style="position: relative;">
                  <div class="card-header btn btn-link collapsed expandform" id="taskhead`+index+`" data-toggle="collapse" data-target="#task`+index+`" aria-expanded="false" aria-controls="task`+index+`" style="text-align: left; text-underline-offset:  1px; padding-top: 0.2rem;">
                                            Task Line `+index+`
                                            
                  </div>
                  <span class="btn btn-danger remove-btn-taskline w-25" style="position: absolute; left: 75%;"> Delete</span>
                  <div id="task`+index+`" class="collapse" aria-labelledby="taskhead`+index+`" data-parent="#task-accordion">
                      <div class="card-body">
                          <?php require 'taskline.php'; ?>
                          <div class="btn btn-danger collapsed" data-toggle="collapse" data-target="#task`+index+`" aria-controls="task`+index+`">
                              Close
                          </div> 
                      </div> 
                  </div>

                  
              </div>
        `); // add input field
        index++;

      }
    });

    // handle click event of the remove link
    $('.wrapper-taskline').on("click", ".remove-btn-taskline", function (e) {
      e.preventDefault();
      index--;
      $(this).parent('div').remove();  // remove input field
      x--; // decrement the counter
    })
  });
</script>

<!-- 
<script type="text/javascript">
     $(document).ready(function() {
      $('#ordernos').on('change', function() {
        var ordernos = $( "#ordernos" ).val();
        $("#travelto").attr("value", "");
            $.ajax({
                url:"orderdetails.php",
                method:"POST",
                data:{ordernos: ordernos}
                dataType:"text",
                success:function(data){
                    $("#travelto").attr("value", data);
                }
            });
          });
       });
</script> -->
<!-- <script>
    $(document).ready(function() {
        var passedArray = <?php 
            // echo json_encode($arrCustomerName); ?>;
        var passedArray2 = <?php 
        // echo json_encode($arrFullAddress); ?>;
        $("#ordernos").on('change', function(){
            var result = $( "#ordernos" ).val();

            // document.getElementById("demo").innerHTML = passedArray[result];
            if(passedArray[result] == ""){
                $("#Customer").attr("value", "");
                $("#travelto").attr("value", "");
            }
            else{
                $("#Customer").attr("value", passedArray[result]);
                $("#travelto").attr("value", passedArray2[result]);
            }
        //   var mainselection = this.value; // get the selection value
        //   $.ajax({
        //     type: "POST",  // method of sending data
        //     url: "subcategory.php", // name of PHP script
        //     data:'selection='+mainselection, // parameter name and value
        //     success: function(result){ // deal with the results
        //       $("#subcat-list").html(result); // insert in div above
        //       }
        //     });
        });
    });
</script> -->

<!-- <script>
  
  // onkeyup event will occur when the user 
  // release the key and calls the function
  // assigned to this event
  function GetDetail(str) {
      if (str.length == 0) {
        $("#travelto").attr("value", "");
          return;
      }
      else {

          // Creates a new XMLHttpRequest object
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function () {

              // Defines a function to be called when
              // the readyState property changes
              if (this.readyState == 4 && 
                      this.status == 200) {
                    
                  // Typical action to be performed
                  // when the document is ready
                  var myObj = JSON.parse(this.responseText);

                  // Returns the response data as a
                  // string and store this array in
                  // a variable assign the value 
                  // received to first name input field
                  $("#travelto").attr("value", myObj[0]);
              }
          };

          // xhttp.open("GET", "filename", true);
          xmlhttp.open("GET", "orderdetails.php?orderno=" + str, true);
            
          // Sends the request to the server
          xmlhttp.send();
      }
  }
</script> -->



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
        var passedArray = <?php echo json_encode($arrCustomerName); ?>;
        var passedArray2 = <?php echo json_encode($arrFullAddress); ?>;
        $("input:radio").change(function() {
            var result =  $(this).val();
            $("#ordernos").val(result);
            $("#Customer").attr("value", passedArray[result]);
            $("#travelto").attr("value", passedArray2[result]);
        });
        
        
        
        // $("input[type='radio'][name='orderno']").click(function() {
        //     var string = "";
        //     $("input:checked").each(function() {
        //         string += $(this).val();
        //     });
        //     $("#ordernos").val(string);
        // });
    });
</script>

<!-- <script>
    function copyTextValue(selectedOption) {
    if(selectedOption.selectedIndex <= 0){
    document.getElementById("ordernos").value = '';
    return;
    }
    var selectedOptionValue = selectedOption.value;
    document.getElementById("ordernos").value = selectedOptionValue;
    }
</script> -->