<?php 

	if ( is_session_started() === FALSE ) {
		session_start();
	}

	//$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	//$urlPath = $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-inverse navbar-static-top navbar-fixed-top navbarCustom" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a style="color: white;" class="navbar-brand" href="index.php">Home</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-inverse">
				<li>
					<a style="color: white;" class="dropdown-toggle" data-toggle="dropdown" role="button"> Database Blobs Demo <span class="caret"></span></a>
					<ul class="dropdown-menu navbar-inverse" role="menu">
						<li class="">
							<a style="color: white;" href="images.php" >Images</a>
						</li>
					</ul>
				</li>
				<li class="divider-horizontal"></li>
				<li>
					<a style="color: white;" class="dropdown-toggle" data-toggle="dropdown" role="button"> PayPal Demo <span class="caret"></span></a>
					<ul class="dropdown-menu navbar-inverse" role="menu">
						<li class="">
							<a style="color: white;" href="paypal.php" >PayPal</a>
						</li>
					</ul>
				</li>
				<li class="divider-horizontal"></li>
				<li>
				<?php if($_SESSION["IsLoggedIn"] == true)
				{
					echo "<a style=\"color: white;\" href=\"logout.php\">Logout</a>";
				}				
				else
				{
					echo "<a style=\"color: white;\" href=\"login.php\">Login</a>";
				}
				?>					
				</li>
			</ul>
		</div>
	</div>
</nav>
