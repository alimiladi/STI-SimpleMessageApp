<!DOCTYPE html>
<!--
	This is the landing page for a regular user of the app.
	A regular user has it's 'admin' flag turned off in the database.
	The features proposed to this kind of users are about handling messages.
	They can display all received messages in a kind of mailbox, shos any message details, answer a message and delete it.
	They don't have access to any of the admin pages.
-->

<?php
/**********************************************************************************************************************************************/
/*							Authentication checks								      */
/**********************************************************************************************************************************************/
	
	session_start();
	// Checking whether the user is logged in...
	if(!isset($_SESSION['login_user'])){
	// ...If not, redirect to the login page
		header("location: login.php");
	}
	else{
	// In the case that he is an admin user, this mean that he isn't allowed to access this page.
	// A popup error message is shown and he gets redirected back to the previous page. 
		if (!isset($_SESSION['admin'])){
			$username = $_SESSION['login_user'];
		}
		else{
			echo "<script type='text/javascript'>alert('Unauthorized');history.go(-1);</script>";
		}
	}
?>
<html>
	<head>
		<title>Regular user home</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>

		<h3>User home</h3>
		<button onclick="self.location.href='list_received_mails.php'">View received messages</button><br/>
		<button onclick="self.location.href='mailbox.php'">New message</button><br/>
		<button onclick="self.location.href='chpasswd.php'">Change password</button><br/>
		<button onclick="self.location.href='logout.php'" class="logout">Logout</button><br/>
	</body>

</html>
