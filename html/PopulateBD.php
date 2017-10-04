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
				// Creating the two tables for storing the users and the messages.
				// There is no boolean in sqlite so we use integers to represent the flags 'admin' and 'enable'.
				$file_db->exec("CREATE TABLE IF NOT EXISTS users(
					  id INTEGER PRIMARY KEY AUTOINCREMENT,
					  username TEXT,
					  enable INTEGER,
					  password TEXT,
					  admin INTEGER
				)");

				// Create table messages.
				$file_db->exec("CREATE TABLE IF NOT EXISTS messages (
					  id INTEGER PRIMARY KEY AUTOINCREMENT,
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

				// Arrays with some initial data to insert to database.
				$messages = array(
						array(	
							'title' => 'Hello!',
							'message' => 'Just testing...',
							'time' => 1327301464,
							'id_user_sender' => 1,
							'id_user_receiver' => 0
						),
						array('title' => 'Hello again!',
							'message' => 'More testing...',
							'time' => 1339428612,
							'id_user_sender' => 2,
							'id_user_receiver' => 1
						),
						array('title' => 'Hi!',
							'message' => 'SQLite3 is cool...',
							'time' => 1327214268,
							'id_user_sender' => 2,
							'id_user_receiver' => 1)
						);

				$users = array(
						array(
							'id' => '0',  
							'username' => 'admin',
							'enable' => 1,
							'password' => 'admin',
							'admin' => 1
						),
						array(  
							'id' => '1',
							'username' => 'bob',
							'enable' => 1,
							'password' => 'bob',
							'admin' => 0
						),
						array(  
							'id' => '2',
							'username' => 'alice',
							'enable' => 1,
							'password' => 'alice',
							'admin' => 0
						)
						);
				

				/**************************************
				* Populate the database	              *
				**************************************/

				foreach ($messages as $m) {
					$formatted_time = date('Y-m-d H:i:s', $m['time']);
					$file_db->exec("INSERT INTO messages (title, message, time, id_user_sender, id_user_receiver)
						VALUES ('{$m['title']}', '{$m['message']}', '{$formatted_time}','{$m['sender_id']}', '{$m['receiver_id']}')");
				}

				foreach($users as $u){
					$file_db->exec("INSERT INTO users (username, enable, password, admin)
						VALUES ('{$u['username']}', '{$u['enable']}', '{$u['password']}', '{$u['admin']}')");
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
