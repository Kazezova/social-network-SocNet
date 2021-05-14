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
	$city=$row['city'];
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
$cancel_friend=$_POST['cancel_request'];
$cancel_friend_id=$_POST['cancel_request_id'];

if(isset($cancel_friend)){
	$cancel_relation=mysql_query("delete from friends where user_id='$user' and follows_id='$cancel_friend_id'");
	if(!$cancel_relation) die ("Delete error: " . mysql_error());
	header("Location:my_out_request_page.php?id=$user");
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
	<link rel="stylesheet" type="text/css" href="friend_page_style.css">
	<link rel="stylesheet" type="text/css" href="edit_page_style.css">
</head>
<style type="text/css">
.round-image{
	border-radius: 50%;
}
.post-picture{
	max-width: 500px;
	max-height: 500px;
}
#myBtn {
	display: none;
	position: fixed;
	right: 0px;
	top: 0px;
    z-index: 1;
  	border: none;
  	outline: none;
  	background-color: rgba(70,62,122,0);
  	color: white;
  	cursor: pointer;
  	padding: 10px;
  	width: 80px;
  	height: 100%;
  	border-radius: 2px;
}
#myBtn i{
	font-size: 50px;
	color: rgba(70,62,122,0.5);
}
#myBtn:hover {
  	background-color:  rgba(70,62,122,0.3);
  	color: #fff;
}
#myBtn:hover i{
  	color: #fff;
}
#btn{
	margin-top:10px; 
	border: none;
	width: 125px;
	height: 25px;
	border-radius: 5px;
	border: 1px solid rgba(70,62,122,0.5);
	background-color: rgba(70,62,122,0.7);
	color: #fff;
	outline: none;
}
#btn:hover{
	background-color: rgba(70,62,122,0.8);
	color: #fff;
}
</style>
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
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-sort-up"></i></button>
<script>

var mybutton = document.getElementById("myBtn");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
	<section class="container">
		<div class="first">
			<div class="profile-card">
				<div class="profile-img">
					
						<?php
							if(!empty($show_img)){?>
									<img src='data:image/jpeg;base64, <?=$show_img ?>' alt='' class="account">
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
		<div class="second">
			<?php
					$have_friend=mysql_query("select * from friends where user_id='$user' and friend=0");
					if (!$have_friend) die ("Select * error: " . mysql_error());
					$rs=mysql_num_rows($have_friend);
					echo "<div class='padding'> <div class='title'>All requests <font>$rs</font></div><hr>";
					
					for ($j =0; $j <$rs ; ++$j){	
						$r = mysql_fetch_row($have_friend);
						$user_n=mysql_query("select user_id, name, surname, image, city, login from users where user_id=$r[1]");
						if (!$user_n) die ("Select name error: " . mysql_error());
						$table_user = mysql_fetch_assoc($user_n);
						$id_user=$table_user['user_id'];
						$name_user=$table_user['name'];
						$surname_user=$table_user['surname'];
						$image_user=base64_encode($table_user['image']);
						$city_user=$table_user['city'];
						$login_user=$table_user['login'];
						echo "<div class='friend'>
								<div class='friend-image'>
								<a href='http://socnet/profile_page.php?id=$id_user&login=$login_user'>";
								if(!empty($image_user)){?>
										<img src='data:image/jpeg;base64, <?=$image_user ?>' class='round-image' width='80px' height='80px' style='object-fit: cover;'>
								<?php }
								else{
									?>	<img src='account_1.png' class='round-image' width='80px'>
									<?php
									}
						
						echo	"</a></div>
								<div class='friend-info'>
									<a href='http://socnet/profile_page.php?id=$id_user&login=$login_user'><font>$name_user $surname_user</font></a><br>
									<form method='post'>
									<input type='submit' name='cancel_request' id='btn' value='Cancel request'>
									<input type='text' name='cancel_request_id' value='$id_user' id='none'>
									</form>
								</div>
								
							</div>";
					}
					echo "</div>";
					
				?>		
		</div>
		<div class="third">
			<div class="links">
				<div class="row">
					<a href="my_friends_page.php?id=<?=$user?>">My friends</a>
				</div>
				<div class="row">
					<a href="my_in_request_page.php?id=<?=$user?>">Inbox friend requests</a>
				</div>
				<div class="row" style="background-color: rgba(70,62,122,0.1);">
					<a href="my_out_request_page.php?id=<?=$user?>">Outgoing friend requests</a>
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