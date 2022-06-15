<?php
session_start();
if($_SESSION['userLoginStatus']==0){
    echo '<script>alert("User Not Logged In!");window.location.href="../index.php"</script>';
    // header('Location:../index.php');
}  
$_SESSION['SRStatus'] = "";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <script id='wpacu-combined-js-head-group-1' type='text/javascript' src='https://www.afasystemsinc.com/wp-content/cache/asset-cleanup/js/head-5e3e4d2c92fdd7fbfd909d433c07b6d9193b10e1.js'></script><link rel="https://api.w.org/" href="https://www.afasystemsinc.com/wp-json/" /><link rel="alternate" type="application/json" href="https://www.afasystemsinc.com/wp-json/wp/v2/pages/11" /><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /><meta name="google-site-verification" content="U_fWjqoTqoM87P1nyU91rpuLqqR0v2Yq6ZxPgKTOHF8"><link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-32x32.png" sizes="32x32" />
  <link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-192x192.png" sizes="192x192" />
  <link rel="apple-touch-icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-180x180.png" />
  <meta name="msapplication-TileImage" content="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-270x270.png" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Service Expense Reports</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="../assets/css/style.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf-8" src="../assets/vendor/js.cookie.js"></script>
  
</head>
<body>
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

<div class="main-container container">

<h5 class="my-2 container">Welcome 
			<?php
				include "../dbconnect.php";
				$sql = "SELECT FirstName,LastName FROM dbo.tblEmployee where TEAMUserName ='".$_SESSION['user']."'";
                            
				$stmt = sqlsrv_query( $conn, $sql);
				if( $stmt === false ) {
					die( print_r( sqlsrv_errors(), true));
				}
				
				// Make the first (and in this case, only) row of the result set available for reading.
				if( sqlsrv_fetch( $stmt ) === false) {
					die( print_r( sqlsrv_errors(), true));
				}

				// Get the row fields. Field indices start at 0 and must be retrieved in order.
				// Retrieving row fields by name is not supported by sqlsrv_get_field.
				$FirstName = sqlsrv_get_field( $stmt, 0);
				echo $FirstName." ";

				$LastName = sqlsrv_get_field( $stmt, 1);
				echo $LastName;
			?>!
