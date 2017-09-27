<?php
	session_start();
	if(!isset($_SESSION['login_user']))
	{
		header("location: login.php");
	}
	else
	{
		try{
			// Create (connect to) SQLite database in file
			$dbconn = new PDO('sqlite:/var/www/databases/database.sqlite');
			// Set errormode to exceptions
			$dbconn->setAttribute(PDO::ATTR_ERRMODE,
			PDO::ERRMODE_EXCEPTION);

			$result = $dbconn->query("SELECT COUNT(*) as count FROM users WHERE username = '$username' AND admin = 1");
			$count = $result->fetchColumn();

			if($count == 1)
			{
			  $_SESSION['admin'] = true;
			  header("location: admin_home.php");
			}
			else{
			   header("location: user_home.php");
			}

			// Close file db connection
			$dbconn = null;
		}

		catch(PDOException $e) {
			// Print PDOException message
			echo $e->getMessage();
		}

		$username = $_SESSION['login_user'];
		header("location: login.php");
	}
?>
