<?php
$dbServername = "localhost";
$dbUsername = "amara";
$dbPassword = "2yYu_*)6[ErxIMPI";
$dbName = "studyconnect_login";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    echo "its working";
}
?>