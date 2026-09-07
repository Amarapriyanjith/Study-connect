<?php
session_start();
session_unset();     // All session variables Remove
session_destroy();   // session destroy

// Logout and go to homepage
header("Location: ../home.php");
exit();
?>