<?php
session_start();

setcookie("EmployeeID", "", time()-99999999);
setcookie("SRID", "", time()-9999999);
setcookie("SRStatus", "", time()-9999999);
setcookie("selID", "", time()-99999999);

setcookie("PHPSESSID", '', time()-9999999);
session_unset();
session_destroy();
$_SESSION = array();

header('Location:index.php');
?> 