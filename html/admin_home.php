<!DOCTYPE html>
<!--
	This page is the landing page for an admin user.
	Admins can create new users, display all registered ones, modify their access/validity and delete them.
	Admins also can deal with messages as regular users do.   
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

<html>
	<head>
		<title>Admin home</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>

		<h3>Admin home</h3>
		<button onclick="self.location.href='list_received_mails.php'">View received messages</button><br/>
		<button onclick="self.location.href='mailbox.php'">New message</button><br/>
		<button onclick="self.location.href='chpasswd.php'">Change password</button><br/>
		<button onclick="self.location.href='manage_users.php'">Manage users</button><br/>
		<button onclick="self.location.href='logout.php'" class="logout">Logout</button><br/>
	</body>

</html>
