<?php
session_start();
unset($_SESSION["user_id"]);
unset($_SESSION["name"]);
unset($_SESSION["username"]);
unset($_SESSION["level"]);
header("Location:index.php");
?>