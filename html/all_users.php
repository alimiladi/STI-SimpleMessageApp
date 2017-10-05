<!DOCTYPE html>
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
	// In the case that he isn't an admin user, show a popup error and go back to the privious page.
		if (isset($_SESSION['admin'])){
			$username = $_SESSION['login_user'];
		}
	else{
			echo "<script type='text/javascript'>alert('Unauthorized');history.go(-1);</script>";
		}
	}
?>

<html>
	<head>
		<title>Registred users</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".submit").click(function(){
					alert("Changes saved successfully");				
				});
			});
		</script>
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

				// This section aims to display a different form for each registered user in the DB.
				foreach($users as $row) {
					echo "<div class='all-users'>";
					if($row['active'] == 1){
						if($row['admin'] == 1){
							echo "<form method='post' action='admin_active.php?fetched_id=".$row['id']."'>";
							echo "<label>Username: " .$row['username']."</label><br/>";					
							echo "<label>Active: </label>";
							echo "<input type='checkbox' name='active' value='active' checked><br/>";
							echo "<label>Admin: </label>";
							echo "<input type='checkbox' name='admin' value='admin' checked><br/>";
							echo "<input type='submit' name='".$row['id']."' value='save_changes' class='submit'>";     
							echo "</form>";
							echo "<button name='delete' onclick=\"self.location.href='del_user.php?id=".$row['id']."'\" class=\"logout\">delete</button>";
						}
						else{
							echo "<form method='post' action='admin_active.php?fetched_id=".$row['id']."'>";
							echo "<label>Username: " .$row['username']."</label><br/>";					
							echo "<label>Active: </label>";
							echo "<input type='checkbox' name='active' value='active' checked><br/>";
							echo "<label>Admin: </label>";
							echo "<input type='checkbox' name='admin' value='admin'><br/>";
							echo "<input type='submit' name='".$row['id']."' value='save_changes' class='submit'>";
							echo "</form>";
							echo "<button name='delete' onclick=\"self.location.href='del_user.php?id=".$row['id']."'\" class=\"logout\">delete</button>";
						}
					}
					else{
						if($row['admin'] == 1){
							echo "<form method='post' action='admin_active.php?fetched_id=".$row['id']."'>";
							echo "<label>Username: " .$row['username']."</label><br/>";					
							echo "<label>Active: </label>";
							echo "<input type='checkbox' name='active' value='active'><br/>";
							echo "<label>Admin: </label>";
							echo "<input type='checkbox' name='admin' value='admin' checked><br/>";
							echo "<input type='submit' name='".$row['id']."' value='save_changes' class='submit'>";
							echo "</form>";
							echo "<button name='delete' onclick=\"self.location.href='del_user.php?id=".$row['id']."'\" class=\"logout\">delete</button>";
						}
						else{
							echo "<form method='post' action='admin_active.php?fetched_id=".$row['id']."'>";
							echo "<label>Username: " .$row['username']."</label><br/>";					
							echo "<label>Active: </label>";
							echo "<input type='checkbox' name='active' value='active'><br/>";
							echo "<label>Admin: </label>";
							echo "<input type='checkbox' name='admin' value='admin' ><br/>";
							echo "<input type='submit' name='".$row['id']."' value='save_changes' class='submit'>";
							echo "</form>";
							echo "<button name='delete' onclick=\"self.location.href='del_user.php?id=".$row['id']."'\" class=\"logout\">delete</button>";
						}
					}
					echo "</div>";
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
		<button onclick="self.location.href='logout.php'" class="logout">Log out</button></br></br>
	</body>
</html>
