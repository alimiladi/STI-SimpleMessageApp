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

<?php
//redirect user to login if he is not connected otherwise redirect to its inbox
if(!isset($_SESSION['login_user']))
{
  header("location: login.php");
}
else
{
  header("location: save_users.php");
}
 ?>
