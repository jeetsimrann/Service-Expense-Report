<!-- dashboard for Service Reports -->
<?php
    session_start();
    // redirect to login page if user not logged in 
    if($_SESSION['userLoginStatus']==0){
        echo '<script>alert("User Not Logged In!");window.location.href="../index.php"</script>';
    }  
    $_SESSION['SRStatus'] = "";
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <!-- title and application icon  -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <script id='wpacu-combined-js-head-group-1' type='text/javascript' src='https://www.afasystemsinc.com/wp-content/cache/asset-cleanup/js/head-5e3e4d2c92fdd7fbfd909d433c07b6d9193b10e1.js'></script><link rel="https://api.w.org/" href="https://www.afasystemsinc.com/wp-json/" /><link rel="alternate" type="application/json" href="https://www.afasystemsinc.com/wp-json/wp/v2/pages/11" /><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /><meta name="google-site-verification" content="U_fWjqoTqoM87P1nyU91rpuLqqR0v2Yq6ZxPgKTOHF8"><link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-32x32.png" sizes="32x32" />
        <link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-180x180.png" />
        <meta name="msapplication-TileImage" content="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-270x270.png" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
             
        <title>AFA Expenses Dashboard</title>
        <!-- font family  -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <!-- Bootstrap, jQuery and datatables CDN-->
        <link rel="stylesheet" href="../assets/css/style.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
        
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="../assets/vendor/js.cookie.js"></script>
    </head>

    <body>
        <!-- Header  -->
        <header class="header-transparent" id="header">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="border-bottom:2px solid #0000001a">
                <div class="container-fluid justify-content-end">
                   <a href="../logout.php">
                    <input type="submit" name="logout" id="logout" value="Logout" class="btn btn-primary" style="margin-right:0.5rem;">
                   </a>
                </div>
            </nav>
        </header>
        <!-- End Header -->
         
        <!-- Main dashboard container  -->
        <div class="main-container container">
            <!-- Heading - "Welcome (Fullname of logged in user)!" -->
            <h5 class="my-2 container">
                Welcome 
                <?php
                    // establish connection 
                    include "dbconnect.php";
                    // query to fetch first and last name 
                    $sql = "SELECT FirstName,LastName FROM dbo.tblEmployee where TEAMUserName ='".$_SESSION['user']."'";
                    $stmt = sqlsrv_query($conn, $sql);
                    if($stmt === false){
                        die(print_r(sqlsrv_errors(), true));
                    }
                    if(sqlsrv_fetch($stmt) === false){
                        die(print_r(sqlsrv_errors(), true));
                    }
                    // store fetched first and last name in php variables 
                    $FirstName = sqlsrv_get_field( $stmt, 0);
                    $LastName = sqlsrv_get_field( $stmt, 1);
                    echo $FirstName." ".$LastName;
                ?>!
            </h5>
                     
            <!-- datatables buttons -->
            <div class="toolbar container" style="margin-bottom: 0.6rem;">
                <!-- new button --><button type="button" id="new" class="btn btn-primary">New</button>
                <!-- duplicate button --><button type="button" id="newsameas" class="btn btn-secondary disabled changeBtn">Duplicate</button>
                <!-- edit button --><button type="button" id="update" class="btn btn-secondary disabled changeBtn">Edit</button>
                <!-- delete button --><button type="button" id="delete" class="btn btn-secondary disabled changeBtn">Delete</button>
            </div>
            
            <!-- datatables table container  -->
            <div class="container">
                <table id="tblService" class="table table-striped table-bordered nowrap" style="width:100%">
                    <!-- table hearder row  -->
                    <thead>
                        <th data-field="ordeerno" data-sortable="true">Order No</th>
                        <th data-field="servicedate" data-sortable="true">Service Date</th>
                        <th data-field="customername" data-sortable="true" style="width: 23%;">Customer Name</th>
                        <th data-field="serviceid" data-sortable="true">Service ID</th>
                        <th data-field="submitted">Submitted</th>
                        <th data-field="reviewed">Reviewed</th>
                        <th data-field="processed">Processed</th>
                    </thead>
                    <!-- table body -->
                    <tbody>
                        <!-- fetch and display service reports in table rows  -->
                        <?php
                            $sql = "SELECT * FROM dbo.tblService 
                                    INNER JOIN dbo.tblCustOrders ON dbo.tblService.OrderID = dbo.tblCustOrders.OrderID 
                                    INNER JOIN dbo.tblCustomers ON dbo.tblCustOrders.CustID = dbo.tblCustomers.CustID 
                                    WHERE EmployeeID =".$_SESSION['EmployeeID'];
                            $result = sqlsrv_query($conn,$sql) or die("Couldn't execut query");

                            while ($data=sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
                                echo '<tr>';
                                echo '<td>'.$data['OrderNo'].'</td>';
                                echo '<td>'.date_format($data['ServiceDate'], 'M j Y').'</td>';
                                echo '<td>'.$data['CustomerName'].'</td>';
                                echo '<td>'.$data['ServiceID'].'</td>';
                                if($data['Submitted']==1){
                                    echo '<td style="text-align: center;"><input type="checkbox" class="submitTrue" name="submitted" checked onchange="this.checked =true;"></td>';
                                }
                                else{
                                    echo '<td style="text-align: center;"><input type="checkbox" class="submitFalse" name="submitted" onchange="this.checked = false;"></td>';
                                }
                                if($data['Reviewed']==1){
                                    echo '<td style="text-align: center;"><input type="checkbox" class="reviewTrue" name="reviewed"  checked onchange="this.checked = true;"></td>';
                                    }
                                    else{
                                    echo '<td style="text-align: center;"><input type="checkbox" class="reviewFalse" name="reviewed" onchange="this.checked = false;"></td>';
                                }
                                if($data['Processed']==1){
                                    echo '<td style="text-align: center;"><input type="checkbox" class="processTrue" name="processed" checked onchange="this.checked = true;"></td>';
                                    }
                                else{
                                    echo '<td style="text-align: center;"><input type="checkbox" class="processFalse" name="processed" onchange="this.checked = false;"></td>';
                                }
                                echo '</tr>' ;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

<!-- js  -->
<script>
    $(document).ready(function() {
        // initialize datatables 
        var table = $('#tblService').DataTable( {
            responsive: true, //responsive behavior for mobile
            "lengthChange": false,
            "order": [[ 3, "desc" ]], // order by ServiceID

            // change row colors- red: not submitted, yellow: submitted but not processed, green: submitted and processed
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
        });

        // when row is clicked, enable/disable datatables buttons 
        $('#tblService tbody').on( 'click', 'tr', function () {
            if($(this).hasClass('selected')){
                // remove class 'selected'
                $(this).removeClass('selected'); 
                // disable edit, sameas, and delete buttons 
                $(".changeBtn").addClass('disabled');
                $(".changeBtn").removeClass('btn-primary');
                $(".changeBtn").addClass('btn-secondary');
            }
            else{
                table.$('tr.selected').removeClass('selected');
                // add class 'selected'
                $(this).addClass('selected');
                // enable edit, sameas, and delete buttons 
                $(".changeBtn").removeClass('disabled');
                $(".changeBtn").removeClass('btn-secondary');
                $(".changeBtn").addClass('btn-primary');
            }
        } );

        // redirect to new service report page 
        $('#new').click( function () {
            Cookies.set("SRStatus", 0, { expires: 7, path: '/' });
            Cookies.set("EmployeeID", <?php echo $_SESSION['EmployeeID'];?>, { expires: 7, path: '/' });
            window.location = "../root/newservicereports.php";
        });
        
        // duplicate and add selected service report
        $('#newsameas').click( function () {
            // get selected ServiceID 
            var SRID = table.row('.selected').data()[3];
            // Ajax call to fetch and add fields same as selected service report
            $.ajax({
                type: "GET", // GET method to get data from server side
                url: 'duplicateSR.php', // redirect to server side code file
                data: {SRID:SRID}, // pass data 
                beforeSend: function (){},
                success: function (response) {
                    alert(response); // alert success message
                    location.reload(); // reload page
                }
            });
        });

        // redirect to update service report page 
        $('#update').click( function () {
            Cookies.set("SRStatus", 1, { expires: 7, path: '/' });
            var SRID = table.row('.selected').data()[3];
            Cookies.set("SRID", SRID, { expires: 7, path: '/' });
            window.location = "../root/updateservicereports.php"; 
        });

        // delete selected service report

        // $('#delete').click( function () {
        //     var SRID = table.row('.selected').data()[3];
        //     Cookies.set("SRID", SRID, { expires: 7, path: '/' });
        //     // confirm message
        //     if (confirm("Are you sure you want to delete this Service Report?")) {
        //         // Ajax call to delete selected service report
        //         $.ajax({
        //             type: "GET", // GET method to get data from server side
        //             url: 'deleteSR.php', // redirect to server side code file
        //             data: {SRID:SRID}, // pass data 
        //             beforeSend: function(){},
        //             success: function (response) {//once the request successfully process to the server side it will return result here
        //                 alert(response); // alert success message
        //                 table.row('.selected').remove().draw(false);
        //                 // disable edit, sameas, and delete buttons
        //                 $(".changeBtn").addClass('disabled');
        //                 $(".changeBtn").removeClass('btn-primary');
        //                 $(".changeBtn").addClass('btn-secondary');
        //             }
        //         });
        //     }
        // });

        // make datatables rows clickable
        $(".dtr-control").each(function() {
            $(this).click(function(){
                table.rows('.parent').nodes().to$().find('.dtr-control').not(this).trigger('click');
            });
        });        
    });
</script>