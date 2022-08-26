<!-- the code validates the passed username and password from index.php  -->
<?php
  session_start();
  $_SESSION['user'] = "";
  $_SESSION['EmployeeID'] = "";
?>

<head>
  <!-- title and application icon  -->
  <title>AFA Expenses</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <link rel="stylesheet" href="assets\css\style.css"/>
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700"/>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- JQuery CDN  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<?php
  // connect to database 
  include "root\dbconnect.php";
  // event triggered from login button in index.php 
  if(isset($_POST['login'])){
    $_SESSION['user'] = $_POST['username'];
    // calling store procedure to validate username and password and adding employee record to table tblUserEvents 
    $tsql_callSP = "{call sp_uspLogin_v2(?,?,?,?)};";
    // input/output parameters for stored procedure
    $pLoginName = &$_POST['username'];
    $pPassword = &$_POST['password'];
    $ComputerName = "mobile";
    $responseMessage = "Incorrect password";

    $params = array(array($pLoginName, SQLSRV_PARAM_IN),
                      array($pPassword, SQLSRV_PARAM_IN), 
                      array($ComputerName, SQLSRV_PARAM_IN), 
                      array(&$responseMessage, SQLSRV_PARAM_OUT));
    // executing stored procedure
    $stmt = sqlsrv_query($conn, $tsql_callSP, $params); 
    // throw error for store procedure 
    if( $stmt === false ){  
        echo "Error in executing validation statement.\n";  
        die(print_r( sqlsrv_errors(), true));  
    }  
    sqlsrv_next_result($stmt);

    // if validation is success 
    // getting employeeID for logged in user 
    if($responseMessage == "Success"){
      $sql = "SELECT EmployeeID FROM tblEmployee WHERE TEAMUserName ='".$pLoginName."'";
      $stmt = sqlsrv_query( $conn, $sql);
      if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
      }
      
      // throw error if unable to fetch employeeID
      if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
      }

      // Setting session cookie EmployeeID and userLoginStatus to true (1) 
      $EmployeeID = sqlsrv_get_field( $stmt, 0);
      $_SESSION['EmployeeID'] = $EmployeeID;
      $_SESSION['userLoginStatus'] = 1;
      // loader splash screen for successful login 
      echo "<script>
            $(window).on('load', function() {
              window.location='root/dashboard.php'; 
              function modalfunction(){ $('#preloader').modal('show')};
              //for use in production please remove this setTimeOut
              setTimeout(function(){ 
                  $('.preloader').addClass('preloader-deactivate');
              }, 5000);
              //uncomment this line for use this snippet in production
              //	$('.preloader').addClass('preloader-deactivate');
            });
            </script>
            
            <div class='preloader' id='preloader'>
                <div class='loader' style='top: 35%; width: auto; color:white;' >
                  <h4 >Login Sucessful,</h4>
                  <h4> you're being redirected...</h4>
                </div>
                <div class='loader'>
                    <div class='loader-outter'></div>
                    <div class='loader-inner'></div>

                    <div class='indicator'> 
                        <svg width='16px' height='12px'>
                            <polyline id='back' points='1 6 4 6 6 11 10 1 12 6 15 6'></polyline>
                            <polyline id='front' points='1 6 4 6 6 11 10 1 12 6 15 6'></polyline>
                        </svg>
                    </div>
                </div>
            </div>";
    }
    // if validation is failed (wrong credentials)
    else{
      $_SESSION['userLoginStatus'] = 0;
      
      // loader splash screen for failed login 
      echo "
            <script>
            $(window).on('load', function() {
              
              $('.preloader').delay(1000).show(0);
              $('.preloader').delay(5000).hide(0);
              setTimeout(function(){window.location='index.php';}, 3000);
            });
            </script>
            
            <div class='preloader dangermessage' id='preloader'>
                <div class='loader' style='top: 35%; width: auto; color:white;' >
                  <h4></h4><br>
                  <h4 >Invalid Credentials, please try again...</h4>
                </div>
                <div class='loader'>
                    <div class='loader-outter'></div>
                    <div class='loader-inner'></div>

                    <div class='indicator'> 
                        <svg width='16px' height='12px'>
                            <polyline id='back' points='1 6 4 6 6 11 10 1 12 6 15 6'></polyline>
                            <polyline id='front' points='1 6 4 6 6 11 10 1 12 6 15 6'></polyline>
                        </svg>
                    </div>
                </div>
            </div>";
    }
    // free statement
    sqlsrv_free_stmt($stmt); 
    // close connection
    sqlsrv_close($conn);
  }
?>