<?php

	session_start();

	if(!isset($_SESSION['login_user']))
	{
		header("location: login.php");
	}
	else
	{
		echo "<script type='text/javascript'>alert('Unauthorized');history.go(-1);</script>";
				
	}
?>

<?php

  session_start();

  try {
    if(!empty($_POST["username"]) && !empty($_POST["password"]))
    {
      $username = $_POST["username"];
      $password = $_POST["password"];

      // Create (connect to) SQLite database in file
      $db = new PDO('sqlite:/var/www/databases/database.sqlite');

      // Set errormode to exceptions
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // Look in the DB if the username/password are correct
      $result = $db->query("SELECT COUNT(*) as count FROM users WHERE username = '$username' AND password = '$password' AND active= 1");

      $count = $result->fetchColumn();

      if ($count == 1)
      {
        $_SESSION['login_user'] = $username;

        $result = $db->query("SELECT COUNT(*) as count FROM users WHERE username = '$username' AND admin= 1");
        $count = $result->fetchColumn();

        if($count == 1)
        {
          $_SESSION['admin'] = true;
	  header("location: admin_home.php");
        }
	else{
	   header("location: user_home.php");
	}
      }
      else
      {
        $_SESSION['wrong_password'] = true;
        header("location: login.php");
      }

    }
    else
    {
      $_SESSION['wrong_password'] = true;
      header("location: login.php");
    }
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

?>

