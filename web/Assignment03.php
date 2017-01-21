<?php

	//include 'class/hash_table.php';

    // Config PHP To Display Errors
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	/**** Database ****/
	$cookieName = "visitor";
	$appName = " application_name=" . $_SERVER['HTTP_HOST'] . "_cs313_week03";
	$connStr = getenv("DATABASE_CONN");
	
	if(empty($connStr))
	{
		$connStr = "host=localhost port=5432 dbname=cs313Dev user=cs313 password=P@ssword123";
	}

	$conn = pg_connect($connStr . $appName)
		or die("Can't connect to database".pg_last_error());
	
	// Check for the table to see if it is there. If not then we need to build the tables
	$result = pg_query($conn, "SELECT * FROM db_validate");
	
	// check for results. The table "db_validate" should only ever have one record in it.
	if(!pg_fetch_all($result))
	{
		// Read my Build Script
		$myfile = fopen("buildTables.sql", "r") or die("Unable to open file!");
		$executeSql = fread($myfile,filesize("buildTables.sql"));
		fclose($myfile);

		// Execute my Build Script
		pg_query($conn, $executeSql);
	}
	/**** Database ****/
	
	$showForm = true;

	// https://xkcd.com/327/
    function sanitize($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
    }
	
    // Associative array containing all majors.
	$majors = array(
      "CS"  => "Computer Science",
      "SE"  => "Software Engineering",
      "WDD" => "Web Design and Development",
      "CIT" => "Computer Information Technology",
      "CE"  => "Computer Engineering"
	);

	$creditlevels = array(
      "SM"	=> "Sophomore",
      "JR"	=> "Junior",
      "SR"	=> "Senior",
      "MS"	=> "Masters",
      "PHD"	=> "PhD"
	);

	$livinglocales = array(
      "ON"	=> "On Campus",
      "OFF"	=> "Off Campus"
	);

	$timezones = array(
      "N11"	=> "UTC - 11",
      "N10"	=> "UTC - 10",
      "N9"	=> "UTC - 9",
      "N8"	=> "UTC - 8",
      "N7"	=> "UTC - 7",
      "N6"	=> "UTC - 6",
      "N5"	=> "UTC - 5",
      "NL"	=> "Not Listed",
	);

	$name = "";
	$email = "";
	$major = "";
	$creditlevel = "";
	$livinglocale = "";
	$timezone = "";
	$displayMajor = "";

    $nameErr = "";
    $emailErr = "";
    $majorErr = "";
	$creditlevelErr = "";
	$livinglocaleErr = "";
	$timezoneErr = "";
	$writeDb = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' ) 
	{
		$showForm = false;

		// Bypass all of the posting logic if the cookie has already been set.
		if (!isset($_COOKIE[$cookieName]))
		{
			if(!empty($_POST["Name"]))
			{
				$name = sanitize($_POST["Name"]);
			}
			
			if(!empty($_POST["Email"]))
			{
				$email = sanitize($_POST["Email"]);
			}

			if(!empty($_POST["Major"]))
			{
				$major = sanitize($_POST["Major"]);
				// Iterate through majors and store display name
				$displayMajor = $majors[$major];
			}

			if(!empty($_POST["CreditLevel"]))
			{
				$creditlevel = sanitize($_POST["CreditLevel"]);
			}
			
			if(!empty($_POST["LivingLocale"]))
			{
				$livinglocale = sanitize($_POST["LivingLocale"]);
			}

			if(!empty($_POST["TimeZone"]))
			{
				$timezone = sanitize($_POST["TimeZone"]);
			}

			if (empty($name)) { 
				$nameErr = "Name is Required"; 
				$showForm = true;
			} 
				
			if (empty($_POST["Email"])) 
			{ 
				$emailErr = "Email is Required"; $showForm = true; 
			}
			else if (!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) 
			{
				$emailErr = "Invalid Email Format"; 
				$showForm = true;
			}

			if (empty($_POST["Major"])) 
			{ 
				$majorErr = "Major is Required";
				$showForm = true; 
			} 
			   
			if (empty($_POST["CreditLevel"])) 
			{ 
				$creditlevelErr = "CreditLevel is Required";
				$showForm = true; 
			}
						
			if(!$showForm)
			{
				// They have voted, set the cookie
				// Opting to use a cookie instead of a session.
				// If they close their browser the session expires, by using a cookie it will be more persistant
				// setcookie($cookieName, $_SERVER['REMOTE_HOST'], time() + (86400 * 365), "/"); // 86400 = 1 day

				$textStr = "{ \"name\":\"".$name."\", \"email\":\"".$email."\", \"major\":\"".$majors[$major]."\", \"creditlevel\":\"".$creditlevels[$creditlevel]."\", \"livinglocale\":\"".$livinglocales[$livinglocale]."\", \"timezone\":\"".$timezones[$timezone]."\" }";
				
				// Write Results to the Database
				$sql = "INSERT INTO surveylist (hostid, surveydata) VALUES ('".$_SERVER['REMOTE_HOST']."','".$textStr."')";
				pg_query($conn, $sql);
				$writeDb = true;
			}
		}
	}

	if( isset($_COOKIE[$cookieName]) )
	{
		$result = pg_query($conn, "SELECT id, surveydata FROM surveylist");

		$arrayResult = array();
		
		// look through query
		while($row = pg_fetch_assoc($result))
		{
			// add each row returned into an array
			$jsonObj = json_decode($row['surveydata']);
			
			//echo "major " . $jsonObj->{"major"} . "<br>";
			//echo "creditlevel " . $jsonObj->{"creditlevel"} . "<br>";
			//echo "livinglocale " . $jsonObj->{"livinglocale"} . "<br>";
			//echo "timezone " . $jsonObj->{"timezone"} . "<br>";
		
			if(!isset($arrayResult["Major: ".$jsonObj->{"major"}]))
			{
				$arrayResult["Major: ".$jsonObj->{"major"}] = 1;
			}
			else
			{
				$arrayResult["Major: ".$jsonObj->{"major"}] += 1;
			}
		
			if(!isset($arrayResult["Credit Level: ".$jsonObj->{"creditlevel"}]))
			{
				$arrayResult["Credit Level: ".$jsonObj->{"creditlevel"}] = 1;
			}
			else
			{
				$arrayResult["Credit Level: ".$jsonObj->{"creditlevel"}] += 1;
			}

			if(!isset($arrayResult["Campus Locale: ".$jsonObj->{"livinglocale"}]))
			{
				$arrayResult["Campus Locale: ".$jsonObj->{"livinglocale"}] = 1;
			}
			else
			{
				$arrayResult["Campus Locale: ".$jsonObj->{"livinglocale"}] += 1;
			}

			if(!isset($arrayResult["Time Zone: ".$jsonObj->{"timezone"}]))
			{
				$arrayResult["Time Zone: ".$jsonObj->{"timezone"}] = 1;
			}
			else
			{
				$arrayResult["Time Zone: ".$jsonObj->{"timezone"}] += 1;
			}
		}

		$showForm = false;
	}
	
	// clear cookie
	//setcookie( $cookieName, $_SERVER['REMOTE_HOST'], time() - 1360, "/" ); // 86400 = 1 day
	
	// Close the Database connection
	pg_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Assignments Home Page</title>

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
		
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="content/main.css" />
		
		<script src="scripts/jquery-3.1.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="scripts/main.js"></script>

	</head>
	<body onload="testCookieValueAndClearIfSame('visitor','javaScriptPost')">
		<div class="container body-content">

			<!-- Begin Navbar Include -->
			<?php include 'navbar.php' ?>
			<!-- End Navbar Include -->
		
			<div class="row">
				<div class="col-md-12">
					<div class="jumbotron">
						<h1>Prove Assignment 03</h1>
						<p class="lead">This is to prove the concepts aquired.</p>
					</div>
				</div>
			</div>

          <?php if ($showForm): ?>
			
          <div class="row">
              <div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
                  <div class="panel panel-info" style="border-width: 2px;">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-weight: bolder;">
                              Results
                          </h3>
                      </div>
                      <div class="panel-body">
					  
                          <div class="col-md-12">						  
							<button type="button" class="btn" onclick="setCookieAndRedirect('visitor','javaScriptPost','365','Assignment03.php')">View Survey Results</button>					  
                          </div>
						  
						  <div class="col-md-12">
							<form action="" method="POST">
								<div class="form-group">
									<label class="control-label" for="Name">Name *</label>
									<input class="form-control" 
											type="text" 
											name="Name" 
											  id="Name" 
									 placeholder="Name"
										required>
									<span class="error"><?php echo $nameErr; ?></span>
								</div>

								<div class="form-group">
									<label class="control-label" for="Email">Email *</label>
									<input class="form-control"
											type="email" 
											name="Email" 
											  id="Email" 
									 placeholder="Email"
										required>
									<span class="error"><?php echo $emailErr; ?></span>
								</div>

								<label class="control-label" for="Major">Major *</label>
								<br />
								<?php foreach ($majors as $code => $name): ?>
									<div class="radio">
										<input  type="radio"
												name="Major"
												  id="<?php echo $code; ?>"
											   value="<?php echo $code; ?>"
											 required
												<?php if(isset($major) && $code == $major) { echo ' checked'; } ?>>
										<label class="control-label" for="<?php echo $code; ?>"><?php echo $name ?></label>
									</div>
								<?php endforeach ?>
								<br />

								<label class="control-label" for="CreditLevel">Credit Level *</label>
								<br />
								<?php foreach ($creditlevels as $code => $name): ?>
									<div class="radio">
										<input  type="radio"
												name="CreditLevel"
												  id="<?php echo $code; ?>"
											   value="<?php echo $code; ?>"
											 required
												<?php if(isset($creditlevel) && $code == $creditlevel) { echo ' checked'; } ?>>
										<label class="control-label" for="<?php echo $code; ?>"><?php echo $name ?></label>
									</div>
								<?php endforeach ?>
								<br />

								<label class="control-label" for="LivingLocale">Location *</label>
								<br />
								<?php foreach ($livinglocales as $code => $name): ?>
									<div class="radio">
										<input  type="radio"
												name="LivingLocale"
												  id="<?php echo $code; ?>"
											   value="<?php echo $code; ?>"
											 required
												<?php if(isset($livinglocale) && $code == $livinglocale) { echo ' checked'; } ?>>
										<label class="control-label" for="<?php echo $code; ?>"><?php echo $name ?></label>
									</div>
								<?php endforeach ?>
								<br />
								
								<label class="control-label" for="TimeZone">TimeZone *</label>
								<br />
								<?php foreach ($timezones as $code => $name): ?>
									<div class="radio">
										<input  type="radio"
												name="TimeZone"
												  id="<?php echo $code; ?>"
											   value="<?php echo $code; ?>"
											 required
												<?php if(isset($timezone) && $code == $timezone) { echo ' checked'; } ?>>
										<label class="control-label" for="<?php echo $code; ?>"><?php echo $name ?></label>
									</div>
								<?php endforeach ?>
								<br />

								<input class="btn btn-primary" type="submit" name="Submit" value="Submit">
							</form>

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

          <?php else: ?>

		  <?php if ($writeDb): ?>
			  <script>
				setCookieAndRedirect('visitor','saveData','365','Assignment03.php');
			  </script>
		  <?php endif; ?>
		  
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
								<?php 
								if(isset($arrayResult))
								{
									foreach($arrayResult as $key => $one)
									{
										echo "<tr>";
										echo "<td>".$key."</td><td class=\"centerText\"><span class=\"addMargins\">".$one."</span></td>";
										echo "</tr>";
										echo "<tr><td colspan=\"2\"><hr /></td></tr>";
									}
								}
								?>
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

          <?php endif; ?>
	  </div>
	</body>
</html>
