<!DOCTYPE html>
<html lang="en" >
	<head>
		<meta charset="UTF-8">
		<title>LatinFest - Add new festival</title>
	</head>

	<body>
		<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
		<link href="style.css" rel="stylesheet">

		<div class="logowrap">
			<img class="logo" style="width:15%" src="../lg11.png" />
		</div>

		<div class="testbox">
			<h1>Add New Festival</h1>

			<form action="/">
				<hr>
				<div>Enter your details</div>
				<label id="icon" for="name"><i class="icon-envelope "></i></label>
				<input type="text" name="name" id="name" placeholder="Email" required/>
				<label id="icon" for="name"><i class="icon-user"></i></label>
				<input type="text" name="name" id="name" placeholder="Name" required/>

				<hr>

				<div>Enter festival details</div>
				<div class="accounttype">
					<input type="checkbox" value="Bachata" id="bachata" name="dancetype" checked/>
					<label for="bachata" class="checkbox">Bachata</label>
					<input type="checkbox" value="Salsa" id="salsa" name="dancetype"/>
					<label for="salsa" class="checkbox">Salsa</label>
					<input type="checkbox" value="Kizomba" id="kizomba" name="dancetype"/>
					<label for="kizomba" class="checkbox">Kizomba</label>
					<input type="checkbox" value="Zouk" id="zouk" name="dancetype"/>
					<label for="zouk" class="checkbox">Zouk</label>
				</div>
				
				<label id="icon" for="festival_name"><i class="icon-star"></i></label>
				<input type="text" name="festival_name" id="festival_name" placeholder="Festival Name" required/>
				
				<label id="icon" for="festival_img"><i class="icon-picture"></i></label>
				<input type="text" name="festival_img" id="festival_img" placeholder="Festival Image URL" required/>
				
				<label id="icon" for="festival_location"><i class="icon-map-marker"></i></label>
				<input type="text" name="festival_location" id="festival_location" placeholder="Festival Location" required/>
				
				<label id="icon" for="festival_fdate"><i class="icon-calendar"></i></label>
				<input type="text" name="festival_fdate" id="festival_fdate" placeholder="From Date" required/>
				
				<label id="icon" for="festival_tdate"><i class="icon-calendar"></i></label>
				<input type="text" name="festival_tdate" id="festival_tdate" placeholder="To Date" required/>
								
				<label id="icon" for="festival_price"><i class="icon-money"></i></label>
				<input type="text" name="festival_price" id="festival_price" placeholder="Starting Price"/>
								
				<label id="icon" for="festival_website"><i class="icon-globe"></i></label>
				<input type="text" name="festival_website" id="festival_website" placeholder="Festival Website" required/>
								
				<hr>
				<p>By clicking Register, you agree on our <a href="#">terms and condition</a>.</p>
				<a href="#" class="button">Add Festival</a>
				<br />
			</form>
		</div>
	</body>
</html>
 
