<?php
    function is_session_started()
    {
        if ( php_sapi_name() !== 'cli' ) {
            if ( version_compare(phpversion(), '5.4.0', '>=') ) {
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

    if ( is_session_started() === FALSE ) {
        session_start();
    }

		$msg = "";

    $url = parse_url("postgres://qvtwllccjytdzv:161e59a883efbf5c828d87bb2e516e1280b9271a4459dbe723ecc90db3538c88@ec2-54-235-92-236.compute-1.amazonaws.com:5432/d2ok4dig0dekbv");
    $dbopts = $url;
    $database = new PDO("pgsql:host=" . $dbopts['host'] . "; dbname=" . str_replace('/', '', $dbopts['path']),  $dbopts['user'], $dbopts['pass']);
    $db = $database;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    // if user is creating a new login account
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (!empty($_POST["createUsername"]) && !empty($_POST["createPassword"]) && !empty($_POST["checkPassword"])) {
            $cUsername = $_POST['createUsername'];
            $cPassword = $_POST['createPassword'];
            $checkPassword =$_POST['checkPassword'];
            $error = false;
            if ($cPassword != $checkPassword) { // if passwords don't match
              $msg .= "Passwords do not match!\n";
              $error = true;
            }
            if(!preg_match('/.{7,}/i', $cPassword)) { // if password is too short
              $msg .= "Passwords do not meet security requirements: Must be at least 7 characters.\n";
              $error = true;
            }
            if(!preg_match('/[0-9]{1,}/i', $cPassword)) { // if password doesn't have a number
              $msg .= "Passwords do not meet security requirements: Must contain at least one number.\n";
              $error = true;
            }
            if (!$error) { // if there has not been an error
              // hash the password
              $hashed = password_hash($cPassword, PASSWORD_DEFAULT);

              $sql = $db->prepare("INSERT INTO teamusers (username, password) VALUES ('$cUsername', '$hashed')");
              $sql->execute();
              $_SESSION["IsLoggedIn"] = true;
              $_SESSION["Id"] = $result["id"];
              $_SESSION["Username"] = $_POST['createUsername'];
              // redirect to welcome page
              header( 'location: ./welcome.php' );
              die();
            }
      } else { // if not all fields are input
        $msg .= "Missing one or more required fields.";
      }
    }
    $database = null;
?>

<html lang="en">
  <head>
    <title>Sign up</title>
		<script src="scripts/jquery-3.1.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<script src="scripts/main.js"></script>

		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="content/main.css" />
  </head>
	<body>
  		<div class="container body-content">

			<!-- Begin Navbar Include -->
			<div id="MenuNav"></div>
			<script>
				document.getElementById("MenuNav").innerHTML = readTextFile( "navbar.php" );				
			</script>
			<!-- End Navbar Include -->

			<div class="row"><div class="col-md-12"><br /><br />&nbsp;</div></div>
    
			<div id="creation">
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<h1>Yay! More school!</h1>
							<form class="form-signin form-horizontal" method="POST" action="" novalidate>
								<h2>You want to join? Sweet!</h2>
								<p>Fill out the form and click submit.</p>
								<p id="errorP" class="text-danger"><?php echo $msg; ?></p>
								<div class="form-group">  
									<label for="username" class="control-label">Username <span class="text-danger">*</span></label>
									<input type="text" id="username" class="form-control" name="createUsername" placeholder="Username" required>
								</div>

								<div class="form-group">
									<label for="createPassword" class="control-label">Password <span class="text-danger">*</span></label>
									<input type="password" class="form-control" id="createPassword" name="createPassword" placeholder="Enter Password"  required onchange="checkpw()">
								</div>

								<div class="form-group">
									<label for="checkPassword" class="control-label">Confirm Password <span class="text-danger">*</span></label>
									<input type="password" class="form-control" id="checkPassword"  name="checkPassword"  placeholder="Repeat Password" required onchange="checkpw()">
								</div>
								<span class="text-danger ">* denotes required field.</span>
								<br>
								<button id="submitCreate" class="btn btn-success" type="submit">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			// on document ready
			$(function() {
				// Create event listener that will fire when the submitCreate button is clicked
				$('#submitCreate').on('click', function(e) {
					var error = false,
					message = "",
					pass = $('#createPassword').val(),
					confPass = $('#checkPassword').val(),
					username = $('#username').val(),
					errorP = $('#errorP'); // Get jquery object from DOM
					if (!username) { // if no username is entered
						message += "Username is required\n";
						error = true;
					} 
					if (!pass) { // if no password is entered
						message += "Password is required\n";
						error = true;
					} 
					if (!confPass) { // if no confirm password is entered
						message += "Password validation is required\n";
						error = true;
					}      
					if (!error && pass !== confPass) { // if passwords do not match
						message += "Passwords do not match\n";
						error = true;
					}
					if (error) { // if there has been an error
						e.preventDefault(); // stop form submit
						errorP.text(message); // display error
					}
				});
			});

			function checkpw() {
				var passfield  = $("#createPassword");
				var checkfield = $("#checkPassword");

				// Define regEx
				var regLenTest = /.{7,}/gi; // must be at least 7 characters
				var regNumTest = /[0-9]{1,}/gi; // must contain a number

				var msg = "";
				if (checkfield.val() && passfield.val() != checkfield.val()) {msg += "Password fields must match!\n\n";}
				if (!regLenTest.test(passfield.val()))   {msg += "Password must contain at least 7 characters!\n\n";}
				if (!regNumTest.test(passfield.val()))   {msg += "Password must contain at least one number!";}
				if (msg) { // if there's an error alert it.
					alert(msg);
				}
			}
		</script>
  </body>
</html>
