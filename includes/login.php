<?php
if (isset($_POST["submit"])){

$username =$_POST["uname"];
$pwd =$_POST["pwd"];


//database connection make
require_once 'database.php';
require_once 'function.php';


if (emptyInputs($username,$pwd)!==false){
   exit();

}
else{
   header('Location: ../login page.html');
exit(); 
}
LogUser($username, $pwd);

}

?>