<?php
//Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$pass = trim($_POST["pass"]);
$pass_check = trim($_POST["pass_check"]);

if(!isset($_POST['pass']) || !$pass)
{ 
  echo "You must provide a password.";
}
else if ($_POST['pass'] != $_POST["pass_check"] )
{
  echo "The two passwords did not match. </br>Please re-enter the passwords.";
}
?>