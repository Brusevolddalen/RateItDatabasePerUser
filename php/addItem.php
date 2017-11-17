<?php
session_start();
$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
$item = $_POST['Item'];



$user_db = new MySQLi("localhost", "root", "root", "$username");
$user_db->set_charset('utf8');

if ($user_db->connect_error) {
	"<script>alert('Error 5 Could not connect to database, please check your internet connection!');</script>";
}
else {


	$sql_add_item = "INSERT INTO $username.$currentCategory (";
	$sql_add_item .= implode(", ", array_keys($item));
	$sql_add_item .= ", edited".")";
	$sql_add_item .= " VALUES (";
	$sql_add_item .="'".implode("', '", $item)."', ";
	$sql_add_item .= "now()".")";
	//echo "<br>".$sql_add_item;

	//$result_add_item = $user_db->query($sql_add_item);

	if (!mysqli_query($user_db, $sql_add_item))
  {
		echo "<script>
							alert('Error: 6. Could not add item into users database!');
							window.location.href='../items.html';
							</script>";
  }
	else{
		header("Location:../items.html");
	}
}
?>
