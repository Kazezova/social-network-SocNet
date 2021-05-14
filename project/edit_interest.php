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
	
	$interests=$row['interests'];
	$music=$row['music'];
	$films=$row['films'];
	$books=$row['books'];
	$games=$row['games'];
	$about=$row['about'];
	
	
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
		$new_interests=$_POST['new_interests'];
		$new_about=$_POST['new_about'];
		$new_music=$_POST['new_music'];
		$new_films=$_POST['new_films'];
		$new_books=$_POST['new_books'];
		$new_games=$_POST['new_games'];
		if(!empty($new_interests)){
		$up_interest=mysql_query("update users set interests='$new_interests' where user_id='$user'");
		}
		if(!empty($new_about)){
		$up_about=mysql_query("update users set about='$new_about' where user_id='$user'");
		}
		if(!empty($new_music)){
		$up_music=mysql_query("update users set music='$new_music' where user_id='$user'");
		}
		if(!empty($new_films)){
		$up_films=mysql_query("update users set films='$new_films' where user_id='$user'");
		}
		if(!empty($new_books)){
		$up_books=mysql_query("update users set books='$new_books' where user_id='$user'");
		}
		if(!empty($new_games)){
		$up_games=mysql_query("update users set games='$new_games' where user_id='$user'");
		}
		header("Location:edit_interest.php");
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
	<link rel="stylesheet" type="text/css" href="slideshow.css">
	<link rel="stylesheet" type="text/css" href="edit_page_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>	
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
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
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
			<div class="profile" style="display: block;">
				<div class="profile-info" style="margin-left: 60px;">
					<div class="flex">
						<div class="word" style="width: 35%;">
							<font id="spacess">Interest: </font><br>
							<font id="spacess">About myself: </font><br>
							<font id="spacess">Favourite musics: </font><br>
							<font id="spacess">Favourite films: </font><br>
							<font id="spacess">Favourite books: </font><br>
							<font id="spacess">Favourite games: </font><br>
						</div>
						<div class="info" style="width: 45%;">
							<textarea id="new-textarea" name="new_interests"><?= $interests?></textarea><br>
							<textarea id="new-textarea" name="new_about"><?= $about?></textarea><br>
							<textarea id="new-textarea" name="new_music"><?= $music?></textarea><br>
							<textarea id="new-textarea" name="new_films"><?= $films?></textarea><br>
							<textarea id="new-textarea" name="new_books"><?= $books?></textarea><br>
							<textarea id="new-textarea" name="new_games"><?= $games?></textarea><br>		
						</div>
					</div>
				</div>
				<br>
			<center><input type="submit" name="update" value="save" id="upload_button" style="float: none;"></center>
			</div>
			</form>
		</div>
		<div class="third">
			<div class="links">
				<div class="row">
					<a href="edit.php?id=<?=$user?>">Main Information</a>
				</div>
				<div class="row">
					<a href="edit_education.php?id=<?=$user?>">Education</a>
				</div>
				<div class="row">
					<a href="edit_career.php?id=<?=$user?>">Career</a>
				</div>
				<div class="row" style="background-color: rgba(70,62,122,0.1);">
					<a href="edit_interest.php?id=<?=$user?>">Interest</a>
				</div>
			</div>

		</div>	
</section>
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