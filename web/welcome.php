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

    if (!$_SESSION["IsLoggedIn"]) {
        header('location: ./Teach07.php');
        die();
    }
?>

<html lang="en">
	<head>
		<title>Welcome</title>
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
			<h1>Yay! More school!</h1>
			<div>
				<div>
					<p>Welcome <?php echo $_SESSION["Username"]; ?>!</p>
				</div>
			</div>
		</div>
	</body>
</html>

