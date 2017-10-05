<!DOCTYPE html>

<!--
	This is the interface that permits to an admin to manage the users registred in the database.
	An admin user can modify the current user's access rights, create new ones and delete them.
-->

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

<!--ajouter/supprimer un user-->
<html>
	<head>
		<title>Manage users</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h3>Manage users</h3>
		<button name="new_user" onclick="self.location.href='new_user.php'">New user</button><br/>
		<button name="show_users" onclick="self.location.href='all_users.php'">Show registred users</button><br/>
		<button name="logout" onclick="self.location.href='logout.php'" class="logout">Log out</button><br/><br/>
	</body>
</html>
