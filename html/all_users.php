
<?php
      session_start();

      if(!isset($_SESSION['login_user']))
      {
        header("location: login.php");
      }
      else
      {
        $username = $_SESSION['login_user'];
      }
?>

<!DOCTYPE html>
<!--ajouter/supprimer un user-->
<html>
	<head>
		<title>Registred users</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<?php
			try{			
				// Create (connect to) SQLite database in file
				$dbconn = new PDO('sqlite:/var/www/databases/database.sqlite');
				// Set errormode to exceptions
				$dbconn->setAttribute(PDO::ATTR_ERRMODE, 
						    PDO::ERRMODE_EXCEPTION); 
				//Checking whether fields are correctly set by user
				if(isset($_POST['Password'])){
					$users = $dbconn->query("SELECT * FROM users");
				}	
				// Close file db connection
	    			$dbconn = null;
			}
			catch(PDOException $e) {
				// Print PDOException message
				echo $e->getMessage();
			}
		?>
		<h3>All registred users</h3>
		
	</body>
</html>
