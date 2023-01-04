<?php
	require( 'utils.php' );

	$host="latinfashabtay.mysql.db";
	$username="latinfashabtay";
	$password="P0o9i8u7y6";
	$databasename="latinfashabtay";

	$conn= new mysqli($host,$username,$password,$databasename);
	
	if ( isset( $_GET['n'] ) ) {
		$st = explode( ',', dec( $_GET['n'] ) );
		$id = $st[0];
		
		$get_result = $conn->query("SELECT url FROM urls WHERE id=$id");
		$row = $get_result->fetch_assoc();
		$url = $row['url'];

		$get_result = $conn->query("SELECT * FROM clicks WHERE url_id=$id");
		if ( mysqli_num_rows( $get_result ) > 0 ) {
			$row = $get_result->fetch_assoc();
			$clicks = $row['clicks'] + 1;
			$conn->query("update clicks set clicks=$clicks WHERE url_id=$id");
		} else {
			$conn->query("insert into clicks (url_id, clicks) values ($id, 1)");
		}
		
#		header("Location: $url");
#		die();
	} else {
		echo "<p>Something went wrong :(</p>";
		die();
	}
?>

<html>
	<head>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZX5B4ZV2ZG"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-ZX5B4ZV2ZG');
		</script>
	</head>
	<body>
		<p>You're few seconds away from your next festival</p>
	</body>
	<script>
		setTimeout( function() { window.location.replace("<?php echo $url; ?>"); }, 1500 );
	</script>
</html>