<?php 
	date_default_timezone_set('Europe/London');
	ini_set('default_charset', 'utf-8');
	header('Content-Type: text/html; charset=UTF-8' );

	session_start(); 
	$_SESSION["search_term"] = "";

	require( 'first_results.php' );

	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $current_url = "https://";   
    else  
         $current_url = "http://";   

    $current_url .= $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZX5B4ZV2ZG"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-ZX5B4ZV2ZG');
		</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title><?php echo ( isset( $_GET['search'] ) ) ? 'Dance Finder ' . $_GET['search'] . ' | ':'' ?> Dance Finder - Find Your Next Latin Dance Festival | Bachata | Salsa | Kizomba | Zouk</title>

		<?php if ( ! isset( $_GET['search'] ) ) { ?>
		<meta name="description" content="Search for your next latin festival. bachata, salsa, kizomba, zouk. all over the world." />
		<meta name="keywords" content="latin festival,bachata festival,salsa festival,kizomba festival,zouk festival" />
		<?php } else { ?>
		<meta name="description" content="<?php echo 'Serach results for ' .$_GET['search']; ?>" />
		<meta name="keywords" content="<?php echo $_GET['search'] . ',latin festival'; ?>" />
		<?php } ?>

		<link rel="icon" type="image/x-icon" href="favicon.ico">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="style.css">
		<script src="//code.jquery.com/jquery-3.6.0.js"></script>
		<script src="//code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
		<base target="_blank">
	</head>
	<body>
		<div id="dialog" title="How to search?" class="dialog" style="display:none">
			<p>You can type the dance style (Bachata / Salsa / Kizomba / Zouk), 
			the location (country or city) and a date (year, month or specific date YYYY-MM-DD)</p>
			<br />
			<p><strong>Search examples?</strong></p>
			<p>
				&nbsp;&nbsp;-"Bachata in spain"<br />
				&nbsp;&nbsp;-"Salsa in april"<br />
				&nbsp;&nbsp;-"zouk in brazil on 2023-01-19"<br />
				&nbsp;&nbsp;-"kizomba in paris"<br />
				&nbsp;&nbsp;-"madrid"<br />
				&nbsp;&nbsp;-"milano july"<br />
				&nbsp;&nbsp;-"2023-03-15"<br />
				&nbsp;&nbsp;-"next week/month"
			</p>
			<br />
			<p>* You can use the calendar icon</p>
			<br />
			<p>* Results are sorted by relevance and date</p>
		</div>	
		<img class="help" src="help.png" alt="" width="30" height="30" />
		<div class="wrapper">
			<div class="logowrap">
				<a href="<?php echo $current_url; ?>" target="_self"><img class="logo" src="lg11.png" /></a>
			</div>
			<div class="search-input">
				<a href="" target="_blank" hidden></a>
				<input type="text" id="search_term" placeholder='Search...' value="<?php echo (isset($_GET['search']))?$_GET['search']:''?>">
				<div class="autocom-box">
				</div>
				<div class="icon clear" id="btn_clear"><i class="fas fa-trash"></i></div>
				<div class="icon calendar" id="btn_calendar"><i class="fas fa-calendar"></i></div>
				<div class="icon icon_search" onclick="do_search()"><i class="fas fa-search"></i></div>
				<div id="errors"></div>
			</div>

			<div id="tips" class="tips">
				<h3>Search Tips</h3>
				<div>
					<span class="tip">Bachata</span>
					<span class="tip">Salsa</span>
					<span class="tip">Kizomba</span>
					<span class="tip">Zouk</span>
					<span class="tip">Next week</span>
					<span class="tip">Next month</span>
					<span class="tip">Next month</span>
					<span class="tip"><?php echo date('Y-m-d', time()+86400); ?></span>
					<span class="tip">Bachata in spain</span>
					<span class="tip">Salsa on July</span>
				</div>
			</div>

			<div id = "divDatePicker"></div>

			<div id="buttons" style="display:none; margin-top: 15px">
				<button id="btn_prev1" class="btn" onclick='do_next_prev("prev")'><i class="fas fa-arrow-left"></i> Prev</button>
				<button id="btn_next1" class="btn" onclick='do_next_prev("next")'>Next <i class="fas fa-arrow-right"></i></button>
			</div>
			
			<div id="result_div" class="results">
			<?php 
				if ( ! isset( $_GET ) || count($_GET) == 0 ) { display_first_results(); } 
			?>
			</div>
			
			<div id="buttons2" style="display:none; margin-top: 5px;">
				<button id="btn_prev2" class="btn" onclick='do_next_prev("prev")'><i class="fas fa-arrow-left"></i> Prev</button>
				<button id="btn_next2" class="btn" onclick='do_next_prev("next")'>Next <i class="fas fa-arrow-right"></i></button>
				<br /><br />
			</div>
		
			<fieldset>
				<legend>&nbsp;Popular Searches&nbsp;</legend>
				<div class="popular_searches">
					<?php
						$pop = get_popular_searches();
						for ( $i = 0; $i < 8; $i++ ) {
							$t = $pop[$i];
							$h = str_replace( ' ', '+', $t );
							echo '<span><a target="_self" href="/?search='.$h.'">'.$t.'</a></span>';
							if ( $i < 7 )
								echo ' / ';
						}
					?>
				</div>	
			</fieldset>
			<br />
		</div>



		<form id="search_form" style="display:none" target="_self">
			<input name="search" id="search" />
		<form>
		<script src="script.js"></script> 
		<script src="js/jquery.blockUI.js"></script>
		
		<?php
			if ( isset($_GET['search']) ) {
				echo "<script>$( document ).ready(function() { do_search_post(); })</script>";
			}
		?>		
	</body>
</html>