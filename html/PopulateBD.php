<html>
<head></head>
<body>

<?php

echo 'Now we are populating the database<br>';

  // Set default timezone
  date_default_timezone_set('UTC');

  try {
    /**************************************
    * Create databases and                *
    * open connections                    *
    **************************************/

    // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:/var/www/databases/database.sqlite');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION);

    /**************************************
    * Drop tables                         *
    **************************************/

    // Drop table messages from file db
    $file_db->exec("DROP TABLE IF EXISTS messages");
    $file_db->exec("DROP TABLE IF EXISTS users");

    /**************************************
    * Create tables                       *
    **************************************/
      // Create table users
      // There is no boolean in sqlite so we use integer for the flag admin
      $file_db->exec("CREATE TABLE IF NOT EXISTS users(
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  username TEXT,
                  enable INTEGER,
                  password TEXT,
                  admin INTEGER
      )");

    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS messages (
                  id INTEGER PRIMARY KEY,
                  title TEXT,
                  message TEXT,
                  time TEXT,
                  id_user_sender INTEGER,
                  id_user_receiver INTEGER,
                  FOREIGN KEY(id_user_sender) REFERENCES users(id),
                  FOREIGN KEY(id_user_receiver) REFERENCES users(id)
    )");

    /**************************************
    * Set initial data                    *
    **************************************/

    // Array with some test data to insert to database
    $messages = array(
                  array('title' => 'Hello!',
                        'message' => 'Just testing...',
                        'time' => 1327301464,
                        'id_user_sender' => 1,
                        'id_user_receiver' => 2),
                  array('title' => 'Hello again!',
                        'message' => 'More testing...',
                        'time' => 1339428612,
                        'id_user_sender' => 2,
                        'id_user_receiver' => 1),
                  array('title' => 'Hi!',
                        'message' => 'SQLite3 is cool...',
                        'time' => 1327214268,
                        'id_user_sender' => 2,
                        'id_user_receiver' => 1)
                );

    $users = array(
                array(
			'id' => '0',  
			'username' => 'Daniel',
                        'enable' => 1,
                        'password' => 'password',
                        'admin' => 1),
                array(  
			'id' => '1',
			'username' => 'Ali',
                        'enable' => 1,
                        'password' => 'user01',
                        'admin' => 0),
                  );

    /**************************************
    * Play with databases and tables      *
    **************************************/

    // we add in table messages some informations about user 'id' for sender and receiver 

    foreach ($messages as $m) {
        $formatted_time = date('Y-m-d H:i:s', $m['time']);
        $file_db->exec("INSERT INTO messages (title, message, time, id_user_sender, id_user_receiver)
                VALUES ('{$m['title']}', '{$m['message']}', '{$formatted_time}','{$m['sender_id']}', '{$m['receiver_id']}')");
    }

    $result =  $file_db->query('SELECT * FROM messages');

    foreach($result as $row) {
      echo "Id: " . $row['id'] . "<br/>";
      echo "Title: " . $row['title'] . "<br/>";
      echo "Message: " . $row['message'] . "<br/>";
      echo "Time: " . $row['time'] . "<br/>";
      echo "Sender_id: " . $row['sender_id'] . "<br/>";
      echo "Receiver_id: " . $row['receiver_id'] . "<br/>";
      echo "<br/>";
    }

    // we create this table to manage users

    foreach($users as $u){
        $file_db->exec("INSERT INTO users (id, username, enable, password, admin)
                VALUES ('{$u['id']}', '{$u['username']}', '{$u['enable']}', '{$u['password']}', '{$u['admin']}')");
    }

    $result =  $file_db->query('SELECT * FROM users');

    foreach($result as $row) {
      echo "Id: " . $row['id'] . "<br/>";
      echo "Username: " . $row['username'] . "<br/>";
      echo "Enable: " . $row['enable'] . "<br/>";
      echo "Admin: " . $row['admin'] . "<br/>";
      echo "<br/>";
    }


    /**************************************
    * Close db connections                *
    **************************************/

    // Close file db connection
    $file_db = null;
  }
  catch(PDOException $e) {
    // Print PDOException message
    echo $e->getMessage();
  }
?>

</body>
</html>
