<?php
	require_once __DIR__ . '/bootstrap.php';
	require_once __DIR__ . '/common.php';
	require_once __DIR__ . '/DataLayer/DbRead.php';

	//echo "<br/><br/><br/><br/><br/>";

	use phpProject\DataLayer\DbBase;
	use phpProject\DataLayer\DbRead;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS 313 Project - Images</title>

		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="en-us" />
		<meta name="Robots" content="Follow, Index" />
		<meta name="Distribution" content="Worldwide" />
		<meta name="Rating" content="General" />

		<meta name="DESCRIPTION" content="Project Home Page. Assignments will be linked from here" />
		<meta name="KEYWORDS" content="Computer Science, CS 313, PHP, Web Engineering II, BYU-Idaho, Home Page" />
		<meta name="Author" content="Michael Carey" />
		<meta name="School" content="BYU-Idaho" />
		
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../content/main.css" />
		
		<script src="../scripts/jquery.min.js"></script>
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../scripts/main.js"></script>

	</head>
	<body>
		<div class="container body-content">

			<!-- Begin Navbar Include -->
			<?php include 'navbar.php' ?>
			<!-- End Navbar Include -->
		
			<div class="row">
				<div class="col-md-12">
					<div class="jumbotron">
						<h1>CS 313 Main Project</h1>
						<h2>Working with Image Blob data from PostgreSQL</h2>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
					<div class="panel panel-info" style="border-width: 2px;">
						<div class="panel-heading">
							<h3 class="panel-title" style="font-weight: bolder;">
								Image Demo
							</h3>
						</div>
						<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<form action="" method="post">
									<div class="form-group" title="Search" style="text-align: left;">
										<label class="control-label">Search</label>
										<input id="Search" class="form-control text-box single-line" name="Search" placeholder="Search" title="Search" value="" type="text">
										<br />
									</div>
									<div class="form-group">
										<input class="btn btn-primary" value="Search" title="Search." type="submit">
									</div>
								</form>
							</div>
						</div>
						</div>
						<div class="panel-footer">
							<div style="font-size: smaller;">
								&nbsp;
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
