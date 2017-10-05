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
<!--ajouter un user-->
<html>
	<head>
		<title>Add a new user</title>
		<meta charset="utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">
			$(document).ready(function(){
			    $(".create").click(function(){
				alert("User created successfully");				
			    });
			});
		</script>
	</head>
	<body>
		<h3>Add a user</h3>

		<form action="new_user.php" method="post">
			<label>Username :</label>
			<input type="text" name="Username" class="Username" id="usrname" placeholder="username" required> <br>
			<label>Password :</label>
			<input type="password" name="Password" class="Password" id="passwd" placeholder="*****" required><br>
			<label>Active :</label>			
			<input type="checkbox" name="active" value="active" class="active-check" checked><br/>
			<label>Admin :</label>			
			<input type="checkbox" name="admin" value="admin" class="admin-check"><br/><br/>
			<input type="submit" value="create" id="signin" name="create" class="create">
		</form>
		<button onclick="self.location.href='logout.php'" class="logout">Log out</button></br></br>
		<?php
/**********************************************************************************************************************************************/
/*BEBUG
			print "Username: " .$_POST['Username']. "<br/>";
			print "Password: " .$_POST['Password']. "<br/>";
			if(isset($_POST['active'])){
				print "Active: " .$_POST['active']. "<br/>";
			}
			if(isset($_POST['admin'])){
				print "Admin: " .$_POST['admin']. "<br/><br/>";
			}
/**********************************************************************************************************************************************/

/**********************************************************************************************************************************************/
/*DB Interactions*/
/**********************************************************************************************************************************************/
			try{			
				// Create (connect to) SQLite database in file
				$dbconn = new PDO('sqlite:/var/www/databases/database.sqlite');
				// Set errormode to exceptions
				$dbconn->setAttribute(PDO::ATTR_ERRMODE, 
						    PDO::ERRMODE_EXCEPTION); 
				//Checking whether fields are correctly set by user
				if(isset($_POST['Username']) && isset($_POST['Password'])){
					//Checking for checkboxes validity
					if(isset($_POST['active'])){
						if(isset($_POST['admin'])){
							$dbconn->exec("INSERT INTO users (username, enable, password, admin) 
							VALUES ('{$_POST['Username']}', '1', '{$_POST['Password']}', '1')");
						}
						else{
							$dbconn->exec("INSERT INTO users (username, enable, password, admin) 
							VALUES ('{$_POST['Username']}', '1', '{$_POST['Password']}', '0')");
						}
					}
					else{
						if(isset($_POST['admin'])){
								$dbconn->exec("INSERT INTO users (username, enable, password, admin) 
								VALUES ('{$_POST['Username']}', '0', '{$_POST['Password']}', '1')");
							}
							else{
								$dbconn->exec("INSERT INTO users (username, enable, password, admin) 
								VALUES ('{$_POST['Username']}', '0', '{$_POST['Password']}', '0')");
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
		<button onclick="history.go(-1);">Back</button>
	</body>
</html>
