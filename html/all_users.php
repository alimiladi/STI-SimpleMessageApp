
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
<html>
	<head>
		<title>Registred users</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h3>All registred users</h3>
		<?php
			try{			
				// Create (connect to) SQLite database in file
				$dbconn = new PDO('sqlite:/var/www/databases/database.sqlite');
				// Set errormode to exceptions
				$dbconn->setAttribute(PDO::ATTR_ERRMODE, 
						    PDO::ERRMODE_EXCEPTION); 

				$users = $dbconn->query("SELECT * FROM users");
				
				foreach($users as $row) {
					if($row['enable'] == 1){
						if($row['admin'] == 1)){
							echo "<p>";
							echo "Username: " . $row['username'] . "<br/>";
							echo "Active: yes <br/>";
							echo "Admin:  yes <br/>";
//							echo "<button self.location.href='disable.php' class='logout'>Disable</button>";
							echo "<br/>";
							echo "</p>";
						}
						else{
							echo "<p>";
							echo "Username: " . $row['username'] . "<br/>";
							echo "Active: yes <br/>";
							echo "Admin:  no <br/>";
//							echo "<button self.location.href='disable.php' class='logout'>Disable</button>";
							echo "<br/>";
							echo "</p>";
						}
					}
					else{
						if($row['admin'] == 1)){
							echo "<p>";
							echo "Username: " . $row['username'] . "<br/>";
							echo "Active: no <br/>";
							echo "Admin:  yes <br/>";
//							echo "<button self.location.href='enable.php' class='logout'>Enable</button>";
							echo "<br/>";
							echo "</p>";
						}
						else{
							echo "<p>";
							echo "Username: " . $row['username'] . "<br/>";
							echo "Active: no <br/>";
							echo "Admin:  no <br/>";
//							echo "<button self.location.href='enable.php' class='logout'>Enable</button>";
							echo "<br/>";
							echo "</p>";
						}
					}
				}
				
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
