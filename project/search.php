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
		unset($_SESSION["user_id"]);
		unset($_SESSION["name"]);
		header("Location:index.php");
	}
?>

<?php
$search=$_POST['search'];
if(isset($search)){
	$search_query=mysql_query("select user_id, name, surname, image, city, login from users where name like '$search%' or login like '$search%'");
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
	<script type="text/javascript" src='like.js'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="friend_page_style.css">
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
.author{
	width: 500px;
}
.delete{
	float: right;
}
.delete i{
	color: #D4D4D4;
	font-size: 15px;
}
.delete label{
	cursor: pointer;
    text-align: center;
}
#hidden-delete{
	outline: 0;
    opacity: 0;
    pointer-events: none;
    user-select: none;
    border: none;
    padding: 0;
}
.delete i:hover{
	color: gray;
}
#none{
	display: none;
}
#input{
	min-height: 30px;
	box-shadow: none;
	border-radius: 7px;
	border-width: 1px;
    border-style:solid;
    border-color: #CCCCCC;
    padding-left: 27px;
    width: 400px;
    background-color: #F4F7F7;
}
#input:focus{
	border-color: #463E7A !important;
	border-style: solid;
	outline: none;
	background-color: #fff;
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
					$rs=mysql_num_rows($search_query);
					echo "<div class='padding'><div class='title'>Results <font>$rs</font></div><hr>";
					
					for ($j =0; $j <$rs ; ++$j){
						$table_user = mysql_fetch_assoc($search_query);
						$id_user=$table_user['user_id'];
						$name_user=$table_user['name'];
						$surname_user=$table_user['surname'];
						$login_user=$table_user['login'];
						$image_user=base64_encode($table_user['image']);
						$city_user=$table_user['city'];

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
									<a href='http://socnet/profile_page.php?id=$id_user&login=$login_user'><font>$name_user $surname_user</font><br></a>
									<font id='city'>$city_user</font>
								</div>
							</div>";
					}
					echo "</div>";
					
				?>		
		</div>

		<div class="third">
			<div class="weather">
				<div class="location"><p>You didn't indicate your location.</p></div>
				<div class="notification"></div>
				<div class="weather-container">
					
					<div class="weather-icon"><img src="unknown.png"></div>
					<div class="description">
						<div class="temperature-value"><p>-<span>&#176;</span><span>C</span></p></div>
						<div class="temperature-description"><p>-</p></div>
					</div>
					
				</div>
			</div>
			
<script type="text/javascript">
	const iconElement = document.querySelector(".weather-icon");
	const tempElement = document.querySelector(".temperature-value p");
	const descElement = document.querySelector(".temperature-description p");
	const notificationElement = document.querySelector(".notification");
	const locationElement = document.querySelector(".location p");
	const weather = {};

	weather.temperature = {
		unit : "celsius"
	}

	const name=<?php echo json_encode($city);?>;

	const KELVIN = 273;

	const key = "fde6ca68d5e26e764cd7780bf1656338";

				
	getWeather(name);
				
	function getWeather(name){
				let api = `http://api.openweathermap.org/data/2.5/weather?q=${name}&appid=${key}`;
				    
				fetch(api)
				    .then(function(response){
				        let data = response.json();
				        return data;
				    })
				    .then(function(data){
				       	weather.temperature.value = Math.floor(data.main.temp - KELVIN);
				        weather.description = data.weather[0].description;
				        weather.iconId = data.weather[0].icon;
				        weather.city = data.name;
				        weather.country = data.sys.country;
				        })
				    .then(function(){
				        displayWeather();
				    });
				}

	function displayWeather(){
		iconElement.innerHTML = `<img src="${weather.iconId}.png"/>`;
		tempElement.innerHTML = `${weather.temperature.value}<span>&#176;</span><span>C</span>`;
		descElement.innerHTML = weather.description;
		locationElement.innerHTML = `${weather.city}, ${weather.country} weather`;
	}
</script>
			<div class="find-friends">
				<h4>Find Friends</h4>
				<?php
					$have_friend=mysql_query("select follows_id from friends where user_id='$user' and friend=1");
					$have_friend_row=mysql_num_rows($have_friend);
					$friends=array();
					for($f=0; $f<$have_friend_row; ++$f){
						$rw=mysql_fetch_row($have_friend);
						$f_id=$rw[0];
						array_push($friends, $f_id);
					}
					$comma=implode(",", $friends);
					$their_friend=mysql_query("select follows_id from friends where user_id in ($comma) and friend=1");
					if($their_friend){
						$qwerty=mysql_num_rows($their_friend);
						$new_array=array();
						for($a=0; $a<$qwerty; ++$a){
							$ra=mysql_fetch_row($their_friend);
							$id=$ra[0];
							if($id!=$user){
								array_push($new_array, $id);
							}
						}
						$com=implode(",", $new_array);
					}
					if(!empty($com)){
					$final=mysql_query("select * from users where user_id in ($com) order by rand() limit 10");
					if(!$final) die('ERRROR '. mysql_error());
					$final_num_row=mysql_num_rows($final);

					for ($b = 1 ; $b <=$final_num_row ; ++$b){	
							$final_row = mysql_fetch_row($final);
							$u_n=mysql_query("select user_id, name, surname, login from users where user_id=$final_row[0]");
							$table_u_name = mysql_fetch_assoc($u_n);
							$name_u=$table_u_name['name'];
							$surname_u=$table_u_name['surname'];
							$id_u=$table_u_name['user_id'];
							$login_u=$table_u_name['login'];
							echo "<div class='user'>
									<a href='http://socnet/profile_page.php?id=$id_u?login=$login_u'>
									<p>$b. $name_u $surname_u</p>
									</a>
								</div>";
						}
					}
					if ($have_friend_row==0 or empty($com)){
						array_push($friends, $user);
						$c=implode(",", $friends);
						$res = mysql_query("select * from users where user_id not in ($c) order by rand() limit 10");
						if (!$res) die ("Select * error: " . mysql_error());
						$rs=mysql_num_rows($res);
						for ($j = 1 ; $j <=$rs ; ++$j){	
							$r = mysql_fetch_row($res);
							$user_n=mysql_query("select user_id, name, surname, login from users where user_id=$r[0]");
							if (!$user_n) die ("Select name error: " . mysql_error());
							$table_user_name = mysql_fetch_assoc($user_n);
							$name_user=$table_user_name['name'];
							$surname_user=$table_user_name['surname'];
							$id_user=$table_user_name['user_id'];
							$login_user=$table_user_name['login'];
							echo "<div class='user'>
									<a href='http://socnet/profile_page.php?id=$id_user?login=$login_user'>
									<p>$j. $name_user $surname_user</p>
									</a>
								</div>";
						}
					}
				?>
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