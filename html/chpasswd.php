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
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Change password</title>
	</head>
	<body>
		<h3>Enter your new password</h3>
		<form action="chpasswd.php" method="post">
			<label>New password :</label>
			<input type="password" name="Password" class="Password" id="Password" placeholder="*****" required> <br>
			<input type="submit" name="submit" value="submit">
		</form>
		<button onclick="self.location.href='logout.php'" class="logout">Log out</button></br></br>
		<?php
			try{			
				// Create (connect to) SQLite database in file
				$dbconn = new PDO('sqlite:/var/www/databases/database.sqlite');
				// Set errormode to exceptions
				$dbconn->setAttribute(PDO::ATTR_ERRMODE, 
						    PDO::ERRMODE_EXCEPTION); 
				//Checking whether fields are correctly set by user
				if(isset($_POST['Password'])){
					$dbconn->exec("UPDATE users SET password = '{$_POST['Password']}' WHERE username = '$username';");
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

