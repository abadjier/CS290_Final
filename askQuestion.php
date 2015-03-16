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
	<title>Ask a Question</title>
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
      <div id="currentTab">ask question</div>			
      <div class="tab"><a href="questionsList.php">all questions</a></div>			
			<div class="tab"><a href="categories.php">categories</a></div>
			
		</div>
		<div id="content">
		  <fieldset>
		  <legend><h2>Ask a Question</h2></legend>
			  <form method="post" action="">
				  <p><label class="title" for="question">Question:</label>
					   <input id="question" type="text" name="question"/>
						 </br><i>For detailed information on each category see the <a href="categories.php">'categories'</a> page</i>
             <label class="title" for="category">Category:</label>
						 <select id="cat" name="category">
					  <?php
						  if(!($stmt = $mysqli->prepare("SELECT catID, catName FROM forum_categories")))
							{
								echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
							}

							if(!$stmt->execute())
							{
								echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							if(!$stmt->bind_result($id, $category))
							{
								echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
							}
							while($stmt->fetch())
							{
								echo '<option value=" '. $id . ' "> ' . $category . '</option>\n';
							}
							$stmt->close();
						?>
						</select>	
						
					</br>
					<label class="title" for="qDetail">Question Detail:</label>
					<textarea id="qDetail" name="qDetail"></textarea>
					</p>
					<div class="submit"><input name="submit-button" type="submit" value="Post question"></div>
					
				</form>
				</fieldset>
			<?php
			  // get the user id from this session
				$userId = $_SESSION['user_id'];
				$date = date('Y-m-d G:i:s');
				
			
				$query = "INSERT INTO forum_questions(question, questionDetail, questionDate, questionBy, questionCategory)
                   VALUES (?, ?, ?, ?, ?)";
				
				if($_SERVER['REQUEST_METHOD'] == 'POST')
				{
				  // The form has been posted, save question to database
					// Get the variables from the form
					$question = $_POST['question'];
					$catId = $_POST['category'];
					$detail = $_POST['qDetail'];					
					
					if(!$stmt = $mysqli->prepare($query))
					{
			      echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
          }
          //bind the parameters
          if(!$stmt->bind_param('sssis', $question, $detail, $date, $userId, $catId ))
					{
			      echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
          }
          //execute
          if (!($stmt->execute())) 
					{
	          echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
          }
					else 
					{
					  # source: http://stackoverflow.com/questions/13837375/how-to-show-an-alert-box-in-php
					  echo '<script language="javascript">';
            echo 'alert("Your question has been posted")';
            echo '</script>';
					}
          // close statement
          $stmt->close();					
				}
			?>
		</div><!--content-->
	</div><!--wrapper-->
	<div id="footer"><p>Created by Ralitza Abadjieva</p></div>
</body>
</html>	
	