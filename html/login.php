<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Login page</title>
</head>
	
  <body>


<?php

  session_start();

  //redirect to admin home if already connected and admin flag set to 1
  if(isset($_SESSION['login_user']) && isset($_SESSION['admin']))
  {
    header("location: admin_home.php");
  }
  //redirect to regular user home if connected and admin flag unset
  else if(isset($_SESSION['login_user']) && !isset($_SESSION['admin'])){
    header("location: user_home.php");
  }

  //if password was wrong show warning message
  if(isset($_SESSION['wrong_password']) && $_SESSION['wrong_password'])
  {
   	echo '<script type="text/javascript">
		alert("Login failed\nThe username/password doesn\'t match");
	</script>';

	//unset wrong_password flag
    $_SESSION['wrong_password'] = false;
  }
?>

<form id="login-form" action="process_login.php" method="post" role="form" style="display: block;">
<div class="form-group">
<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" required>
</div>
<div class="form-group">
<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" required>
</div>
<div class="form-group">
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

  </body>
</html>
