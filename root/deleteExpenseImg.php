<?php
    // Check if cookie exists
    $request = $_REQUEST;
    $imgID = $request['imgID'];

	unlink($imgID);
?>