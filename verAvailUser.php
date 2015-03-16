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

$userid = trim($_POST["userid"]);
if ( !$userid || $userid == "")                // if user id is blank
    echo "You must enter a username.";

$query = "SELECT userName FROM forum_users WHERE userName=?";

if(!$stmt = $mysqli->prepare($query))
{
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}
	//bind the parameters
if(!($stmt->bind_param("s",$_POST['userid'])))
{
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
}
if (!($stmt->execute())) {
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;}									
						
if (!($stmt->bind_result($name))) {
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;}

while($stmt->fetch())
{	
  if ($userid == $name)     // if user id is in the database
    echo "This username already exists.<br /> Please choose another username.";  
}
						
// close statement
$stmt->close(); 
?>	