<?php
/*Connect using SQL Server authentication.*/  
$serverName = "TEAM";  
$connectionOptions = array(  
    "Database" => "TEAM",  
    "UID" => "sa",  
    "PWD" => "langen!123",
    "CharacterSet"=>"UTF-8" 
);  
$conn = sqlsrv_connect($serverName, $connectionOptions);  
  
if ($conn === false)  
    {  
        echo "Could not connect.\n";
        print('<pre>');
        die( print_r( sqlsrv_errors(), true));
        print('</pre>');
    }  
?>