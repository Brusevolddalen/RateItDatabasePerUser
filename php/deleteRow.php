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
	$sql_delete_item = "DELETE FROM $currentCategory WHERE id=$id";
	$result_delete_item = $user_db->query($sql_delete_item);
	if ($result_delete_item) {
		header("Location:../items.html?category=" . $currentCategory);
	}
	else {
		echo $sql_delete_item;
	}
}

?>
