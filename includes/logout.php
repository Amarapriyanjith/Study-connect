<?php
session_start();
session_unset();     // සියලුම session variables ඉවත් කරයි
session_destroy();   // session එක සම්පූර්ණයෙන්ම විනාශ කරයි

// Logout වූ පසු home.php වෙත යැවීම
header("Location: ../home.php");
exit();
?>