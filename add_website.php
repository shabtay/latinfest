<?php
	ini_set('display_errors', '1'); 
	ini_set('display_startup_errors', '1'); 
	error_reporting(E_ALL);	
	
	$host="latinfashabtay.mysql.db";	
	$username="latinfashabtay";	
	$password="P0o9i8u7y6";	
	$databasename="latinfashabtay";
	
	$conn = new mysqli($host,$username,$password,$databasename);
	
	if ( isset( $_POST['action'] ) && $_POST['action'] == 'add_website' ) {
		$query = $_POST['query'];

		if ( $conn->query($query) ) {
			echo $conn->insert_id;
		} else {
			echo 0;
		}
	}
	
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'get_last_id' ) {
		$get_result = $conn->query("select max(id) as id from urls");
		$row = $get_result->fetch_assoc();
		echo $row['id'];
	}
?>
