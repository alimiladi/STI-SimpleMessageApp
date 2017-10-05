<?php
	session_start();

	if(!isset($_SESSION['login_user']))
	{
		header("location: login.php");
	}
	else
	{

		echo "<script type='text/javascript'>alert('Unauthorized');history.go(-1);</script>";
			
	}
?>
<!DOCTYPE html>
<!--ajouter un user-->
<html>
	<head>
		<title>Add a new user</title>
		<meta charset="utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
	
	</head>
	<body>

		<?php
			
					

			try{			
				// Create (connect to) SQLite database in file
				$dbconn = new PDO('sqlite:/var/www/databases/database.sqlite');
				// Set errormode to exceptions
				$dbconn->setAttribute(PDO::ATTR_ERRMODE, 
						    PDO::ERRMODE_EXCEPTION); 
				
				//Checking for checkboxes validity
				if(isset($_POST['active'])){
					if(isset($_POST['admin'])){
						$dbconn->exec("UPDATE users SET active = '1', admin='1' WHERE id = '".$_GET['fetched_id']."';");
					}
					else{
						$dbconn->exec("UPDATE users SET active = '1', admin='0' WHERE id = '".$_GET['fetched_id']."';");
					}
				}
				else{
					if(isset($_POST['admin'])){
						$dbconn->exec("UPDATE users SET active = '0', admin='1' WHERE id = '".$_GET['fetched_id']."';");
					}
					else{
						$dbconn->exec("UPDATE users SET active = '0', admin='0' WHERE id = '".$_GET['fetched_id']."';");
					}
				}
				// Redirect to originating page
				header("location: all_users.php");
				
				// Close file db connection
	    			$dbconn = null;
			}
			catch(PDOException $e) {
				// Print PDOException message
				echo $e->getMessage();
			}
		?>
	</body>
</html>
