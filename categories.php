<?php
//Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include 'stored.php';

//connect to database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "abadjier-db", $myPassword, "abadjier-db");


//check to make sure it's connected
if ($mysqli->connect_errno) 
{
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
//} else {
	//echo "Connection OK";
}
//START A SESSION
session_start();

//check if the user is signed in
 if(!isset($_SESSION['user_name']))		//user has not signed in
 {
   $_SESSION = array(); //clears out all data stored in SESSION
		session_destroy();	//destroy the session - cookie that identifies it is destroyed
		header("Location:introPage.html");
 }
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Categories</title>
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
			<div id="currentTab">categories</div>			
		</div>
		<div id="content">
		  <h2>Categories</h2>
			<h4>Click on each name to see questions in that category</h4>

<?php	
$query =  'SELECT * FROM `forum_categories`';

 	

if(!($stmt = $mysqli->prepare($query)))
{
	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

if (!($stmt->execute())) {
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;}	

if (!($stmt->bind_result($catId, $cat, $descript))) {
	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;}

$count = 0;	
echo "<table><tr>";
while($stmt->fetch())
{	
  //print out in a table  
  echo "<td class='catTable'><div id='catName'><a href='questionsList.php?category=". $cat . "'>" . $cat .  "</a></div>" . $descript . "</td>" ;
	$count++;
	if($count == 4)	//print 2 records per row
	{
	  echo "</tr><tr>";
		$count = 0;
	}    
}


echo "</tr></table>";
						
// close statement
$stmt->close(); 
?>



</div><!--content-->
	</div><!--wrapper-->
	<div id="footer"><p>Created by Ralitza Abadjieva</p></div>
</body>
</html>