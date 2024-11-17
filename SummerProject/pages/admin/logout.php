<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired location
header("Location: ../user/login.php ");
exit();
?>
