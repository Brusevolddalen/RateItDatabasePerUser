<?php
session_start();
$username = $_SESSION['username'];

$db = new MySQLi("localhost", "root", "root", "$username");



if ($db->connect_error)
	{
	echo $db->connect_error;
	}
  else
	{


$db->set_charset('utf8');
$selectedCategory = $_GET['category'];

$sql = "SHOW COLUMNS FROM $username.$selectedCategory";
$rows = $db->query($sql);
$length = $rows->num_rows;

// empty array

$result = array();
for ($i = 0; $i < $length; $i++)
  {
  $row = $rows->fetch_assoc(); //retrieving each row
  array_push($result, $row["Field"]); //add to the array
  }

echo json_encode($result); //convert to json and output the result
} //end else

 ?>
