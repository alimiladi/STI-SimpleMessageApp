
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
		<title>Manage users</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h3>Manage users</h3>
		<button name="new_user" onclick="self.location.href='new_user.php'">New user</button><br/>
		<button name="show_users" onclick="self.location.href='all_users.php'">Show registred users</button><br/>
		<button name="logout" onclick="self.location.href='logout.php'" class="logout">Log out</button><br/><br/>
		<button onclick="history.go(-1);">Back</button>
	</body>
</html>
