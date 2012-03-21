<?php
	if (!(array_key_exists('mode', $_GET) && !($_GET['mode'] == "raw"))) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>#theblackmatrix Password List</title>
	</head>
	<body>
<?php
	}
?>
		<?php
			$passwordList = "default"; // Name of the password list
			if (!file_exists("db")) mkdir("db"); // Creating the db folder if it doesn't exist
			if (file_exists("db")) $passwordList = "db/".$passwordList; // Using a db folder
			else die("Please set the right permissions on the 'db' folder.");
			$passwordList = $passwordList.".db"; // Using a .db extension
			
			$passwordArray = file($passwordList);
			
			// Listing all passwords
			if (array_key_exists('action', $_GET) && $_GET['action'] == "list") {
				foreach ($passwordArray as $linenum => $line) {
					if (array_key_exists('mode', $_GET) && $_GET['mode'] == "linenum") print("#<b>".$linenum.":</b> ");
					print(htmlspecialchars($line));
					if (!(array_key_exists('mode', $_GET) && !($_GET['mode'] == "raw"))) print("<br />");
					print("\n");
				}
				if (array_key_exists('mode', $_GET) && $_GET['mode'] == "raw") exit();
			}
			
			// Adding a new password			
			$passwordFile = fopen($passwordList, "a");
			
			// TODO: Use AJAX to add passwords on return-key-press and without reload on button press
			
			// Adding the password
			if (array_key_exists('password', $_GET)) {
				$newPassword = trim($_GET['password']); // Removing \n, \r and other stuff
				if (!in_array($newPassword."\r\n", $passwordArray)) { // TODO: Is this check fast enough?
					fwrite($passwordFile, $newPassword."\r\n");
					fclose($passwordFile);
					
					print("Successfully added '".$newPassword."' to the list!");
				} else print("This password already exists in the database!");
			}
			if (array_key_exists('mode', $_GET) && $_GET['mode'] == "raw") exit(); // Do not display the form in raw-mode
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

