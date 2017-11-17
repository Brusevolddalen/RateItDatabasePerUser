<?php
session_start();
$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
array_walk_recursive( $_POST, 'mysql_real_escape_string' );
$row = $_POST['Row'];
$user_db = new MySQLi("localhost", "root", "root", "$username");
$user_db->set_charset('utf8');

if ($user_db->connect_error) {
	echo "<script>
            alert('Error: 7. Could not connect to database!');
            window.location.href='../categories.html';
            </script>";
}
else {
  $id = $row["id"];
  unset($row["id"]);

  $sql_edit_item= "UPDATE $currentCategory SET ";


  foreach ($row as $key => $value) {
    $sql_edit_item.= "$key='$row[$key]', ";
		//$sql_edit_item.= $user_db->real_escape_string("$key= $row[$key], ");
    /*
    echo("Key: $key <br>");
    echo("Row: $row[$key] <br>");
    */
  }
	$sql_edit_item =rtrim($sql_edit_item,", ");
  $sql_edit_item .= " WHERE id=$id";


	$result_edit_item = $user_db->query($sql_edit_item);


	if ($result_edit_item) {
		header("Location:../items.html?category=" . $currentCategory);
	}
	else {
		echo $sql_edit_item."<br>";
		 printf("Errormessage: %s\n", $user_db->error);
	}

}

?>
