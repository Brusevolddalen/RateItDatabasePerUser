<?php
session_start();
$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
$id = $_POST['id'];
$user_db = new MySQLi("localhost", "root", "root", "$username");
$user_db->set_charset('utf8');

if ($user_db->connect_error) {
	echo "<script>
            alert('Error: 7. Could not connect to database!');
            window.location.href='../categories.html';
            </script>";
}
else {
	$id = mysqli_real_escape_string($user_db, $id);
  $sql_select_item = "SELECT * FROM $currentCategory WHERE id=$id";
  $result_select_item = $user_db->query($sql_select_item);


  $length = $result_select_item->num_rows;

	// empty array

	$result = array();
	for ($i = 0; $i < $length; $i++)
		{
		$row = $result_select_item->fetch_assoc(); //retrieving each row
		array_push($result, $row); //add to the array
		}

	echo json_encode($result); //convert to json and output the result
	} //end else


  /*
	if ($result_delete_item) {
		header("Location:../items.html?category=" . $currentCategory);
	}
	else {
		echo $result_select_item;
	}
  */


?>
