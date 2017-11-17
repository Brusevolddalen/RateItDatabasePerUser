<?php
error_reporting(E_ERROR); //turn off warnings

// set the default timezone to use. Available since PHP 5.1

date_default_timezone_set('Europe/Berlin');

// fill in database info here:
// $master_db = new MySQLi("databaseServer", "username", "password", "databaseName", port-number);

$master_db = new MySQLi("localhost", "root", "root", "userinfo");
$master_db->set_charset('utf8');

if ($master_db->connect_error) {
	echo $master_db->connect_error;
}
else {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sex = $_POST['sex'];
	$birthdate = $_POST['birthdate'];
	$country = $_POST['country'];

	$username = $master_db->real_escape_string($username);
	$email = $master_db->real_escape_string($email);
	$password = $master_db->real_escape_string($password);
	$sex = $master_db->real_escape_string($sex);
	$birthdate = $master_db->real_escape_string($birthdate);
	$country = $master_db->real_escape_string($country);
	$passwordcrypt = password_hash($password, PASSWORD_BCRYPT);

	// Creates the member in master.members

	$sql_register = "INSERT INTO members (username, email, password, sex, birthdate, country, regdate) VALUES ('$username', '$email', '$passwordcrypt', '$sex', '$birthdate', '$country', now())";
	$result_register = $master_db->query($sql_register);

	// If successfull in registering the member, creates a personal database

	if ($result_register) {
		$sql_create_database = "CREATE DATABASE $username";
		$result_create_database = $master_db->query($sql_create_database);

		// If successfull in creating the personal database, connect to it.

		if ($result_create_database) {
			$user_db = new MySQLi("localhost", "root", "root", $username);
			$user_db->set_charset('utf8');

			// Checks for connection error, if no error, connect and create categories table.
			/*if ($user_db->connect_error) {
				echo $user_db->connect_error;
			}
			else {
				$sql_create_categories_in_user_db = "CREATE TABLE categories ( categoryname VARCHAR(255) UNIQUE, master BOOLEAN NOT NULL DEFAULT 0 )";
				$result_create_categories_in_user_db = $user_db->query($sql_create_categories_in_user_db);
			}*/
		}


    else {
			echo "<script>
                alert('Error: 2. Could not create personal database. Please contact customer service or try again!');
                window.location.href='../register.html';
                </script>";
		}
    header("Location:../login.html");

	}
	else {

		// header("Location:../register.html");

		echo "<script>
              alert('Error: 1. A user with that username or email already exists!');
              window.location.href='../register.html';
              </script>";
	}
}

?>
