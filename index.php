<?php 	
	header("Access-Control-Allow-Origin:*");
	
	session_start(); 
	$_SESSION["search_term"] = "";
	
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $current_url = "https://";   
    else  
         $current_url = "http://";   

    $current_url .= $_SERVER['HTTP_HOST'];   
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>LatinFest - Your Next Dance</title>
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		<link rel="stylesheet" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
		<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
		<script>
		  $( function() {
			$( "#dialog" ).dialog({
			  autoOpen: false,
			  show: {
				effect: "blind",
				duration: 1000
			  },
			  hide: {
				effect: "blind",
				duration: 1000
			  }
			});
		 
			$( "#help" ).on( "click", function() {
				$( "#dialog" ).dialog( "open" );
			});
		  } );
		</script>
		<base target="_blank">
		<style>
			img#help  {
				float: right;    
				margin: 0 0 0 15px;
			}
			
			div.dialog {
				font-size: 12px;
			}
		</style>
	</head>
	<body>
		<div id="dialog" title="Search Tips" class="dialog">
			<p>You can type the dance style (Bachata / Salsa / Kizomba / Zouk), 
			the location (country or city) and a date (year, month or specific date YYYY-MM-DD)</p>
			<br />
			<p><strong>Search examples?</strong></p>
			<p>
				&nbsp;&nbsp;-"Bachata in spain"<br />
				&nbsp;&nbsp;-"Salsa in april"<br />
				&nbsp;&nbsp;-"zouk in brazil on 2023-01-19"<br />
				&nbsp;&nbsp;-"kizomba in paris"<br />
				&nbsp;&nbsp;-"2023-03-15"
			</p>
			<br />
			<p>* You can use the calendar icon</p>
			<br />
			<p>* Results are sorted by relevance and date</p>
		</div>	
		<img id="help" src="help.png" alt="" width="30" height="30" />
		<div class="wrapper">
			<a href="<?php echo $current_url; ?>" target="_self"><img class="logo" src="LatinFest.png" /></a>
			<div class="search-input">
				<a href="" target="_blank" hidden></a>
				<input type="text" id="search_term" placeholder='Search...'>
				<div class="autocom-box">
				</div>
				<div class="icon calendar" id="btn_calendar"><i class="fas fa-calendar"></i></div>
				<div class="icon" onclick="do_search()"><i class="fas fa-search"></i></div>
			</div>

<div id = "divDatePicker"></div>

			<div id="myBarWrapper" class="w3-light-grey" style="display:none; margin-top: 15px;">
				<div id="myBar" class="w3-container w3-green" style="height:10px; width:15%; background-color: #5445fd!important; border-radius: 25px;"></div>
			</div>

			<div id="buttons" style="display:none; margin-top: 15px">
				<button id="btn_prev1" class="btn" onclick='do_next_prev("prev")'><i class="fas fa-arrow-left"></i> Prev</button>
				<button id="btn_next1" class="btn" onclick='do_next_prev("next")'>Next <i class="fas fa-arrow-right"></i></button>
			</div>
			
			<div id="result_div" class="results"></div>
			
			<div id="buttons2" style="display:none; margin-top: 5px;">
				<button id="btn_prev2" class="btn" onclick='do_next_prev("prev")'><i class="fas fa-arrow-left"></i> Prev</button>
				<button id="btn_next2" class="btn" onclick='do_next_prev("next")'>Next <i class="fas fa-arrow-right"></i></button>
			</div>
			<br />
		</div>

		<script src="suggestions.js"></script> 
		<script src="script.js"></script> 
		<script src="js/jquery.blockUI.js"></script>
	</body>
</html>