<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		die();
	}
	else{
		$user=$_SESSION['user_id'];
	}
	$connect = mysql_connect("127.0.0.1", "root", "");
	if (!$connect) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db("socnet_data_base")
					or die("Unable to select database: " . mysql_error());
	$query = mysql_query("select * from users where user_id='$user'");
	$row = mysql_fetch_assoc($query);
	$name=$row['name'];
	$surname=$row['surname'];
	$show_img = base64_encode($row['image']);
	$old_mail=$row['mail'];
	$old_login=$row['login'];
	$old_password=$row['password'];
?>
<?php
	$logout=$_POST['logout'];
	if($logout){
		unset($_SESSION["id"]);
		unset($_SESSION["name"]);
		header("Location:index.php");
	}
?>
<?php
	$update=$_POST['update'];
	if(isset($update)){
		$new_mail=$_POST['new_mail'];
		$new_login=$_POST['new_login'];
		if($new_mail!=$old_mail){
			$up_mail=mysql_query("update users set mail='$new_mail' where user_id='$user'");
		}
		if($new_login!=$old_login){
			$up_login=mysql_query("update users set login='$new_login' where user_id='$user'");
		}
		if(isset($up_mail) or isset($up_login)){
			header("Location:settings.php");
		}
	}
	$update_pass=$_POST['update_pass'];
	if(isset($update_pass)){
		$old_password_check=$_POST['old_password_check'];
		$new_password=$_POST['new_password'];
		$confirm_password=$_POST['confirm_password'];
		if(!empty($old_password_check)){
			if($old_password_check==$old_password){
				if($new_password==$confirm_password){
					$up_password=mysql_query("update users set password='$new_password' where user_id='$user'");
					echo "<script>
						alert('Your password has been changed.');
					</script>";
				}
				else{
					$error='Different passwords';
				}
			}
			else{
				$error='Wrong old password';
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>SocNet</title>
	<link rel="icon" type="image" href="icon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="main_page_style.css">
	<link rel="stylesheet" type="text/css" href="footer.css">
	<link rel="stylesheet" type="text/css" href="profile_page_style.css">
	<link rel="stylesheet" type="text/css" href="settings.css">
</head>
<body>
	<header>
		<ul>
			<li id="label">
				SocNet
			</li>
			<div style="float: right;">
			<li>
				 <div class="input-icons"> 
				 	<i class="fa fa-search icon"></i>
					<form method="post" action="search.php">
					<input class="submit_on_enter" type="text" name="search" placeholder="Search" autocomplete="off" required="required" id="input">
					</form>
				</div>
			</li>
			<li>
				<?php
					if(!empty($show_img)){?>
							<img src='data:image/jpeg;base64, <?=$show_img ?>' alt='' width='35px' height='35px' class='round-image' style='object-fit: cover;'>
					<?php }
					else{
						?><img src='account_1.png' alt='this must be img' width='35px' class='round-image'>
						<?php
						}
				?>
			</li>
			<li>
				
			</li>
			<li>
				<font id="name"><?php echo $name;?></font>
				<i class="fa fa-sort-desc dropbtn" onclick="myFunction()"></i>
				<div id="myDropdown" class="dropdown-content">
				    <a href="http://socnet/main_page.php?id=<?php echo $user;?>">Home</a>
				    <a href="my_profile_page.php?id=<?php echo $user;?>">My Page</a>
				    <a href="settings.php?id=<?php echo $user;?>">Settings</a>
				    <form method="post">
				    	<input type="submit" name="logout" id="dropdown-logout" value="Log Out">
					</form>
				  </div>
			</li>
			</div>
		</ul>
	</header>
<script>
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
<script type="text/javascript">
	$(document).ready(function() {
	  $('.submit_on_enter').keydown(function(event) {
	    if (event.keyCode == 13) {
	      this.form.submit();
	      return false;
	    }
	  });
	});
</script>	
	<section class="container">
		<div class="first">
			<div class="profile-card">
				<div class="profile-img">
					
						<?php
							if(!empty($show_img)){?>
									<img src='data:image/jpeg;base64, <?=$show_img ?>' alt='' width='35px' class="account">
							<?php }
							else{
								?><img src='account_1.png' alt='this must be img' width='35px' class="account">
								<?php
								}
						?>

						<?php echo $name; echo " "; echo $surname;?>
					
				</div>
				<div class="profile-detail">
					<font>Welcome back, <?php echo $name; ?>!</font>
					<hr id="red-hr">
					<font id="sect">My Profile</font><br>
					<div class="list">
						<a href="my_profile_page.php?id=<?php echo $user;?>"><i class="fa fa-user"></i>  My Page</a>
					</div>
					<div class="list">
						<a href="my_photos_page.php?id=<?php echo $user;?>"><i class="fa fa-camera"></i> Photos</a>
					</div>
					<div class="list">
						<a href="my_liked_page.php"><i class="fa fa-heart"></i> Liked</a>
					</div>
					<div class="list">
						<a href="settings.php?id=<?php echo $user;?>"><i class="fa fa-cog"></i> Settings</a>
					</div>
					<br>
					<font id="sect">Community</font><br>
					<div class="list">
						<a href="message.php?id=<?=$user?>"><i class="fa fa-comments-o"></i> Message</a>
					</div>
					<div class="list">
						<a href="my_friends_page.php?id=<?php echo $user;?>"><i class="fa fa-users"></i> Friends</a>
					</div>
					<hr>
					<div class="list">
						<form method="post">
						<i class="fa fa-sign-out"></i><input type="submit" name="logout" value="Log Out" id="logout"> 
						</form>
					</div>
					
				</div>
			</div>
		</div>
		<div class="seconds">
			<form action="" method="post" enctype="multipart/form-data">
			<div class="profile">
				<center><h3>Settings</h3></center>
				Mail: 
				<div class="profile-info">
					<div class="flex">
						<div class="words">
							<div class="font">
								<font id="spaces">New mail: </font>
							</div>
							<div class="inputs">
								<input type="text" name="new_mail" id="new-input" value="<?=$old_mail?>" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
				Login: 
				<div class="profile-info">
					<div class="flex">
						<div class="words">
							<div class="font">
								<font id="spaces">New login: </font>
							</div>
							<div class="inputs">
								<input type="text" name="new_login" id="new-input" value="<?=$old_login?>" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
				<br>
				<center><input type="submit" name="update" value="save" id="upload_button" style="float: none;"></center>
				Password:
				<div class="profile-info">
					<div>
						<div class="words">
							<div class="font">
								<font id="spaces">Old password: </font>
							</div>
							<div class="inputs">
								<input type="text" name="old_password_check" id="new-input" autocomplete="off">
							</div>
						</div>

						<div class="words">
							<div class="font">
								<font id="spaces">New password: </font>
							</div>
							<div class="inputs">
								<div class="info">
								<input id="psw" name="new_password" autocomplete="off" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
								<div id="message">
								  <h5>Password must contain the following:</h5>
								  <p id="letter" class="invalid"> A lowercase letter</p>
								  <p id="capital" class="invalid"> A capital (uppercase) letter</p>
								  <p id="number" class="invalid"> A number</p>
								  <p id="length" class="invalid"> Minimum 8 characters</p>
								</div>
								</div>
							</div>
						</div>
						<div class="words">
							<div class="font">
								<font id="spaces">Confirm password: </font>
							</div>
							<div class="inputs">
								<input type="text" name="confirm_password" id="new-input" autocomplete="off">
							</div>
						</div>
					</div>
				</div>
			<center><div style="color: red;"><?php echo $error;?></div></center>
			<br>
			<center><input type="submit" name="update_pass" value="save" id="upload_button" style="float: none;"></center>
			</div>
			</form>
		</div>
</section>
<script type="text/javascript">

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
<footer>
	<div class="block">
		<i class="fa fa-phone"></i><br>
		<a href="tel:+77472435321">+7(747) 243 53 21</a><br><br>
		<a href="tel:+77022189510">+7(702) 218 95 10</a>
	</div>
	<div class="block">
		<i class="fa fa-envelope"></i><br>
		<a href="mailto:anar.kazezova@gmail.com">anar.kazezova@gmail.com</a><br><br>
		<a href="mailto:bb303030@mail.ru">bb303030@mail.ru</a>
	</div>
	<div class="block">
		<i class="fa fa-map-marker"></i><br>
		Tole bi st. 59 , 050000, Almaty city Republic of Kazakhstan
	</div>
	<div class="block">
		<i class="fa fa-paper-plane-o"></i><br>
		@Anar11235
	</div>
</footer>			
</body>
</html>