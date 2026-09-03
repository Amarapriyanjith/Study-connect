<<?php
if (isset($_POST["submit"])){

$name =$_POST["name"];
$useremail =$_POST["email"];
$username =$_POST["uid"];
$pwd =$_POST["pwd"];
$pwdreapeat =$_POST["pwdrepeat"];

//database connection make

require_once 'database.php';
require_once 'function.php';
$emptyInputSignup($name,$username,$useremail,$pwd,$pwdreapeat)
$invaliduid = invalidui($username);
$invalidemail = invalidui($useremail);
$pwdMatch = invalidui($username);
$uidExis  =$uidExis($conn,$username,$useremail)
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