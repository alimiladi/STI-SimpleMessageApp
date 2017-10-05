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
  session_start();
  
  if(session_destroy())
  {
    //redirect to login page
    header("Location: login.php");
  }
?>
