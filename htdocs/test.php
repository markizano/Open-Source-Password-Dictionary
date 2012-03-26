<?php

if ( isset($_SERVER['X_REQUESTED_WITH']) ) {
	header('Content-Type: text/plain');
	ini_set('html_errors', 0);
}

var_dump(array(
	'_GET' => $_GET,
	'_POST' => $_POST,
	'_COOKIE' => $_COOKIE,
	'_SERVER' => $_SERVER,
));