</h5>

    <div class="toolbar container" style="margin-bottom: 0.6rem;">
        <button type="button" id="new" class="btn btn-primary">New</button>
        <button type="button" id="newsameas" class="btn btn-secondary disabled">Duplicate</button>
        <button type="button" id="update" class="btn btn-secondary disabled">Edit</button>
        <button type="button" id="delete" class="btn btn-secondary disabled">Delete</button>
    </div>
    
    <div class="container">
          <table id="tblService" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
              <th data-field="ordeerno" data-sortable="true">Order No</th>
              <th data-field="servicedate" data-sortable="true">Service Date</th>
              <th data-field="customername" data-sortable="true" style="width: 23%;">Customer Name</th>
              <th data-field="serviceid" data-sortable="true">Service ID</th>
              <th data-field="submitted">Submitted</th>
              <th data-field="reviewed">Reviewed</th>
              <th data-field="processed">Processed</th>
              <!-- <th data-field="actions" data-formatter="operateFormatter" data-events="operateEvents">Actions</th> -->
            </thead>
            <tbody>
            <?php
                    $sql00 = "SELECT * FROM dbo.tblService 
                              INNER JOIN dbo.tblCustOrders ON dbo.tblService.OrderID = dbo.tblCustOrders.OrderID 
                              INNER JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID 
                              WHERE EmployeeID =".$_SESSION['EmployeeID'];
                    $result00 = sqlsrv_query($conn,$sql00) or die("Couldn't execut query");
                    while ($data00=sqlsrv_fetch_array($result00, SQLSRV_FETCH_ASSOC)){
                    echo '<tr>';
                    echo '<td>'.$data00['OrderNo'].'</td>';
                    echo '<td>'.date_format($data00['ServiceDate'], 'M j Y').'</td>';
                    echo '<td>'.$data00['CustomerName'].'</td>';
                    echo '<td>'.$data00['ServiceID'].'</td>';
                    if($data00['Submitted']==1){
                        echo '<td style="text-align: center;"><input type="checkbox" class="submitTrue" name="submitted" checked onchange="this.checked =true;"></td>';
                    }
                    else{
                        echo '<td style="text-align: center;"><input type="checkbox" class="submitFalse" name="submitted" onchange="this.checked = false;"></td>';
                    }

                    if($data00['Reviewed']==1){
                        echo '<td style="text-align: center;"><input type="checkbox" class="reviewTrue" name="reviewed"  checked onchange="this.checked = true;"></td>';
                        }
                        else{
                        echo '<td style="text-align: center;"><input type="checkbox" class="reviewFalse" name="reviewed" onchange="this.checked = false;"></td>';
                    }

                    if($data00['Processed']==1){
                        echo '<td style="text-align: center;"><input type="checkbox" class="processTrue" name="processed" checked onchange="this.checked = true;"></td>';
                        }
                    else{
                        echo '<td style="text-align: center;"><input type="checkbox" class="processFalse" name="processed" onchange="this.checked = false;"></td>';
                    }
                    // echo '<td style="text-align: center;"><input type="checkbox" name="submitted" checked="'.$data00['Submitted'].'" onchange="this.checked = '.$data00['Submitted'].';"></td>';
                    // echo '<td style="text-align: center;"><input type="checkbox" name="reviewed"  checked="'.$data00['Reviewed'].'" onchange="this.checked = '.$data00['Reviewed'].';"></td>';
                    // echo '<td style="text-align: center;"><input type="checkbox" name="processed" checked="'.$data00['Processed'].'" onchange="this.checked = '.$data00['Processed'].';"></td>';
                    // echo '<td></td>';
                    echo '</tr>' ;
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>


<script>
  $(document).ready(function() {
        var table = $('#tblService').DataTable( {
            responsive: true,
            "lengthChange": false,
            "order": [[ 3, "desc" ]],

            "createdRow": function( row, data, dataIndex){
                if(data[4].includes('submitFalse')){
                    $(row).addClass('redClass');
                }
                if(data[4].includes('submitTrue') && data[6].includes('processFalse')){
                    $(row).addClass('yellowClass');
                }
                if(data[4].includes('submitTrue') && data[6].includes('processTrue')){
                    $(row).addClass('greenClass');
                }
            }

        } );

        $('#tblService tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $("#newsameas").addClass('disabled');
                $("#newsameas").removeClass('btn-primary');
                $("#newsameas").addClass('btn-secondary');

                $("#update").addClass('disabled');
                $("#update").removeClass('btn-primary');
                $("#update").addClass('btn-secondary');

                $("#delete").addClass('disabled');
                $("#delete").removeClass('btn-primary');
                $("#delete").addClass('btn-secondary');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');

                $("#newsameas").removeClass('disabled');
                $("#newsameas").removeClass('btn-secondary');
                $("#newsameas").addClass('btn-primary');

                $("#update").removeClass('disabled');
                $("#update").removeClass('btn-secondary');
                $("#update").addClass('btn-primary');
                
                $("#delete").removeClass('disabled');
                $("#delete").removeClass('btn-secondary');
                $("#delete").addClass('btn-primary');
            }
        } );

        $('#new').click( function () {
            Cookies.set("SRStatus", 0, { expires: 7, path: '/' });
            Cookies.set("EmployeeID", <?php echo $_SESSION['EmployeeID'];?>, { expires: 7, path: '/' });
            // setcookie("SRStatus", 0, time()+3600, '/');
            window.location = "../root/newservicereports.php";
        });
        
        $('#newsameas').click( function () {
            var SRID = table.row('.selected').data()[3];
            
                // Ajax config
                $.ajax({
                    type: "GET", //we are using GET method to get data from server side
                    url: 'duplicateSR.php', // get the route value
                    data: {SRID:SRID}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
                        alert(response);
                        window.location = "../root/dashboard.php";
                    }
                });
        });

        $('#update').click( function () {
            Cookies.set("SRStatus", 1, { expires: 7, path: '/' });
            var SRID = table.row('.selected').data()[3];
            Cookies.set("SRID", SRID, { expires: 7, path: '/' });
            // setcookie("SRStatus", 1, time()+3600, '/');
            window.location = "../root/updateservicereports.php";
        });

        $('#delete').click( function () {
            var SRID = table.row('.selected').data()[3];
            Cookies.set("SRID", SRID, { expires: 7, path: '/' });

            if (confirm("Are you sure you want to delete this Service Report?")) {

                // Ajax config
                $.ajax({
                    type: "GET", //we are using GET method to get data from server side
                    url: 'deleteSR.php', // get the route value
                    data: {SRID:SRID}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                        
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
                        alert(response);
                        table.row('.selected').remove().draw( false );
                        $("#newsameas").addClass('disabled');
                        $("#newsameas").removeClass('btn-primary');
                        $("#newsameas").addClass('btn-secondary');

                        $("#update").addClass('disabled');
                        $("#update").removeClass('btn-primary');
                        $("#update").addClass('btn-secondary');

                        $("#delete").addClass('disabled');
                        $("#delete").removeClass('btn-primary');
                        $("#delete").addClass('btn-secondary');
                    }
                });
            }
        });


        $(".dtr-control").each(function() {
            $(this).click(function(){
                table.rows('.parent').nodes().to$().find('.dtr-control').not(this).trigger('click');
            });
        });

        var data = table.rows().data();
            data.each(function (value, index) {
                if(`${value}`.includes('submitTrue')){
                    // $(row).addClass('redClass');
                    // table.row( this ).css("color", "yellow");
                    console.log(`For index ${index}, data value is ${value}`);
                };
            // console.log(`For index ${index}, data value is ${value}`);
        });
        
    } );
  </script>

<script>
    $(document).ready(function(){
        // $(".submitTrue").parent().parent().css("color", "red");
        // if($("tr > td > input").hasClass("submitFalse") == true || $("tr > td > input").hasClass("processFalse") == true){
        //     $(".submitTrue").parent().parent().css("color", "red");
        //     // $("p").css("color", "red");
        //     // alert("hi");
        // }

        // $('tbody  > tr').each(function() { 
        //     $(this).css("color", "green");
        //     // if($(this).find('p.filled-text').length !== 0)
        //     console.log("hi");
        //     console.log("hi");
        // });

        // if($("input[name=processed]").hasClass("processTrue") == true){
        //     $(".processTrue").parent().parent().css("color", "green");
        // }
        // if($("input[name=processed]").hasClass("processFalse") == true){
        //     $(".processFalse").parent().parent().css("color", "yellow");
        // }
        // if($("input[name=submitted]").hasClass("submitFalse") == true){
        //     $(".submitFalse").parent().parent().css("color", "red");
        //     // $("p").css("color", "red");
        //     // alert("hi");
        // }
    });
</script>
  
<!-- <script>
  $(document).ready(function() {
    $("#tblService_wrapper div .col-md-6").html("<h1>Hello, World!</h1>");
} );
</script> -->