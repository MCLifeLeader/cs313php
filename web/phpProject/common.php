<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

if ( is_session_started() === FALSE ) {
    session_start();
}

if(!isset($_SESSION["IsLoggedIn"] ))
{
    $_SESSION["IsLoggedIn"] = false;
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
