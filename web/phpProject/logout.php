<?php 

	require __DIR__ . '/common.php';

	session_destroy();

	header("Location: index.php"); /* Redirect browser */
	exit();
?>