<?php

error_reporting(E_ERROR); //turn off warnings
session_start();
$username = $_SESSION['username'];

$db = new MySQLi("localhost", "root", "root", "$username");
$db->set_charset('utf8');

if ($db->connect_error) {
	echo $db->connect_error;
}
else {

  $category = $_POST['categoryName'];

  $category = $db->real_escape_string($category);

  //creates tables based on which user selected
  $sql_add_category = "CREATE TABLE $username.$category (id INT(100) UNSIGNED AUTO_INCREMENT PRIMARY KEY, rating TINYINT(1), edited date)";
  $result_add_category = $db->query($sql_add_category);

  if (!$result_add_category) {
    echo $sql_add_category;
      //"<script>alert('Error 4 could not add category');</script>"
	}

}

?>
