<!DOCTYPE html>
<!--lire messages
écrire un nouveau message
gérer les users (admin)
changer le mdp-->
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

<html>
	<head>
		<title>Admin home</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>

		<h3>Admin home</h3>
		<button onclick="self.location.href='mailbox.php'">View messages</button><br/>
		<button onclick="self.location.href='new.php'">New message</button><br/>
		<button onclick="self.location.href='chpasswd.php'">Change password</button><br/>
		<button onclick="self.location.href='manage_users.php'">Manage users</button><br/>
		<button onclick="self.location.href='logout.php'" class="logout">Logout</button><br/>
	</body>

</html>
