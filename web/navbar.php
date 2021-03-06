<?php
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$urlPath = $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
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
			<a style="color: white;" class="navbar-brand" href="index.html">CS 313 Course Projects</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-inverse">
				<li>
					<a style="color: white;" class="dropdown-toggle" data-toggle="dropdown" role="button">Prove Assignment List <span class="caret"></span></a>
					<ul class="dropdown-menu navbar-inverse" role="menu">
						<li class="">
							<a style="color: white;" href="hello.html" >Hello</a>
						</li>
						<li class="">
							<a style="color: white;" href="teach02.html" >Teach 02</a>
						</li>
						<li class="">
							<a style="color: white;" href="Assignment03.php" >Assignment 03</a>
						</li>
						<li class="">
							<a style="color: white;" href="MLMLinkup.sql" >MLMLinkup SQL Script 04</a>
						</li>
						<li class="">
							<a style="color: white;" href="<?php echo $urlPath?>/phpProject/index.php" >CS 313 PHP Project</a>
						</li>
					</ul>
				</li>
				<li class="divider-horizontal"></li>
				<li>
					<a style="color: white;" class="dropdown-toggle" data-toggle="dropdown" role="button">Group Work <span class="caret"></span></a>
					<ul class="dropdown-menu navbar-inverse" role="menu">
						<li class="">
							<a style="color: white;" href="teach03.php" >Teach 03</a>
						</li>
						<li class="">
							<a style="color: white;" href="Teach04.sql" >Teach 04</a>
						</li>
						<li class="">
							<a style="color: white;" href="Teach05.php" >Teach 05</a>
						</li>
						<li class="">
							<a style="color: white;" href="Teach06.php" >Teach 06</a>
						</li>
						<li class="">
							<a style="color: white;" href="Teach07.php" >Teach 07</a>
						</li>
					</ul>
				</li>
				<li class="divider-horizontal"></li>
				<li>
					<a style="color: white;" href="https://github.com/MCLifeLeader/CareyMichael_Cs313.git" target="_blank">CS 313 Git Repo</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
