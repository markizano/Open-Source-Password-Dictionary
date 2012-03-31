<?php

if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) ) {
	header('Content-Type: text/plain');
	ini_set('html_errors', 0);
	require 'Kizano/Misc.php';
print Kizano_Misc::var_dump(array(
	'_GET' => $_GET,
	'_POST' => $_POST,
	'_COOKIE' => $_COOKIE,
	'_SERVER' => $_SERVER,
));
	die(__FILE__);
}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/2000/html5">
    <head>
        <title>Debugging</title>
        <script type="text/javascript">//<![CDATA[
var ospd = {}, DEBUG = true;
        //]]></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/?class=Kizano.Loader,default"></script>
    </head>
    <body>You must have JavaScript</body>
</html>

