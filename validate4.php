<?php
//Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'stored.php';

//connect to database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "abadjier-db", $myPassword, "abadjier-db");


//check to make sure it's connected
if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
//} else {
	//echo "Connection OK";
}

$user = trim($_POST["userId"]);
$pass = sha1(trim($_POST["pass"]));

if ( !isset($_POST["userId"]) ||!$user || $user == "")                // if user id is blank
{
  echo "You must enter a username.";
}

if(!isset($_POST['pass']) || !$pass || $pass == "")
{ 
  echo "You must provide a password.";	
}

$query = "SELECT userId FROM forum_users WHERE userName=? AND userPass=?";

if(!$stmt = $mysqli->prepare($query))
{
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

	//bind the parameters
if(!($stmt->bind_param("ss", $user, $pass)))
{
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}

if (!($stmt->execute())) {
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;}			

$stmt->store_result();
if (!($stmt->bind_result($userId))) {
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;}

if($stmt->num_rows == 0)  // if user id/password combination are not in the database
{
  echo "Invalid username and/or password.<br /> Please try again.";  
}
else 
{
  session_start();
	
  while($stmt->fetch())
  {	
    //log them in     
	  $_SESSION['user_name']  = $user;	
    $_SESSION['user_id'] = $userId;		
  }  
}
	
// close statement
$stmt->close();

?>