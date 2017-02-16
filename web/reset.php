<?php 
	if ( is_session_started() === FALSE ) {
		session_start();
	}

	// http://php.net/manual/en/function.session-status.php
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

	session_unset();
	session_destroy();
	header('location: ./');
	die();
?>