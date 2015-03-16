<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//START A SESSION
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Log out</title>
	<link href="style1.css" type="text/css" rel="stylesheet" />	
</head>
<body>  
  <h1 id="siteName">Code Pop</h1>	
	<div class="wrapper">
	  <div id="menu">		  
      <div class="tab"><a href="introPage.html">Log In</a></div>      		
		</div>
		<div id="content">
		  <?php
		  //check if the user is signed in
      if(isset($_SESSION['user_name']))		//user has signed in
      {
        $_SESSION = array(); //clears out all data stored in SESSION
		    session_destroy();	//destroy the session - cookie that identifies it is destroyed	
				echo "<p>Successfully logged out, thank you for visiting.</p>";
      }
			else
			{
			  echo "<p>You are not logged in.</p>"; 
			}
      ?>
		  
		</div>
	</div><!--wrapper-->
	<div id="footer"><p>Created by Ralitza Abadjieva</p></div>
</body>
</html>
