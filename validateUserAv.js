function validateusername()
{				
	//1. Create xhr instance
	var xhr;			//source: http://www.ajax-tutor.com/post-data-server.html
  if (window.XMLHttpRequest) 
	{
    xhr = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) 
	{
    xhr = new ActiveXObject("Msxml2.XMLHTTP");
  }
  else 
	{
    throw new Error("Ajax is not supported by this browser.");
  }
			
  // 2. Define what to do when XHR feed you the response from the server
  xhr.onreadystatechange = function () 
  {
    if (xhr.readyState === 4) 
	  {
      if (xhr.status == 200 && xhr.status < 300) 
		  {
        document.getElementById('divUser1').innerHTML = xhr.responseText;
      }
    }
  }
			
  var userid = document.getElementById("userid").value;
			
  //3. specify action, location and send to the server
  //The third parameter is used to tell the object whether or not to make the call asynchronously. 
  //I've set this to False, indicating that we want to wait until the call returns before continuing.
  //xhr.open('POST', 'verify.php', false);
	xhr.open('POST', 'verAvailUser.php');
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("userid=" + userid);						
}

function validateEmail(){
	var xhr;			
  if (window.XMLHttpRequest) 
	{
    xhr = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) 
	{
    xhr = new ActiveXObject("Msxml2.XMLHTTP");
  }
  else 
	{
    throw new Error("Ajax is not supported by this browser.");
  }
	  
  xhr.onreadystatechange = function () 
  {
    if (xhr.readyState === 4) 
	  {
      if (xhr.status == 200 && xhr.status < 300) 
		  {
        document.getElementById('divEmail').innerHTML = xhr.responseText;
      }
    }
  }
			
  var email = document.getElementById("email").value;
	  
	xhr.open('POST', 'validate2.php');
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("email=" + email);	
}

function validatePass()
{
  var xhr;			
  if (window.XMLHttpRequest) 
	{
    xhr = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) 
	{
    xhr = new ActiveXObject("Msxml2.XMLHTTP");
  }
  else 
	{
    throw new Error("Ajax is not supported by this browser.");
  }
	  
  xhr.onreadystatechange = function () 
  {
    if (xhr.readyState === 4) 
	  {
      if (xhr.status == 200 && xhr.status < 300) 
		  {
        document.getElementById('divPassword').innerHTML = xhr.responseText;
      }
    }
  }
			
  var pass = document.getElementById("pass").value;
	var pass_check = document.getElementById("pass2").value;
			  
	xhr.open('POST', 'validate3.php');
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("pass=" + pass + "&pass_check=" + pass_check);	
}

function validateUserLogin() {
  var xhr;			
  if (window.XMLHttpRequest) 
	{
    xhr = new XMLHttpRequest();
  }
  else if (window.ActiveXObject) 
	{
    xhr = new ActiveXObject("Msxml2.XMLHTTP");
  }
  else 
	{
    throw new Error("Ajax is not supported by this browser.");
  }
	  
		
  xhr.onreadystatechange = function () 
  {
    if (xhr.readyState === 4) //request finished and response is ready
	  {
      if (xhr.status == 200 && xhr.status < 300) // 	200: "OK"
		  {
        
				console.log("Response text is: " + xhr.responseText);
				if(xhr.responseText == null || xhr.responseText == "")
				{
					// go to welcome2
					window.location = "welcome2.php";
				}
				else
				{
				  document.getElementById('divLogIn').innerHTML = xhr.responseText;
				}				
      }
    }
  }
			
  var userId = document.getElementById("logId").value;
	var pass = document.getElementById("logPass").value;
	
			  
	xhr.open('POST', 'validate4.php');
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send("userId=" + userId + "&pass=" + pass);	
	
	return false;
}