<!--
	In this script we send a message to the correct user.
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
    if(!empty($_POST["receiver"]) && !empty($_POST["title"]) && !empty($_POST["message"]))
    {
      // There we retrieve informations about message
      $receiver = $_POST["receiver"];
      $title = $_POST["title"];
      $message_content = $_POST["message"];

      // Create (connect to) SQLite database in file
      $db = new PDO('sqlite:/var/www/databases/database.sqlite');

      // Set errormode to exceptions
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // there we get the receiver_id
      $result = $db->query("SELECT id FROM users WHERE username = '$receiver'");
      $receiver = $result->fetch();
      $receiver_id = $receiver['id'];

      // There we get the current_user_id
      $result = $db->query("SELECT id FROM users WHERE username = '$username'");
      $current_user = $result->fetch();
      $id_current_user = $current_user['id'];

      $db->query("INSERT INTO messages(title, message, time, sender_id, receiver_id) VALUES ('". $title ."','". $message_content ."', datetime(),'" . $id_current_user . "','" . $receiver_id . "' )");

      $_SESSION['message_sent'] = true;
      header("location: index.php");

    }
    else
    {
      echo '<h2>The Title or Content are empty, <br/> Please fill them</h2>';
    }
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

?>
