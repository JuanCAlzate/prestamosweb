<?php
session_start();

header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
header("Pragma: no-cache"); 

$_SESSION = array();

session_destroy();
header("Location: login.php");
exit();
?>
