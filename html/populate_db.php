<!DOCTYPE html>

<!--
	This is a script called to populate the application database with some initial data.
	It is aimed to be run only once, at the first time that the user lanches the application.
	It defines three users, one of them is an admin and the two others are regular users.
-->

<html>
<head>
		<title>Populating the DB !</title>
		<meta charset="utf-8">
</head>
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
      // table users
      // we use an integer type to replace boolean type 
      $file_db->exec("CREATE TABLE IF NOT EXISTS users(
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  username TEXT,
                  active INTEGER,
                  password TEXT,
                  admin INTEGER
      )");

    // Create table messages
    $file_db->exec("CREATE TABLE IF NOT EXISTS messages (
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  title TEXT,
                  message TEXT,
                  time TEXT,
                  sender_id INTEGER,
                  receiver_id INTEGER,
                  FOREIGN KEY(sender_id) REFERENCES users(id),
                  FOREIGN KEY(receiver_id) REFERENCES users(id)
    )");

    /**************************************
    * Set initial data                    *
    **************************************/

    $users = array(
                array(
			'id' => '0',  
			'username' => 'Daniel',
                        'active' => 1,
                        'password' => 'password',
                        'admin' => 1),
                array(  
			'id' => '1',
			'username' => 'Ali',
                        'active' => 1,
                        'password' => 'user01',
                        'admin' => 0),
                  );

    /**************************************
    * Play with databases and tables      *
    **************************************/

    // we add in table messages some informations about user 'id' for sender and receiver 

    foreach ($messages as $m) {
        $formatted_time = date('Y-m-d H:i:s', $m['time']);
        $file_db->exec("INSERT INTO messages (title, message, time, sender_id, receiver_id)
                VALUES ('{$m['title']}', '{$m['message']}', '{$formatted_time}','{$m['sender_id']}', '{$m['receiver_id']}')");
    }

    // we create this table to manage users

    foreach($users as $u){
        $file_db->exec("INSERT INTO users (id, username, active, password, admin)
                VALUES ('{$u['id']}', '{$u['username']}', '{$u['active']}', '{$u['password']}', '{$u['admin']}')");
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
<script type="text/javascript">alert("DB populated correctly");window.location = "login.php";</script>
</body>
</html>
