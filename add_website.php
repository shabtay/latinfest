<?php
	$host="latinfashabtay.mysql.db";
	$username="latinfashabtay";
	$password="P0o9i8u7y6";
	$databasename="latinfashabtay";

	$conn = new mysqli($host,$username,$password,$databasename);

	if ( $_POST['action'] == 'add_website' ) {
		$query = json_decode( $_POST['query'], true );
		
		if ( $conn->query($query) ) {
			echo $conn->insert_id;
		} else {
			echo 0;
		}
	}
?>
