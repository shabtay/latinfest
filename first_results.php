<?php	
ini_set('display_errors', '1'); 
ini_set('display_startup_errors', '1'); 
error_reporting(E_ALL);
ini_set('default_charset', 'UTF-8');

require( 'utils.php' );

function connect_to_db2() {
	$host="latinfashabtay.mysql.db";
	$username="latinfashabtay";
	$password="P0o9i8u7y6";
	$databasename="latinfashabtay";

	$conn= new mysqli($host,$username,$password,$databasename);

	return( $conn );
}

function norm_data2( $data ) {
    $index_to_del = array();
    
    for ( $i = 0; $i <= count( $data ) - 2; $i++ ) {
        if ( ! isset( $index_to_del[$i] ) ) {
            for ( $j = $i + 1; $j <= count( $data ) - 1; $j++ ) {
                if ( $data[$i]['org_name'] == $data[$j]['org_name'] ) {
                    if ( strpos( $data[$i]['dance_type'], $data[$j]['dance_type'] ) >= 0 ) {
						$data[$i]['dance_type'] = $data[$i]['dance_type'] . " / " . $data[$j]['dance_type'];
						array_unshift( $index_to_del, $j );
					}
				}
			}
		}
    }
	
    rsort( $index_to_del );
	
    $i = 0;
    while ( $i < count( $index_to_del ) ) {
        $item = $index_to_del[$i];
        $i++;
		unset( $data[$item] );
	}
	$data = array_values( $data );
		
	return( $data );
}

function display_first_results() {
	$conn = connect_to_db2();
	
	$data = array();
	
	$term_date = date('Y-m-d', time());
	$get_result = $conn->query("SELECT u.id, u.url, u.image_url, u.name, u.dance_type, u.from_date, u.flocation, u.org_name FROM urls u WHERE from_date>='$term_date' ORDER BY from_date ASC LIMIT 10");
	
	while( $row = $get_result->fetch_assoc() ) {
		array_push( $data, $row );
	}
	
	$data = norm_data2( $data );

	$to = 10;
	$fr = $to - 9;

 
	$i = 0;	
	echo "<hr /><br />";
	echo "<div class='result-stats'>Displaying the next 10 fesivals</div>";
	foreach( $data as $row ) {
		$i++;
		
		if ( $i >= $fr && $i <= $to ) {
			$parsed_url = parse_url( $row['url'], PHP_URL_SCHEME );
			$parsed_url .= "://" . parse_url( $row['url'], PHP_URL_HOST );

			$clean_img_url = parse_url( $row['image_url'], PHP_URL_SCHEME );
			$clean_img_url .= "://" . parse_url( $row['image_url'], PHP_URL_HOST );
			$clean_img_url .= parse_url( $row['image_url'], PHP_URL_PATH );
			
			$date = date_format(date_create($row['from_date']),"d M Y");
			
			$row['dance_type'] = str_replace('+', ' ', $row['dance_type']);
			
			$id = "redirect.php?n=".enc( $row['id'].','.rand(10000,999999) );
			echo "<div class='result_block'>
			<div class='festival_img'><a href='".$id."'><img src='".$clean_img_url."' /></a></div>
			<div class='text_block'>
				<a class='url' href='".$id."'>$parsed_url</a><br />
				<a class='link_title' href='".$id."'>" . ucwords(strtolower($row['org_name'])) . "</a><br />
				<div class='details'><strong>" . $date . ", " . ucwords($row['flocation']) . "</strong></div>
				<a class='url'>". ucwords($row['dance_type']) ."</a><br />
			</div>
			</div>";
		}
	}
	echo "<hr /><br />";
}

function get_popular_searches() {
	$conn = connect_to_db2();
	
	$terms = array();
	$get_result = $conn->query("SELECT search_term from searches");
	while( $row = $get_result->fetch_assoc() ) {
		array_push( $terms, $row['search_term'] );
	}
		
	shuffle( $terms );
	
	return( $terms );
}
?>