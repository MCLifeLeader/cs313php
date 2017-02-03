<?php
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$urlPath = $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS 313 Project</title>

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
		
		<script src="../scripts/jquery-3.1.1.min.js"></script>
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
						<h2>Working with PayPal data</h2>
					</div>
				</div>
			</div>

          <div class="row">
              <div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
                  <div class="panel panel-info" style="border-width: 2px;">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-weight: bolder;">
                              Survey Results
                          </h3>
                      </div>
                      <div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<table>
								<tr>
									<th><span>Question</span></th>
									<th><span class="addMargins">Result Counts</span></th>
								</tr>
								<tr><td colspan="2"><hr /></td></tr>
								</table>
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
