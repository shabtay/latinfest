<?php	
ini_set('display_errors', '1'); 
ini_set('display_startup_errors', '1'); 
error_reporting(E_ALL);

header("Access-Control-Allow-Origin:*");
session_start(); 

$host="latinfashabtay.mysql.db";
$username="latinfashabtay";
$password="P0o9i8u7y6";
$databasename="latinfashabtay";

/*   	$host="sql.freedb.tech:3306";
$username="freedb_shabtay";
$password="DkkAz2@cj@97MTB";
$databasename="freedb_dancesearchengine"; */

$conn= new mysqli($host,$username,$password,$databasename);

function norm_data( $data ) {
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

if ( isset( $_POST['action'] ) && $_POST['action'] == "get_available_dates" ) {
	$dates = array();
	$get_result = $conn->query("SELECT distinct(from_date) as from_date from urls where from_date > NOW()");
	while( $row = $get_result->fetch_assoc() ) {
		array_push( $dates, $row['from_date'] );
	}
	
	echo json_encode( $dates );
	return;
}

if( isset( $_POST['search'] ) ) {
	$date_only = preg_match('/^(\d\d\d\d\-\d\d\-\d\d)$/', trim($_POST['search_term']));

	$where_date = "";
	if ( preg_match('/(\d\d\d\d\-\d\d\-\d\d)/', $_POST['search_term'], $matches) ) {
		$term_date = $matches[1];
		$where_date = "and from_date>='$term_date'";
	}
	
	$search_val = preg_replace( '/\d\d\d\d\-\d\d\-\d\d/', ' ', trim( $_POST['search_term'] ) );
	$search_val = preg_replace( array('/\sin\s/','/\son\s/','/\sat\s/'), ' ', trim( $search_val ) );
	$search_val = preg_replace( '/\s+/', ' ', trim( $search_val) );
	$search_val = str_replace( ' ', '* ', trim( $search_val) );
	$search_val .= "*";
	
	if ( ! isset( $_POST['action'] ) ) {
		$_SESSION['page'] = 1;
	}

	if ( $search_val != $_SESSION['search_term'] ) {
		$_SESSION['search_term'] = $search_val;
		$_SESSION['page'] = 1;
	} 

	$data = array();
	$sites = array();
	
	if ( $date_only ) {
		$get_result = $conn->query("SELECT u.url, u.image_url, u.name, u.dance_type, u.from_date, u.flocation, u.org_name FROM urls u WHERE from_date>='$term_date' ORDER BY from_date ASC");
	} else {
		$get_result = $conn->query("SELECT u.url, u.image_url, u.name, u.dance_type, u.from_date, u.flocation, u.org_name, MATCH (name) AGAINST ('$search_val' IN BOOLEAN MODE) AS score FROM urls u WHERE NOW()<from_date and MATCH (name) AGAINST ('$search_val' IN BOOLEAN MODE) > 0 $where_date ORDER BY `score` DESC, from_date ASC");
	}
	
	while( $row = $get_result->fetch_assoc() ) {
		array_push( $data, $row );
		$sites[parse_url( $row['url'], PHP_URL_HOST )] = 1;
	}
	
	$data = norm_data( $data );

	if( isset( $_POST['action'] ) && $_POST['action'] == 'next' ) {
		if( count($data) % 10 > 0 ) {
			if ( $_SESSION['page'] + 1 <= intVal( count($data) / 10 ) + 1 ) {
				$_SESSION['page']++;
			}
		} else {
			if ( $_SESSION['page'] + 1 <= intVal( count($data) / 10 ) ) {
				$_SESSION['page']++;
			}
		}
	} elseif ( isset( $_POST['action'] ) && $_POST['action'] == 'prev' ) {
		if ( $_SESSION['page'] > 1 ) {
			$_SESSION['page']--;
		}
	}

	$to = $_SESSION['page'] * 10;
	$fr = $to - 9;

    if ( $to > count($data) ) {
        $to = (intVal(count($data) / 10) * 10) + count($data) % 10;
	}
 
	$get_ts = $conn->query("SELECT DISTINCT(max(ts)) as ts FROM urls;");
	$ts = $get_ts->fetch_assoc();
 
	$pages = intVal(count($data) / 10);
	$pages += ( count($data) % 10 > 0 ) ? 1 : 0;
 
	$i = 0;	
	echo "<hr /><br />";
	echo "<div class='result-stats'>Got " . count($data) . " results | ".$_SESSION['page']."/$pages pages | $fr - $to Results<span class='last_update'>Updated on ".$ts['ts']."</span></div>";
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
			
			echo "<div class='result_block'>
			<div class='festival_img'><a href='".$row['url']."'><img src='".$clean_img_url."' /></a></div>
			<div class='text_block'>
				<a class='url' href='".$row['url']."'>$parsed_url</a><br />
				<a class='link_title' href='".$row['url']."'>" . ucwords(strtolower($row['org_name'])) . "</a><br />
				<div class='details'><strong>" . $date . ", " . ucwords($row['flocation']) . "</strong></div>
				<a class='url'>". ucwords($row['dance_type']) ."</a><br />
			</div>
			</div>";
		}
	}
	echo "<hr /><br />";
	
	echo "<script>disable_prev( false ); disable_next( false );</script>";
	if ( $_SESSION['page'] == $pages ) {
		echo "<script>disable_next( true );</script>";
	} 
	if( $_SESSION['page'] == 1 ) {
		echo "<script>disable_prev( true );</script>";
	} 
	
	#if( $_SESSION['page'] == 1 && $_SESSION['page'] == $pages ) {
	#	echo "<script>disable_prev( true ); disable_next( true );</script>";
	#}
}
?>