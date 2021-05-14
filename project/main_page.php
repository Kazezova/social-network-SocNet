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
	date_default_timezone_set('Asia/Oral');
	$upload_button=$_POST['upload_button'];
	if(isset($upload_button)){
		$body=addslashes($_POST['body']);
		$img_type = substr($_FILES['img_upload']['type'], 0, 5);
		$img_size = 2*1024*1024;
		if(!empty($_FILES['img_upload']['tmp_name']) and $img_type === 'image' and $_FILES['img_upload']['size'] <= $img_size){ 
		$img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
		}
		// $video = file_get_contents($_FILES['video_upload']['tmp_name']);
		$video_name=$_FILES['video_upload']['name'];
		$video=$_FILES['video_upload']['tmp_name'];
		// $uploads_dir='videos/';
		move_uploaded_file($video, 'videos/'.$video_name);
		// $date=date("Y-m-d h:i:sa");
		$up=mysql_query("insert into posts (p_body, p_image, p_video_name, user_id)  values ('".$body."','".$img."','".$video_name."', '".$user."')");
		if(!$up) die ("Insert error: " . mysql_error());
		header("Location:main_page.php");
	}
?>
<?php
$remove_post=$_POST['delete'];
$delete_post_id=$_POST['delete_post_id'];
if(isset($remove_post)){
	$is_share=mysql_query("select * from share_posts where author_id='$user' and post_id='$delete_post_id'");
	$is_share_num=mysql_num_rows($is_share);
	if($is_share_num!=0){
		$delete_share=mysql_query("delete from share_posts where author_id='$user' and post_id='$delete_post_id'");
	}
	$remove=mysql_query("delete from posts where user_id='$user' and post_id='$delete_post_id'");
	if(!$remove) die ("Remove error: " . mysql_error());
	header("Location:main_page.php?id=$user");
}
?>
<?php
date_default_timezone_set('Asia/Oral');
$share=$_POST['share_button'];
$share_post_id=$_POST['share_post_id'];
if(isset($share)){
	$is_share=mysql_query("select * from share_posts where user_id='$user' and post_id='$share_post_id'");
	$is_share_num=mysql_num_rows($is_share);
	if($is_share_num==0){
		$select_author=mysql_query("select user_id from posts where post_id='$share_post_id'");
		$select_author_fetch=mysql_fetch_assoc($select_author);
		$share_author_id=$select_author_fetch['user_id'];
		$insert_share=mysql_query("insert into share_posts (user_id, author_id, post_id) values ('$user', '$share_author_id', '$share_post_id')");
		if(!$insert_share) die ("Insert share error: " . mysql_error());
		header("Location:main_page.php?id=$user");
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="comment_page.css">
	<script type="text/javascript" src="profile_like.js"></script>
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
			<div  class="comment-home-conatiner">
			       <?php
			        include('comment.php');
			       ?>
			 </div>    
			<form method="post" action="" enctype="multipart/form-data">
			<div class="new-post">
				<textarea type="text"name="body" placeholder="Anything new?" id="new-post"></textarea>
				<div class="file-upload">
					<input type="file" name="img_upload" id="img_upload" class="inputfile" accept="image/*">
					<label for="img_upload" class="label"><i class="fa fa-image"></i></label>
					<input type="file" name="video_upload" id="video_upload" class="inputfile" accept="video/*,.avi,.mp4,.3gp,.mpeg,.mov,.flv,.f4v,.wmv,.mkv,.webm,.vob,.rm,.rmvb,.m4v,.mpg,.ogv,.ts,.m2ts,.mts,.mxf">	
					<label for="video_upload" class="label"><i class="fa fa-film"></i></label>
					<input type="submit" name="upload_button" id="upload_button" value="Publish">
				</div>
			</div>
			<br>
				<div class="onoffswitch">
					<?php
					if(isset($_POST['new'])){
						$sort=mysql_query("update users set sort_id=1 where user_id='$user'");
					}
					if(isset($_POST['old'])){
						$sort_up=mysql_query("update users set sort_id=0 where user_id='$user'");
					}?>
					<?php
						$sort_id=mysql_query("select sort_id from users where user_id='$user'");
						$rrr = mysql_fetch_assoc($sort_id);
						$check=$rrr['sort_id'];
						if($check==0){
							echo "<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='myonoffswitch' onclick='if(this.checked){check()} else{remove()}' unchecked>";
						}
						else{
							echo "<input type='checkbox' name='onoffswitch' class='onoffswitch-checkbox' id='myonoffswitch' onclick='if(this.checked){check()} else{remove()}' checked>";
						}
					?>
			    
			    <label class="onoffswitch-label" for="myonoffswitch">
			        <span class="onoffswitch-inner"></span>
			        <span class="onoffswitch-switch"></span>
			    </label>
			    <input type="submit" name="old" style="display: none;" id="old">
			    <input type="submit" name="new" style="display: none;" id="new">
				</div>
			</form>
<script type="text/javascript">
	function check(){
		document.getElementById('new').click();
	}
	function remove(){
		document.getElementById('old').click();
	}
	
</script>
					<?php
					if($check==1){
						$a='desc';
					}
					else{
						$a='asc';
					}
					$friend=mysql_query("select follows_id from friends where user_id='$user' and friend=1");
					$friend_num=mysql_num_rows($friend);
					$array=array();
					array_push($array, $user);
					for($k=1; $k<=$friend_num; ++$k){
						$friend_row=mysql_fetch_row($friend);
						$friend_id=$friend_row[0];
						array_push($array, $friend_id);
					}
					$comma_separated=implode(",", $array);
					$results=mysql_query("select * from posts where user_id in ($comma_separated) order by post_id $a");
					
					if (!$results) die ("Select * error: " . mysql_error());
					$row_post=mysql_num_rows($results);
					for ($i = 1 ; $i <=$row_post ; ++$i){	
						$each_row = mysql_fetch_row($results);
						$author_detail=mysql_query("select user_id, name, image from users where user_id=$each_row[5]");
						if (!$author_detail) die ("Select name error: " . mysql_error());
						$author_detail_fetch = mysql_fetch_assoc($author_detail);
						$author_name=$author_detail_fetch['name'];
						$author_img=base64_encode($author_detail_fetch['image']);
						$userImage=base64_encode($author_detail_fetch['image']);
						$author_id=$author_detail_fetch['user_id'];
						$userId=$author_detail_fetch['user_id'];
						if(!empty($author_img)){
							$str="data:image/jpeg;base64, '".$author_img."'";
							}
						else{
							$str='account_1.png';
						}

						$post_data=$each_row[4];
						$post_img=base64_encode($each_row[2]);
						$post_video_name=$each_row[7];
						$post_body=$each_row[1];
						$post_id=$each_row[0];
						$postId=$each_row[0];
						$like=mysql_query("select like_id from likes where post_id='$post_id' and user_id='$user'");
						$like_exist=mysql_num_rows($like);
						echo "<div class='post'>
								<div class='author-info' style='display: flex;'>"?>
							<?php
							if(!empty($author_img)){?>
									<img src='data:image/jpeg;base64, <?=$author_img ?>' class='post_icon'>
							<?php }
							else{
								?><img src='account_1.png' class='post_icon'>
								<?php
								}
									
								echo "<div class='author'>
										<font id='post_author_name'>$author_name</font><br>
										<font id='post_date'>date: $post_data</font>
									</div>";
								if($author_id==$user){
									echo "<form method='post' action=''>
								<div class='delete'>
									<abbr title='Delete post'>
									<label>
										<i class='fa fa-close'>
											<input type='submit' name='delete' id='hidden-delete' value='.'>
										</i>
									</label>
									<input type='text' name='delete_post_id' value='$post_id' id='none'>
									</abbr>
								</div>
								</form>";
								}
								echo "</div>
								<div class='content'>
								<div id='post-body'>$post_body</div>";
						if(!empty($post_img)){
							echo "<div class='post_image'>
										<center><img src='data:image/jpeg;base64,$post_img' class='post-picture'></center>
									</div>";
						}
						if(!empty($post_video_name)){

							echo "<div class='post_video'>
									<video class='post_video' controls>
										<source src='videos/$post_video_name' type='video/mp4'>
									</video>
								</div>";
						}
						 echo "</div>
                                <div class='interactive'>
                                ".make_like($conn, $user, $postId)." 
                                ".make_posts($conn, $postId)."
							";
							echo "    <a href='#comment' class='comment_button' data-user_image='$userImage' data-user_id='$userId' data-post_id='$postId'><i class='fa fa-comment-o'> </i></a>
                                <div class='post-detail-container'>
                                ".make_posts_comment($conn, $userId ,$postId)."
                                </div>";
                            if($author_id!=$user){
								echo			
									"<abbr title='Share post'>
									<label>
									<i class='fa fa-share-square'></i>
									<form method='post'>
										<input type='submit' name='share_button' id='hidden-delete' value=''>
									</label>
										<input type='text' name='share_post_id' value='$post_id' id='none'>
									</abbr>
									</form>";
								}
							else{
								echo "<input type='submit' name='share_button' id='hidden-delete' value=''>";
							}
                            echo        
                                "</div>
                            </div>";
						
					}
					include('connect.php'); 
	function make_like($conn, $userId , $postId){
		 $sql = "select * from post_like where user_id= '$userId' and post_id='$postId'";
		$result = mysqli_query($conn, $sql);
		if($row = mysqli_num_rows($result)>0){
			$output = '<a class="like_button" data-action="unlike" data-user_id="'.$userId.'" data-post_id="'.$postId.'"><i class="fa fa-heart" style="color:red;"></i></i></a>';
		}
		else{
			$output = '<a class="like_button" data-action="like" data-user_id="'.$userId.'" data-post_id="'.$postId.'"><i class="fa fa-heart-o" style="color:red;"></i></a>';
		}
		return $output;
	 }
	 if($_POST['action_like']=='like'){
		 $userId = $_POST['user_id'];
		 $postId = $_POST['post_id'];
		 $query = "insert into post_like(user_id, post_id) values ('$userId','$postId')";
		 $query_result = mysqli_query($conn, $query);
	 }
	 
	 if($_POST['action_like']=='unlike'){
	     $userId = $_POST['user_id'];
		 $postId = $_POST['post_id'];
		 $query = "delete from post_like where user_id='$userId' and post_id='$postId'";
		 $query_result = mysqli_query($conn, $query);
	 }
	 function make_posts($conn, $postId){
		 $sql = "select count(*) as sum from post_like where post_id='$postId'";
		$result = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_assoc($result);
		$row_result = $row['sum'];
		if($row_result==null){
			$output = '<b>0</b>';
			
		}else{
			$output = '<b>'.$row_result.'</b>';
		}
		
		 return $output ;
		  
	  }
	  function make_posts_comment($conn, $userId ,$postId){
		 $sql = "SELECT count(*) As sum FROM `post_comment` WHERE `post_id` = '$postId'";
		$result = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_assoc($result);
		$row_result = $row['sum'];
		if($row_result==null){
			$output = '<a><p style="color:#aaa;">View all 0 comments</p></a>';
		}else{
			$output = '<a style="text-decoration:none;" href="#comment" class="comment_button"  data-user_id="'.$userId.'" data-post_id="'.$postId.'"><p style="color:#aaa;">View all '.$row_result.' comments</p></a>';
		}
		 return $output ;
	  }
	  function make_date($conn, $postId){
	    $sql = "SELECT * FROM `posts` WHERE `post_id` = '$postId'";
		$result = mysqli_query($conn, $sql);
	    while($row = mysqli_fetch_assoc($result)){
		$date = $row['date'];
		$output = '<p style="color:#aaa;">'.make_time($date).'</p>';
		}
		 return $output ;
	  }
	  
	  function make_time($time_ago){
		  
		  $time_ago = strtotime($time_ago);
		  
		  $cur_time = time();
		  
		  $time_elapsed = $cur_time - $time_ago;
		  
		  $seconds = $time_elapsed ;
		  
		  $minutes = round($time_elapsed/60);
		  
		  $hours = round($time_elapsed/3600);
		  
		  $days = round($time_elapsed/86400);
		  
		  $weeks = round($time_elapsed/604800);
		  
		  $months = round($time_elapsed/2600640);
		  
		  $years = round($time_elapsed/31207680);
		  
		  if($seconds <=60 ){
			  
			  return "Just now";
		  }
		   else if($minutes <= 60){
			   
			   if($minutes==1){
				   
				   return "a minute ago";
				   
			   }else{
				   
				   return "$minutes minutes ago"; 
			   }
		   }
		  
		  else if($hours <= 24){
			   
			   if($hours==1){
				   
				   return "an hour ago";
				   
			   }else{
				   
				   return "$hours hours ago"; 
			   }
		   }
		   else if($days <= 7){
			   
			   if($days==1){
				   
				   return "yesterday";
				   
			   }else{
				   
				   return "$days days ago"; 
			   }
		   }
		    else if($weeks <= 4.3){
			   
			   if($weeks==1){
				   
				   return "a week ago";
				   
			   }else{
				   
				   return "$weeks weeks ago"; 
			   }
		   }
		    else if($months <= 12){
			   
			   if($months==1){
				   
				   return "a month ago";
				   
			   }else{
				   
				   return "$months monthsago"; 
			   }
		   }
		    else {
			   
			   if($years==1){
				   
				   return "one year ago";
				   
			   }else{
				   
				   return "$years years ago"; 
			   }
		   }
	  }
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
									<a href='http://socnet/profile_page.php?id=$id_u&login=$login_u'>
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
									<a href='http://socnet/profile_page.php?id=$id_user&login=$login_user'>
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