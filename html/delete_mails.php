<!--
	In this script we delete a message in the database. We use the 		message_id and the current_user_id to access the message with a SQL request. 
-->
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

  try {

    if(!empty($_GET['message_id']))
    {

      $message_id = $_GET['message_id'];

      // Create (connect to) SQLite database in file
      $db = new PDO('sqlite:/var/www/databases/database.sqlite');

      // Set errormode to exceptions
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // There we get id of user connected
      $result = $db->query("SELECT id FROM users WHERE username = '$username'");
      $current_user = $result->fetch();
      $id_current_user = $current_user['id'];

      // There we check if the user who delete is the receiver
      $result = $db->query("SELECT COUNT(*) as count FROM messages WHERE id = '$message_id' AND receiver_id = '$id_current_user'");
      $count = $result->fetchColumn();

      if($count == 1)
      {
        // There we delete the message 
        $result = $db->query("DELETE FROM messages WHERE id = '$message_id'");

        $_SESSION['message_deleted'] = true;
      }

      header("location: index.php");
    }
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

?>
