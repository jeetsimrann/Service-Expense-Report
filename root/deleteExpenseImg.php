<?php
    // Server-side code to delete task line
    
    // requesting image name
    $request = $_REQUEST;
    $imgID = $request['imgID'];

    // deleting image 
	unlink($imgID);
?>