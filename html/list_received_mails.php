<!DOCTYPE html>
<!--
	In this script we print the messages contain in the database.
-->
<html lang="en">
<head>
  <meta charset="utf-8">


  <title>Mailbox</title>
<script src="/answer_mails.js"></script>


</head>
<body>
<h2>Received messages<h2/>

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

                     
                      // Create (connect to) SQLite database in file
                      $db = new PDO('sqlite:/var/www/databases/database.sqlite');

                      // Set errormode to exceptions
                      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                      // There we get the id of current user connected
                      $result = $db->query("SELECT id FROM users WHERE username = '$username';");
                      $current_user = $result->fetch();
                      $id_current_user = $current_user['id'];

                      // There we get received messages with current_user_id
                      $result = $db->query("SELECT * FROM messages WHERE receiver_id = '$id_current_user' ORDER BY time");

                      while($message = $result->fetch())
                      {
                        //retrieve sender identity
                        $id_sender = $message['sender_id'];
                        $result_sender = $db->query("SELECT username FROM users WHERE id = '$id_sender'");
                        $sender = $result_sender->fetch();

                        // display messages in the table
                        echo '<h6><table cellpadding="5px" cellspacing="0px" style="border:solid 1px black;background-color:lightgrey; text-align:center;">    
<tr style="background-color:midnightblue; color:white;">
      <th style="width:5px;">Sender</th>
      <th style="width:5px;">Title</th>
      <th style="width:5px;">Time</th>
   </tr> 
			    <tr>
                            <td>' . $sender['username'] . '</td>
                            <td>' . $message['title'] . '</td>
                            <td>' . $message['time'] . '</td>
                            <td>
                              
<button class="btn btn-primary" onclick="answer_mails(&quot;'. $sender['username'] . '&quot;,&quot;' . $message['title'] . '&quot;)">Answer</button>
                              
<a class ="btn btn-default" href="detail_mails.php?message_id='. $message['id'] . '">Details</a>
                              <a class = "btn btn-default" href="delete_mails.php?message_id='. $message['id'] . '">Delete</a> <br/>
                            </td>
                        </tr></table></h6>';
                     }

?>

</body>
</html>
