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
//} else {
	//echo "Connection OK";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>All Questions</title>
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
      <div id="currentTab"><a href="questionsList.php">all questions</a></div>			
			<div class="tab"><a href="categories.php">categories</a></div>			
		</div>
		<div id="content">		
<?php

#if $_GET is set - display the corresponding questions, if not display all 

# $_GET is not set
if ( !isset($_GET["category"]))
{
  #retrieve all questions from database
  $query = "SELECT questionID, question, questionDetail, questionDate, catName
               FROM `forum_questions`
               INNER JOIN forum_categories
               ON questionCategory = catID
							 ORDER BY questionDate DESC";
							 
	if(!($stmt = $mysqli->prepare($query)))
  {
	  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if (!($stmt->execute())) 
	{
	  echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
	}	
  if (!($stmt->bind_result($qId, $quest, $detail, $date, $qCat))) 
	{
	  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}	
  echo "<h2>Questions in all categories</h2>";
	echo "<table id='displayQuestions'>
	        <tr>
					  <th class='columnWidth1'>Category</th>
					  <th>Questions</th>						
					</tr>";
					
	while($stmt->fetch())
  {	  
		echo "<tr><td class='questHeader'>" . $qCat . "</td><td><div class='questHeader'><a href='responses.php?id=" . $qId . "'>"
		. $quest . "</a></div><div>" . date("F d, Y", strtotime($date)) . "</div>" . $detail . "</td></tr>";			
	}				
	echo "</table>";
	// close statement
 $stmt->close();
					
}
else 
{
  #$_GET["category"] is set
	
	$category = $_GET["category"];
	
	#retrieve questions in the selected category from database
  $query = "SELECT questionID, question, questionDetail, questionDate, catName
            FROM `forum_questions`
            INNER JOIN forum_categories ON questionCategory = catID
            WHERE catName = ?
						ORDER BY questionDate DESC";
	if(!($stmt = $mysqli->prepare($query)))
  {
	  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  }
	//bind the parameters
  if(!($stmt->bind_param("s", $category)))
  {
	  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
  }
  if (!($stmt->execute())) {
	  echo "Execute failed: " . $stmt->errno . " " . $stmt->error;}									
						
  if (!($stmt->bind_result($qId, $quest, $detail, $date, $qCat))) 
	{
	  echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
	}	
  echo "<h2>Questions in category: " . $category . " </h2>";
	echo "<table id='displayQuestions'>
	        <tr>
					  <th class='columnWidth1'>Category</th>
					  <th>Questions</th>						
					</tr>";
					
	while($stmt->fetch())
  {	  
		echo "<tr><td class='questHeader'>" . $qCat . "</td><td><div class='questHeader'><a href='responses.php?id=" . $qId . "'>"
		. $quest . "</a></div><div>" . date("F d, Y", strtotime($date)) . "</div>" . $detail . "</td></tr>";			
	}				
	echo "</table>";
						
// close statement
$stmt->close(); 
	
}
?>

    </div><!--content-->
	</div><!--wrapper-->
	<div id="footer"><p>Created by Ralitza Abadjieva</p></div>
</body>
</html>

