<?php 

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Die - Critical Failure</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="en-us" />
		<meta name="DESCRIPTION" content="This is a hello page for CS 313 Web Engineering II class at BYU-Idaho, PHP Die page." />
		<meta name="KEYWORDS" content="Computer Science, CS 313, PHP, Web Engineering II, BYU-Idaho, Die" />
		<meta name="Author" content="Michael Carey" />
		<meta name="Robots" content="Follow, Index" />
		<meta name="Distribution" content="Worldwide" />
		<meta name="Rating" content="General" />
		
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" /> 		
		<script src="scripts/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="scripts/main.js"></script>
		
	</head>
	<body>
		<div class="container body-content">

			<!-- Begin Navbar Include -->
			<div id="MenuNav"></div>
			<script>
				document.getElementById("MenuNav").innerHTML = readTextFile( "navbar.php" );				
			</script>
			<!-- End Navbar Include -->
		
			<div class="row">
				<div class="col-md-12">
					<div class="jumbotron">
						<h1>PHP Die</h1>
						<p class="lead">There was an Error</p>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">There was a problem with the PHP code that was executed.</div>
			</div>
		</div>		
	</body>
</html>
