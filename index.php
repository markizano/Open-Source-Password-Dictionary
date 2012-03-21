<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
	</head>
	<body>
		<?php
			$passwordList = "default"; // Name of the password list
			mkdir("db"); if (file_exists("db")) $passwordList = "db/".$passwordList; // Using a db folder
			$passwordList = $passwordList.".db"; // Using a .db extension
			
			// Listing all passwords
			if ($_GET['action'] == "list") {
				foreach (file($passwordList) as $linenum => $line) {
					if ($_GET['mode'] == "linenum") print("#<b>".$linenum.":</b> ");
					print(htmlspecialchars($line));
					if ($_GET['mode'] != "raw") print("<br />");
					print("\n");
				}
				exit();
			}
			
			// Adding a new password			
			$passwordFile = fopen($passwordList, "a");
			
			// TODO: Use AJAX to add passwords on return-key-press and without reload on button press
			
			// Adding the password
			$newPassword = trim($_GET['password']); // Removing \n, \r and other stuff
			fwrite($passwordFile, $newPassword);
			fclose($passwordFile);
			
			print("Successfully added '".$newPassword."' to the list!");
		?>
		<p>
			<h2>ADD A PASSWORD TO THE LIST: </h2>
			<form action="index.php" method="get">
				<input type="text" name="password" />
				<input type="submit" value="Add" />
			</form>
		</p>
		<p>
			<a href="?action=list">Password list (<?php print($passwordList); ?>)</a>
		</p>
	</body>
</html>

