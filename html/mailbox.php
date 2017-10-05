<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">


  <title>Mailbox</title>


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

?>

        <h2> Write a new message </h2>
          <form id="message_form" action="send_message.php" method="post" role="form">
            <div class="form-group">
             <label for="sel1">Chose recipient</label>
             <select class="form-control" name="recipient">'

             <?php
                      // Create (connect to) SQLite database in file
                      $db = new PDO('sqlite:/var/www/databases/database.sqlite');

                      // Set errormode to exceptions
                      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $result = $db->query("SELECT * FROM users WHERE NOT username = '$username'");
              while($row = $result->fetch())
             {
                echo '<option>'. $row['username'] .'</option>';
             }

             ?>

              </select>
            </div>

            <div class="form-group">
                 <label for="title">Title</label>
                 <input type="text" class="form-control" name="title">
             </div>
             <div class="form-group">
                 <label for="message">Content</label>
                 <textarea id="message" name="message"></textarea>
             </div>
             <div class="form-group">
             <input type="submit" class="btn btn-default" value="Send the message">
             </div>
          </form>

    </div>
  </div>

</body>
</html>
