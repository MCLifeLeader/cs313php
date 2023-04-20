<?php
	require_once __DIR__ . '/bootstrap.php';
	require_once __DIR__ . '/common.php';
	require_once __DIR__ . '/DataLayer/DbRead.php';
	require_once __DIR__ . '/Models/AspNetUser.php';

	use phpProject\DataLayer\DbBase;
	use phpProject\DataLayer\DbRead;
	use phpProject\Models\AspNetUser;

	$userMessage = "";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ( !empty($_POST["Username"]) && !empty($_POST["Password"]) ) {
			$reader = new DbRead();
			$aspNetUser = $reader->GetUser($_POST["Username"]);

			if(!empty($aspNetUser) && $aspNetUser->PasswordHash == $_POST["Password"]) {
				$_SESSION["IsLoggedIn"] = true;
				$_SESSION["Username"] = $_POST["Username"];
				$userMessage = " - Success";
				header("Location: index.php"); /* Redirect browser */
				die();
			}
			else {
				$userMessage = " - Invalid Username or Password";
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS 313 Project - Login</title>

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
						<h1>Login</h1>
						<h2>Enter Username and Password</h2>
					</div>
				</div>
			</div>

          <div class="row">
              <div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
                  <div class="panel panel-info" style="border-width: 2px;">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-weight: bolder;">
                              Login <?=$userMessage?>
                          </h3>
                      </div>
                      <div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<form action="" method="post">
									<div class="form-group" title="Enter Your UserName" style="text-align: left;">
										<label class="control-label">Username</label>
										<input id="Username" class="form-control text-box single-line" name="Username" placeholder="Username" title="Username" value="" type="text">
									</div>
									<div class="form-group" title="Enter Your Password" style="text-align: left;">
										<label class="control-label">Password</label>
										<input id="Password" class="form-control text-box single-line" name="Password" placeholder="Password" title="Password" value="" type="password">
									</div>
									<div class="form-group">
										<input class="btn btn-primary" value="Login" title="Login" type="submit">
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
