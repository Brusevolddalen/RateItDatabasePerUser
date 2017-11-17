<?php
session_start();
$username = $_SESSION['username'];
$currentCategory = $_SESSION['currentCategory'];
$column = $_POST['Column'];
$column_type = $_POST['Select'];
$user_db = new MySQLi("localhost", "root", "root", "$username");
$user_db->set_charset('utf8');

if ($user_db->connect_error) {
	echo "<script>
              alert('Error: 7. Could not connect to database!');
              window.location.href='../categories.html';
              </script>";
}
else {
	$show_columns_sql = "SHOW COLUMNS FROM $username.$currentCategory";
	$rows = $user_db->query($show_columns_sql);
	$length = $rows->num_rows;
	$result = array();

	// pushes columns names into $result

	for ($i = 0; $i < $length; $i++) {
		$row = $rows->fetch_assoc();
		array_push($result, $row["Field"]);
	}

	// finds the location of rating field

	$key = array_search('rating', $result);
	$key = $key - 1;

	// adds the column before rating

	$sql_add_column = "ALTER TABLE `$currentCategory`";
	for ($i = 0; $i < count($column); $i++) {
		$column[$i] = mysqli_real_escape_string($user_db, $column[$i]);
		$column_type[$i] = mysqli_real_escape_string($user_db, $column_type[$i]);
		$sql_add_column.= " ADD `" . $column[$i] . "`";
		$sql_add_column.= " " . $column_type[$i] . ", ";
	}

	$sql_add_column = rtrim($sql_add_column, ", ");

	// echo $sql_add_column;

	$sql_add_column.= " AFTER `" . $result[$key] . "`";
	$result_add_column = $user_db->query($sql_add_column);

	// ALTER TABLE Kazura.Drinks ADD 'qwe' VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci, ADD 'asd' VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci AFTER 'type'
	// ALTER TABLE `drinks` ADD `qwe` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `type`, ADD `asd` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `qwe`;

	if ($result_add_column) {
		header("Location:../items.html?category=" . $currentCategory);
	}
	else {
		echo $sql_add_column . "<br />" . $result_add_column;
	}
}

?>
