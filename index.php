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
			$passwordList = "default"; // Name of the password list
			// $passwordList = "db/".$passwordList // Using a db folder
			// $passwordList = $passwordList.".db" // Using a .db extension
			
			// Listing all passwords
			if ($_GET['action'] == "list") {
				foreach (file($passwordList) as $linenum => $line) {
					if ($_GET['mode'] == "linenum") print("#<b>".$linenum.": ");
					print(htmlspecialchars($line));
					print("<br />\n");
				}
				exit();
			}
			
			// Adding a new password			
			$passwordFile = fopen($passwordList, "a");
			
			// TODO: Use AJAX to add passwords on return-key-press and without reload on button press
			
			$newPassword = trim($_GET['password']); // Removing \n, \r and other stuff

			if (isset($newPassword)) {
				fwrite($passwordFile, $newPassword);
			}
			
			fclose($passwordFile);
		?>
	</body>
</html>

