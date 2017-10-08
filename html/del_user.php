<!--
		This script aims to delete a user from the database.
		This is not meant to be accessed by a normal user. Only admins should have access to this functionnality.
		The information about the user to be deleted is transmitted by a get method from the previous page (all_users.php)
-->

<html>
	<head>
	</head>
	<body>
		<?php
		/**********************************************************************************************************************************************/
		/*							Authentication checks								      */
		/**********************************************************************************************************************************************/

			// Checking whether the user is logged in...
			session_start();
			if(!isset($_SESSION['login_user'])){
			// ...If not, redirect to the login page
				header("location: login.php");
			}
			else{
			// In the case that he isn't an admin user, show a popup error and go back to the previous page.
				if (isset($_SESSION['admin'])){
					$username = $_SESSION['login_user'];
				}
			else{
					echo "<script type='text/javascript'>alert('Unauthorized');history.go(-1);</script>";
				}
			}

			try{
				// Create (connect to) SQLite database in file
				$dbconn = new PDO('sqlite:/var/www/databases/database.sqlite');
				// Set errormode to exceptions
				$dbconn->setAttribute(PDO::ATTR_ERRMODE,
						    PDO::ERRMODE_EXCEPTION);
				// Delete the row having username stored in the variable $username (stored in the session variable $_SESSION)
				$dbconn->exec("DELETE FROM users WHERE id = '".$_GET['id']."';");

				// Close file db connection
				$dbconn = null;
			}
			catch(PDOException $e) {
				// Print PDOException message
				echo $e->getMessage();
			}

			// Show a popup message telling that the operation has been done correctly and redirecing to 'all_users.php'
			echo "<script type='text/javascript'>alert("User correctly deleted");</script>";
			header("location: all_users.php");
		?>
	</body>
</html>
