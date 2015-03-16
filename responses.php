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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>My Questions</title>
	<link href="style1.css" type="text/css" rel="stylesheet" />	
</head>
<body>  
  <h1 id="siteName">Code Pop</h1>
  <div id="userbar">
			  <?php				  
					echo 'Hello ' . $_SESSION['user_name'] . '. Not you? <a href="signOut.php">Log out</a>';					
				?>			  
	</div>	
	<div class="wrapper">
	  <div id="menu"> 		  
      <div class="tab"><a href="welcome2.php">my questions</a></div>	
      <div class="tab"><a href="askQuestion.php">ask question</a></div>			
      <div class="tab"><a href="questionsList.php">all questions</a></div>			
			<div class="tab"><a href="categories.php">categories</a></div>			
		</div>
		<div id="content">
<?php
  $questionId = $_GET['id'];
	
	// Get and display the question
	$query = "SELECT question FROM `forum_questions` WHERE questionID =?";
	
	if(!$stmt = $mysqli->prepare($query))
	{
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  //bind the parameters
  if(!$stmt->bind_param('s', $questionId ))
	{
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
  }
  //execute
  if (!($stmt->execute())) 
  {
	  echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
  }
	// bind result
	if (!($stmt->bind_result($question))) 
	{
	  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}	
	while($stmt->fetch())
	{
	  echo "<div id='responseList'><h3>" . $question . "</h3>";
	}
 	// close statement
  $stmt->close();	
	
	//Display answers
	$query2 = "SELECT replyContent, replyDate, userName FROM `forum_replies` INNER JOIN forum_users ON answeredBy = userID
          WHERE questionAnswered=?";
	
	if(!$stmt = $mysqli->prepare($query2))
	{
		echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  //bind the parameters
  if(!$stmt->bind_param('s', $questionId ))
	{
		echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
  }
  //execute
  if (!($stmt->execute())) 
  {
	  echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
  }
	// bind result
	if (!($stmt->bind_result($reply, $date, $user))) 
	{
	  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}	
	
	echo "<table id='displayQuestions'>";
	        
	while($stmt->fetch())
	{
	  echo "<tr><td><div class='questHeader'>" . $user . "</div>" . $date . "</td><td id='replyTD'>"  . $reply . "</td></tr>";	
	}
	// close statement
  $stmt->close();
?>
        </table>
		  </div><!--response list-->			
			<hr>
			<fieldset>
		  <legend><h3>Your answer</h3></legend>			  
			  <form method='post' action='saveAnswer.php'> 		    
					<textarea id='answerText' name='answer'></textarea>
					<?php
						$questionId = $_GET['id'];
						
						echo  '<input type="hidden" name="questionId" value=' . $questionId . '>'; 
					?>					
					<div class='submit'><input name='submit-button' type='submit' value='Post Answer'></div>
				</form>
      </fieldset>	      	
		</div><!--content-->
	</div><!--wrapper-->
	<div id="footer"><p>Created by Ralitza Abadjieva</p></div>
</body>
</html>