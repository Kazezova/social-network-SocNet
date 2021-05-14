<?php
	session_start();
	$connect = mysql_connect("127.0.0.1", "root", "");
	if (!$connect) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db("socnet_data_base")
					or die("Unable to select database: " . mysql_error());
	$login=$_POST['login'];
	$password=$_POST['password'];
	$LogIn=$_POST['LogIn'];
	$check='false';
	if($LogIn){
		$result = mysql_query("select user_id from users where password='".$password."' and login='".$login."'") or die("Unable to connect to MySQL: " . mysql_error());
		if (mysql_num_rows($result)==1) {
			$row = mysql_fetch_assoc($result);
			$_SESSION['user_id']=$row['user_id'];
			$id=$_SESSION['user_id'];
			$i=3;
			$up=mysql_query("update users set try_login='$i' where login='".$login."'");
			header("Location:http://socnet/main_page.php?id=$id");
		}
		else{
			$try = mysql_query("select try_login from users where login='".$login."'");
			if(mysql_num_rows($try)==0){
				$error="Incorrect login:(";
			}
			else{
				$r = mysql_fetch_assoc($try);
				$new=$r['try_login']-1;
				$error="Incorrect password:( You have $new chance.";
				$up=mysql_query("update users set try_login='$new' where login='".$login."'");
				if(!$up) die ("Insert error: " . mysql_error());
				if($new<=0){
					$check='true';
				}
				
			}
		}
	}
?>

<!DOCTYPE html>
	<title>SocNet</title>
	<link rel="stylesheet" type="text/css" href="index-style.css">
	<link rel="stylesheet" type="text/css" href="sign.css">
	<link rel="icon" type="image" href="icon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

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
				<center><h2>Log In to SocNet</h2></center>
			</div>
			<div class="form-sign">
				<form method="post">
					
					<div class="form-item">
						<label>Login</label><br>
						<input type="text" class="input" placeholder="Login" name="login" autocomplete="off" required="required">
					</div>
					<div class="form-item">
						<label>Password</label><br>
						<input type="password" class="input" id="psw" placeholder="Password" name="password" autocomplete="off" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
					</div>
						
					<center>
					<div class="form-item">
						<font size="3px" color="#D40000"><?php echo $error; ?></font><br>
						<!-- <font size="3px"> Forgot your password? </font> -->
					</div>
					</center>        
	
					<div class="form-item">
						<center>
							<h3 style="display: none;" id="wait">Wait <span class="display" name="second">10</span> seconds</h3>
							<input id="button" type="submit" class="btn" name="LogIn" value="Log In" onclick="guess()">
						</center>
					</div>

					</form>
					<div class="form-item">
						<div class="center">
							Don't have an account? <a href="signUp.php">SignUp here</a>
						</div>
					</div>
				</div>
			
		</div>
	</section>
<?php
	if($check=='true'){
		echo "<script type='text/javascript' src='timer.js'>
			</script>";
			$i=3; 
			$up=mysql_query("update users set try_login='$i' where login='".$login."'");
		}
?>
</body>
</html>