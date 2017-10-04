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
