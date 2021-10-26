<?php
session_start();

/**
 * This page is not accessible to any user
 *
 * This page unsets/resets all the information the user has in a session
 */

//unset($_SESSION["user_id"]);
//unset($_SESSION["name"]);
//unset($_SESSION["username"]);
//unset($_SESSION["level"]);

//unsets all the session data (user info)
session_unset();
//redirects user to home page
header("Location:index.php");
?>