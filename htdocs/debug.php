<?php

ob_start();
var_dump(array(
	'_GET' => $_GET,
	'_POST' => $_POST,
	'_COOKIE' => $_COOKIE,
	'_SERVER' => $_SERVER,
));
$debug = ob_get_clean();

if ( isset($_SERVER['X_REQUESTED_WITH']) ) {
	header('Content-Type: text/plain');
	ini_set('html_errors', 0);
	print $debug;
	die(__FILE__);
}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/2000/html5">
    <head>
        <title>Debugging</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/default.js"></script>
    </head>
    <body>Blargh</body>
</html>

