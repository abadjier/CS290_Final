<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'stored.php';

//START A SESSION
session_start();
//check if the user is signed in
 if(!isset($_SESSION['user_name']))		//user has not signed in
 {
   $_SESSION = array(); //clears out all data stored in SESSION
		session_destroy();	//destroy the session - cookie that identifies it is destroyed
		header("Location:introPage.html");
 }
 
 //connect to database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "abadjier-db", $myPassword, "abadjier-db");

//check to make sure it's connected
if ($mysqli->connect_errno) 
{
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

  $questionId = $_POST['questionId'];
	// get the user id from this session
	$userId = $_SESSION['user_id'];
	$date = date('Y-m-d G:i:s');
	$answer = $_POST['answer'];				
							
	$query = "INSERT INTO forum_replies(replyContent, replyDate, questionAnswered, answeredBy)
                   VALUES (?, ?, ?, ?)";
		
	if(!$stmt = $mysqli->prepare($query))
	{
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  
	//bind the parameters
  if(!$stmt->bind_param('ssss', $answer, $date, $questionId, $userId ))
	{
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
  }
  if (!($stmt->execute())) 
	{
	  echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}	
	$stmt->close();
	
$string = "responses.php?id=$questionId";
	
	header("Location:$string");
?>