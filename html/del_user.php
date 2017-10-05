<html>
	<head>
		<script type="text/javascript">
			function show_alert() {
		   		alert("User correctly deleted");
			}
		</script>
	</head>
	<body>
		<?php
			session_start();
			if(!isset($_SESSION['login_user'])){
				header("location: login.php");
			}
			else{
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
			echo "<script type='text/javascript'>show_alert();</script>";
			header("location: all_users.php");
		?>
	</body>
</html>


