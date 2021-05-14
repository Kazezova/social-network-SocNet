<?php
	session_start();
	$connect = mysql_connect("127.0.0.1", "root", "");
	if (!$connect) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db("socnet_data_base")
					or die("Unable to select database: " . mysql_error());
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$login=$_POST['login'];
	$password = $_POST['password'];
	$mail=$_POST['mail'];
	$signUp=$_POST['signUp'];
	if($signUp){
		$result = mysql_query("insert into users (mail, name, surname, login, password) values('".$mail."','".$name."','".$surname."', '".$login."','".$password."')") or die("Unable to connect to MySQL: " . mysql_error());
		if (!$result) die ("Database access failed: " . mysql_error());
		$take=mysql_query("select user_id from users where login='".$login."'") or die("Unable to connect to MySQL: " . mysql_error());
		$row = mysql_fetch_assoc($take);
		$user=$row['user_id'];
		$_SESSION['user_id']=$row['user_id'];
		// $insert_sort=mysql_query("insert into sort (user_id, sort_id) values('".$user."',0)") or die("Unable to connect to MySQL: " . mysql_error());
		header("Location:http://socnet/logIn.php");
	}
?>
<!DOCTYPE html>
	<title>SocNet</title>
	<link rel="stylesheet" type="text/css" href="index-style.css">
	<link rel="stylesheet" type="text/css" href="sign.css">
	<link rel="icon" type="image" href="icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style type="text/css">
	
</style>
<body>
	<header>
		<center><h1>SocNet</h1></center>
	</header>
	<section>
		<div>
		<img src="main_image.jpg">
		</div>
		<div class="sign">
			<div class="sign-header">
				<center><h2>Sign Up to SocNet</h2></center>
			</div>
			<div class="form-sign">
				<form method="post">
					<div class="form-item">
						<label>Name</label><br>
						<input type="text" class="input" placeholder="please enter your real name" name="name" autocomplete="off" required="required">
					</div>

					<div class="form-item">
						<label>Surname</label><br>
						<input type="text" class="input" placeholder="please enter your real surname" name="surname" autocomplete="off" required="required">
					</div>

					<div class="form-item">
						<label>Login</label><br>
						<input type="text" class="input" placeholder="Example: a_kazezova" name="login" autocomplete="off" required="required">
					</div>
						        
					<div class="form-item">
						<label>Password</label><br>
						<input type="password" class="input" id="psw" placeholder="Password" name="password" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
						<div id="message">
						  <h5>Password must contain the following:</h5>
						  <p id="letter" class="invalid"> A lowercase letter</p>
						  <p id="capital" class="invalid"> A capital (uppercase) letter</p>
						  <p id="number" class="invalid"> A number</p>
						  <p id="length" class="invalid"> Minimum 8 characters</p>
						</div>
					</div>
						        
					<div class="form-item">
						<label>Email Address</label><br>
						<input type="email" class="input" placeholder="anar.kazezova@gmail.com" name="mail" autocomplete="off" required="required">
					</div>

					<div class="form-item">
						<input type="checkbox" required="required"> I accept the <a href="rules.php">Community Rules</a>
					</div>
					<div class="form-item">
						<center>
							<input type="submit" class="btn" name="signUp" value="Sign Up">
						</center>
					</div>
					</form>
					<div class="form-item">
						<div class="center">
							Already have an account? <a href="LogIn.php">Login here</a>
						</div>
					</div>
				</div>
			
		</div>
	</section>
<script>
var myInput = document.getElementById("psw");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");


myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}


myInput.onkeyup = function() {
  
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
</body>
</html>