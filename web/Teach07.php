
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
    /*
    CREATE TABLE public.teamusers
    (
        id SERIAL,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    );

    CREATE UNIQUE INDEX UX_teamusers_username ON public.teamusers (username);
*/

  // Database stuff yay!
  $url = parse_url("postgres://qvtwllccjytdzv:161e59a883efbf5c828d87bb2e516e1280b9271a4459dbe723ecc90db3538c88@ec2-54-235-92-236.compute-1.amazonaws.com:5432/d2ok4dig0dekbv");
  $dbopts = $url;
  $database = new PDO("pgsql:host=" . $dbopts['host'] . "; dbname=" . str_replace('/', '', $dbopts['path']),  $dbopts['user'], $dbopts['pass']);
  $db = $database;
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	if (!empty($_POST["username"]) && !empty($_POST["password"])) {
		// query for email and password of user
		$sql0 = $db->prepare("SELECT id, username, password FROM teamusers WHERE username='".$_POST["username"]."'");
		$sql0->execute();
		$result = $sql0->fetch();

		// check result of query
		if(!empty($result["username"]) && !empty($result["password"])) {
    	    $authenticated = password_verify($_POST["password"], $result['password']);
            // authenticate user provided info with database 
            if ($result["username"] == $_POST["username"] && $authenticated) {
                // echo "User Authenticated";
                $_SESSION["IsLoggedIn"] = true;
                $_SESSION["Id"] = $result["id"];
    						$_SESSION["Username"] = $result["username"];
                header( 'location: ./welcome.php' );
                die();
            }
		} else {
      	// redirect to index
        header( 'location: ./Teach07.php' );
        die();
		}
	}

    $database = null;
?>

<html lang="en">
  <head>
    <title>Sign In</title>
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
      <div class="row col-md-12 col-sm-12 col-xs-12">
        <div class="wrapper col-offset-2 col-md-8">
          <form class="form-signin" method="POST" action="">
            <h2 class="form-signin-heading">Please login</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            <br>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <br>
            <button class="btn btn-success" type="submit">Login</button>
            <a href="register.php" id="createNew">Create New Login</a>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
