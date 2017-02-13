<?php
	require_once __DIR__ . '/bootstrap.php';
	require_once __DIR__ . '/common.php';
	require_once __DIR__ . '/DataLayer/DbRead.php';
	require_once __DIR__ . '/DataLayer/DbUpdate.php';
	require_once __DIR__ . '/Models/AspNetUser.php';

	use phpProject\DataLayer\DbBase;
	use phpProject\DataLayer\DbRead;
	use phpProject\DataLayer\DbUpdate;
	use phpProject\Models\AspNetUser;

	$userMessage = "";

	$reader = new DbRead();
	$aspNetUser = $reader->GetUser($_SESSION["Username"]);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$aspNetUser = $reader->GetUser($_SESSION["Username"]);

		if(empty($_POST["Password"]) || empty($_POST["ConfirmPassword"]) || $_POST["Password"] != $_POST["ConfirmPassword"]) {
			$userMessage = " - Password does not Match or is Empty";
		}
		else {
			$aspNetUser->PasswordHash = $_POST["Password"];
			$aspNetUser->PhoneNumber = $_POST["PhoneNumber"];

			try {
				$updater = new DbUpdate();
				$updater->UpdateUser($aspNetUser);
				$userMessage = " - Account Updated Successfully";
			}
			catch (PDOException $ex) {
				$userMessage = $ex;
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CS 313 Project - Profile</title>

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
						<h1>Profile</h1>
						<h2>User Profile</h2>
					</div>
				</div>
			</div>

          <div class="row">
              <div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
                  <div class="panel panel-info" style="border-width: 2px;">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-weight: bolder;">
                              Profile <?=$userMessage?>
                          </h3>
                      </div>
                      <div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<form action="" method="post">
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
										<input class="btn btn-primary" value="Update" title="Update" type="submit">
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
		<script>
			document.getElementById("PhoneNumber").value = '<?=$aspNetUser->PhoneNumber?>';
		</script>
	</body>
</html>
