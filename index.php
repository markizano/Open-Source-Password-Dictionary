<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
	</head>
	<body>
		<h2>ADD A PASSWORD TO THE LIST: </h2>
		<form action="index.php" method="get">
			<input type="text" name="password" />
			<input type="submit" value="Add" />
		</form>
		<br />
		<br />
		<h2>Current List: </h2>
		<?php
			//When running this .php script, there should be a file in the same directory
			//named server.php built in the following format:
			//<php
			//$server_addr = SERVER ADDRESS (usually "127.0.0.1");
			//$user_name = USER_NAME (for example "root");
			//$mysql_password = PASSWORD (for example "toor");
			//>
			require("server.php");	
			$con = mysql_connect($server_addr,$user_name,$mysql_password);
			mysql_select_db("passwordDictionary", $con);

			$newPassword = $_GET['password'];

			if(isset($newPassword))
			{
				mysql_query("INSERT INTO dictionary (password) VALUES ('".$newPassword."')");
			}

			if(!$con)
			{
				die("Could not connect to server: ".mysql_error());
			}
			
			$passwordList = mysql_query("SELECT password FROM dictionary");

			while($password = mysql_fetch_array($passwordList))
			{
				echo $password['password'] . "<br />";
			}

			mysql_close($con);

		?>
	</body>
</html>

