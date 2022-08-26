<!-- setting isLogged in session cookie to 0 (not logged in)  -->
<?php
  session_start();
  $_SESSION['userLoginStatus'] = 0;
?>

<!DOCTYPE html>
  <html>
    <head>
      <!-- title and application icon  -->
      <title>AFA Expenses</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="apple-mobile-web-app-capable" content="yes" />
      <meta name="theme-color" content="#FFF" />
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
      <script id='wpacu-combined-js-head-group-1' type='text/javascript' src='https://www.afasystemsinc.com/wp-content/cache/asset-cleanup/js/head-5e3e4d2c92fdd7fbfd909d433c07b6d9193b10e1.js'></script><link rel="https://api.w.org/" href="https://www.afasystemsinc.com/wp-json/" /><link rel="alternate" type="application/json" href="https://www.afasystemsinc.com/wp-json/wp/v2/pages/11" /><meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" /><meta name="google-site-verification" content="U_fWjqoTqoM87P1nyU91rpuLqqR0v2Yq6ZxPgKTOHF8"><link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-32x32.png" sizes="32x32" />
      <link rel="icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-192x192.png" sizes="192x192" />
      <link rel="apple-touch-icon" href="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-180x180.png" />
      <meta name="msapplication-TileImage" content="https://www.afasystemsinc.com/wp-content/uploads/2019/12/cropped-AFA_favicon-01-270x270.png" />
      <!-- html and body css and disabling scroll bar  -->
      <style>
        html, body {margin: 0; height: 100%; overflow: hidden;}
      </style> 
      <!-- css file -->
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
    <body>
      <!-- php header file  -->
      <?php require 'utilities/header.php'; ?>
      
      <section style="height: 85%; /*background-color: #f8f9fa!important;*/" class="d-flex align-items-center justify-content-center min">
        <!-- login fields form  -->
        <form id="loginForm" method="post" action="validateLogin.php" enctype="multipart/form-data" style="width: 100%;">
          <!-- login form container  -->
          <div class="container py-3 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
              <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                  <div class="card-body p-5 text-center">
                    <h3 class="mb-5">
                      Login
                    </h3>
                    <!-- username field  -->
                    <div class="form-outline mb-4">
                      <label class="form-label" for="username">
                        User Name
                      </label>
                      <div>
                          <input type="text" id="username" name="username" class="form-control form-control-lg" required/>
                      </div>
                    </div>
                    <div class="form-outline mb-4">
                      <!-- password field  -->
                      <label class="form-label" for="password">
                        Password
                      </label>
                      <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
                    </div>
                    <!-- remember me checkbox -->
                    <div class="form-check d-flex justify-content-start mb-4">
                      <input class="form-check-input" type="checkbox" value="" id="rememberme"/>
                      <label class="form-check-label " for="rememberme" style="margin-left: 0.5rem;"> Remember password </label>
                    </div>
                    <hr class="my-4">
                    <!-- login button  -->
                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="login" id="login">Login</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </section>
    </body>
  </html>