<?php
error_reporting(E_ERROR); //turn off warnings


// echo $_POST['masterCategories'][0];

foreach($_POST['masterCategories'] as $master_categories_selected) {

	//If user doesn't select any Master Categories, send them to category page
	if (empty($master_categories_selected)) {
		header("Location:../categories.html");
	}
	//If user selects mastercategories, connect to databases and create tables in users database
	else{
		session_start();
		$username = $_SESSION['username'];

		//connects to user database
		$user_db = new MySQLi("localhost", "root", "root", "$username");
		$user_db->set_charset('utf8');

		//connects to matercategories database
		$master_categories_db = new MySQLi("localhost", "root", "root", "mastercategories");
		$master_categories_db->set_charset('utf8');
		$master_categories_selected = $master_categories_db->real_escape_string($master_categories_selected);

		//creates tables based on which user selected
		$sql_insert_master_category_tables = "CREATE TABLE $username.$master_categories_selected AS (SELECT * FROM mastercategories.$master_categories_selected)";
		$result_insert_master_category_tables = $user_db->query($sql_insert_master_category_tables);

		//send user to categories.html if success
		if($result_insert_master_category_tables){
			header("Location:../categories.html");
		}
		else{
			echo "<script>
								alert('Error: 3. Could not insert MasterCategories into users database!');
								window.location.href='../categories.html';
								</script>";
		}


	}
}

?>
