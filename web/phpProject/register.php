<?php
	require_once __DIR__ . '/bootstrap.php';
	require_once __DIR__ . '/common.php';
	require_once __DIR__ . '/DataLayer/DbRead.php';
	require_once __DIR__ . '/DataLayer/DbInsert.php';
	require_once __DIR__ . '/Models/AspNetUser.php';

	use phpProject\DataLayer\DbBase;
	use phpProject\DataLayer\DbRead;
	use phpProject\DataLayer\DbInsert;
	use phpProject\Models\AspNetUser;

	$userMessage = "";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ( !empty($_POST["Username"]) && !empty($_POST["Password"]) ) {
			$reader = new DbRead();
			$var = $reader->GetUser($_POST["Username"]);

			if(!empty($var) && $var->UserName == $_POST["Username"]) {
				$userMessage = " - Username already in Use. Please enter a new Username.";
			}
			else if(empty($_POST["Password"]) || empty($_POST["ConfirmPassword"]) || $_POST["Password"] != $_POST["ConfirmPassword"]) {
				$userMessage = " - Password does not Match or is Empty";
			}
			else {
				$aspNetUser = new AspNetUser();
				$aspNetUser->Email = $_POST["Username"];
				$aspNetUser->EmailConfirmed = false;
				$aspNetUser->PasswordHash = $_POST["Password"];
				$aspNetUser->SecurityStamp = null;
				$aspNetUser->PhoneNumber = $_POST["PhoneNumber"];
				$aspNetUser->PhoneNumberConfirmed = false;
				$aspNetUser->TwoFactorEnabled = false;
				$aspNetUser->LockoutEnabled = false;
				$aspNetUser->AccessFailedCount = 0;
				$aspNetUser->UserName = $_POST["Username"];

				try {
					$inserter = new DbInsert();
					$inserter->InsertUser($aspNetUser);
					$userMessage = " - Account Created Successfully";
				}
				catch (PDOException $ex) {
					$userMessage = $ex . $_POST["Username"];
				}
			}

			//if(!empty($var) && $var->PasswordHash == $_POST["Password"]) {
				
				// update
				//$var->AccessFailedCount = 5;
				//$updater = new DbUpdate();
				//$updater->UpdateUser($var);

				// insert
				//$var->Email = "newEmail".random_int(0,2000000000)."@example.com";
				//$var->UserName = $var->Email;

				//$_SESSION["IsLoggedIn"] = true;
				//$userMessage = " - Success";
				//header("Location: index.php"); /* Redirect browser */
			//}
			//else {
				//$userMessage = " - Invalid Username or Password";
			//}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS 313 Project - Register</title>

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
						<h1>Register</h1>
						<h2>Please Register to Login to our Site</h2>
					</div>
				</div>
			</div>

          <div class="row">
              <div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
                  <div class="panel panel-info" style="border-width: 2px;">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-weight: bolder;">
                              Register <?=$userMessage?>
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
									<div class="form-group" title="Phone Number" style="text-align: left;">
										<label class="control-label">Phone Number</label>
										<input id="PhoneNumber" class="form-control text-box single-line" name="PhoneNumber" placeholder="Phone Number" title="Phone Number" value="" type="text">
									</div>
									<div class="form-group" title="Enter Your Password" style="text-align: left;">
										<label class="control-label">Password</label>
										<input id="Password" class="form-control text-box single-line" name="Password" placeholder="Password" title="Password" value="" type="password">
									</div>
									<div class="form-group" title="Enter Your Password" style="text-align: left;">
										<label class="control-label">Confirm Password</label>
										<input id="ConfirmPassword" class="form-control text-box single-line" name="ConfirmPassword" placeholder="Confirm Password" title="Confirm Password" value="" type="password">
									</div>
									<div class="form-group">
										<input class="btn btn-primary" value="Enroll" title="Enroll" type="submit">
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
