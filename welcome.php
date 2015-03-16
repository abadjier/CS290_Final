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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Welcome</title>
	<link href="style1.css" type="text/css" rel="stylesheet" />	
</head>
<body>  
  <h1 id="siteName">Code Pop</h1>	
	<div class="wrapper">
	  <div id="menu">  
		  <a href="introPage.html">home</a>		  
		</div>
		<div id="content">
		
	
<?php
#Create variable names
$userId = $_POST['userid'];
$email = $_POST['email'];
#source: http://stackoverflow.com/questions/3981638/encrypt-password-before-storing-in-database
$password = sha1($_POST['password']); 
#source: http://alvinalexander.com/php/php-date-formatted-sql-timestamp-insert
$date = date('Y-m-d G:i:s');


if(!isset($_POST['password']) || !$password || !isset($_POST['userid']) || !$userId || !isset($_POST['email']) || !$email){
  //echo "Missing data";
	//header("Location: introPage.html");
	echo "Please go back to the homepage complete all fields of the registration form.";  
}


//all seems to be ok
$query = "INSERT INTO `forum_users` (userName, userPass, userEmail, userDate)
				  VALUES (?, ?, ?, ?)";	

if(!$stmt = $mysqli->prepare($query)){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
}

//bind the parameters
if(!$stmt->bind_param('ssss', $userId, $password, $email, $date)){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
}

//execute
if (!($stmt->execute())) {
	echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
/* else {
	echo "Added " . $stmt->affected_rows . " rows to users";*/
}

// close statement
$stmt->close();			 
?>
   
		
		<p>Registration successful! Please go back to the <a href="introPage.html">Home page and log in</a> to start posting.</p>
		</div><!--content-->
		</div><!--"wrapper"-->
		<div id="footer"><p>Created by Ralitza Abadjieva</p></div>  
</body>
</html>