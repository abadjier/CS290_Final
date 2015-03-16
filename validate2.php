<?php
//Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$email = trim($_POST["email"]);

#source: http://www.w3schools.com/php/filter_validate_email.asp
if(!isset($_POST['email']) || !$email)
{ 
  echo "You must provide an email.";
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
{
  echo "$email is not a valid email address.";
}
?>