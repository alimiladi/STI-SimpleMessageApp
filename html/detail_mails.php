
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Details</title>
<script src="/answer_mails.js"></script>

</head>
<body>
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

      // Get info about the message
      $result = $db->query("SELECT * FROM messages WHERE id = '$message_id'");
      $message = $result->fetch();

      // Get id of current user
      $result = $db->query("SELECT id FROM users WHERE username = '$username'");
      $current_user = $result->fetch();
      $id_current_user = $current_user['id'];

      // Check if the user who want to see the message is the recipient
      $result = $db->query("SELECT COUNT(*) as count FROM messages WHERE id = '$message_id' AND receiver_id = '$id_current_user'");
      $count = $result->fetchColumn();

      if($count == 1)
      {
        //retrieve sender identity
        $id_sender = $message['sender_id'];
        $result_sender = $db->query("SELECT username FROM users WHERE id = '$id_sender'");
        $sender = $result_sender->fetch();

        echo '<div class="container">';
        
	echo $message['time'].'<br>';
	echo '<h3> From : '.$sender['username'].'</h3>';
        echo '<h3>Subject : ' .$message['title'].'</h3>';
        echo '<p class="lead"><h3>Message : ' .$message['message'].'</p></h3>';
        echo '</div>';
	        echo '
        <button class="btn btn-primary" onclick="answer_mails(&quot;'. $sender['username'] . '&quot;,&quot;' . $message['title'] . '&quot;)">Answer</button>
        <a class="btn btn-default red" href="delete_message.php?message_id='. $message['id'] . '">Delete</a>';
      }
      else
      {
        header("location: index.php");
      }
    }
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }

?>

</body>
</html>
