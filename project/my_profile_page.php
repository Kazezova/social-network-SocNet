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
	$country=$row['country'];
	$city=$row['city'];
	$bd=$row['birthday'];
	$gender=$row['gender'];
	$relationship=$row['relationship'];
	$phone=$row['phone'];
	$school=$row['school'];
	$begin_school=$row['begin_school'];
	$end_school=$row['end_school'];
	$university=$row['university'];
	$specialty=$row['specialty'];
	$uni_status=$row['uni_status'];
	$uni_date_of_issue=$row['uni_date_of_issue'];
	$interests=$row['interests'];
	$music=$row['music'];
	$films=$row['films'];
	$books=$row['books'];
	$games=$row['games'];
	$about=$row['about'];
	$work=$row['work'];
	if(is_null($bd)){
		$bd='-';
	}
	if(is_null($gender)){
		$gender='-';
	}
	if(is_null($country)){
		$country='-';
	}
	if(is_null($city)){
		$city='-';
	}
	if(is_null($relationship)){
		$relationship='-';
	}
	if(is_null($phone)){
		$phone='-';
	}
	
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
$remove_post=$_POST['delete_post'];
$delete_post_id=$_POST['delete_post_id'];
if(isset($remove_post)){
	$is_share=mysql_query("select * from share_posts where author_id='$user' and post_id='$delete_post_id'");
	$is_share_num=mysql_num_rows($is_share);
	if($is_share_num!=0){
		$delete_share=mysql_query("delete from share_posts where author_id='$user' and post_id='$delete_post_id'");
	}
	$remove=mysql_query("delete from posts where user_id='$user' and post_id='$delete_post_id'");
	if(!$remove) die ("Remove error: " . mysql_error());
	header("Location:my_profile_page.php?id=$user");
}
?>
<?php
$remove_share_post=$_POST['delete_share_post'];
$delete_share_post_id=$_POST['delete_share_post_id'];
if(isset($remove_share_post)){
	$remove_share=mysql_query("delete from share_posts where share_id='$delete_share_post_id'");
	if(!$remove_share) die ("Remove error: " . mysql_error());
	header("Location:my_profile_page.php?id=$user");
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="profile_like.js"></script>
	<style type="text/css">
		.pp a{
		color: #fff;
		text-decoration: none;
		}
		.pp a:hover{
			text-decoration: underline;
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
		.share_post_icon{
			height:35px;
		  	width:35px;
		  	object-fit: cover;
		  	border-radius: 50%;
		  	margin-right: 10px;
		}
		#share_post_author_name{
			font-weight: bold;
			font-size: 14px;
		}
		#share_post_date{
			font-size: 12.5px;
		}
		#share_post-body{
			color: black;
			padding: 10px;
			font-size: 12.5px;
		}
	</style>
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
							<img src='data:image/jpeg;base64, <?=$show_img ?>' alt='' width='35px' height='35px' class='round-image' style='object-fit: cover;' class='round-image'>
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
									<img src='data:image/jpeg;base64, <?=$show_img ?>' alt='' width='35px' height='35px' class="account">
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
			<div class="profile">
			
			<div class="profile-image">
				<div>
					<?php
					if(!empty($show_img)){?>
							<img src='data:image/jpeg;base64, <?=$show_img ?>' id="account-icon">
					<?php }
					else{
						?><img src='account_1.png' id="account-icon">
						<?php
						}
					?>
					
					<a href="edit.php?id=<?=$user?>">
						<li id="edit">
							Edit
							<span></span><span></span><span></span><span></span>
						</li>
					</a>
				</div>
			</div>
			<div class="profile-info">
				<div class="profile-name">
					<?php echo $name; echo " "; echo $surname;?>
				</div>
				<div class="flex">
					<div class="word">
						<font id="space">Birthday: </font><br>
						<font id="space">Gender: </font><br>
						<font id="space">Country: </font><br>
						<font id="space">City: </font><br>
						<font id="space">Relationship: </font><br>
						<font id="space">Phone: </font>
					</div>
					<div class="info">
						<font id="space"><?php echo $bd;?></font><br>
						<font id="space"><?php echo $gender;?></font><br>
						<font id="space"><?php echo $country;?></font><br>
						<font id="space"><?php echo $city;?></font><br>
						<font id="space"><?php echo $relationship;?></font><br>
						<font id="space"><?php echo $phone;?></font>
					</div>
				</div>
				<hr>
				<?php if(!is_null($school) or !is_null($university) or !is_null($specialty) or !is_null($uni_status) or !is_null($uni_date_of_issue)){
							echo "<font>Education</font>";
				}?>
				<div class="flex">
					<div class="word">
						<?php if(!is_null($school)){
							echo "<font id='space'>School: </font><br>";
						}?>
						<?php if(!is_null($university)){
							echo "<font id='space'>University: </font><br>";
						}?>
						<?php if(!is_null($specialty)){
							echo "<font id='space'>Specialty: </font><br>";
						}?>
						<?php if(!is_null($uni_status)){
							echo "<font id='space'>Status: </font><br>";
						}?>
						<?php if(!is_null($uni_date_of_issue)){
							echo "<font id='space'>Date of issue: </font><br>";
						}?>
					</div>
					<div class="info">
						<?php if(!is_null($school)){
							echo "<font id='space'>$school, $begin_school-$end_school</font><br>";
						}?>
						<?php if(!is_null($university)){
							echo "<font id='space'>$university</font><br>";
						}?>
						<?php if(!is_null($specialty)){
							echo "<font id='space'>$specialty</font><br>";
						}?>
						<?php if(!is_null($uni_status)){
							echo "<font id='space'>$uni_status</font><br>";
						}?>
						<?php if(!is_null($uni_date_of_issue)){
							echo "<font id='space'>$uni_date_of_issue</font><br>";
						}?>
					</div>
				</div>
				<?php if(!is_null($school) or !is_null($university) or !is_null($specialty) or !is_null($uni_status) or !is_null($uni_date_of_issue)){
							echo "<hr>";
				}?>
				<?php if(!is_null($interests) or !is_null($music) or !is_null($films) or !is_null($books)
					or !is_null($games) or !is_null($about)){
							echo "<font id='space'>Personal Information</font>";
				}?>
				<div class="flex">
					<div class="word">
						<?php if(!is_null($interests)){
							echo "<font id='space'>Interests: </font><br>";
						}?>
						<?php if(!is_null($music)){
							echo "<font id='space'>Favorite music: </font><br>";
						}?>
						<?php if(!is_null($films)){
							echo "<font id='space'>Favorite films: </font><br>";
						}?>
						<?php if(!is_null($books)){
							echo "<font id='space'>Favorite books: </font><br>";
						}?>
						<?php if(!is_null($games)){
							echo "<font id='space'>Favorite games: </font><br>";
						}?>
						<?php if(!is_null($about)){
							echo "<font id='space'>About myself: </font><br>";
						}?>
					</div>
					<div class="info">
						<?php if(!is_null($interests)){
							echo "<font id='space'>$interests</font><br>";
						}?>
						<?php if(!is_null($music)){
							echo "<font id='space'>$music</font><br>";
						}?>
						<?php if(!is_null($films)){
							echo "<font id='space'>$films</font><br>";
						}?>
						<?php if(!is_null($books)){
							echo "<font id='space'>$books</font><br>";
						}?>
						<?php if(!is_null($games)){
							echo "<font id='space'>$games</font><br>";
						}?>
						<?php if(!is_null($about)){
							echo "<font id='space'>$about</font><br>";
						}?>
					</div>
				</div>
				<?php
					if(!is_null($interests) or !is_null($music) or !is_null($films) or !is_null($books) or !is_null($games) or !is_null($about)){
						echo "<hr>";
					}
				?>
				<?php if(!is_null($work)){
					echo "<font>Career</font>";
				}?>
				<div class="flex">
					<div class="word">
						<?php if(!is_null($interests)){
							echo "<font id='space'>Position: </font><br>";
						}?>
					</div>
					<div class="info">
						<?php if(!is_null($interests)){
							echo "<font id='space'>$work</font><br>";
						}?>
					</div>
				</div>
			</div>
			</div>
			<div class="p">
				POSTS
			</div>
			<div class="my-post">
				<!-- <div  class="comment-home-conatiner">
			       <?php
			        include('comment.php');
			       ?>
			 	</div> -->
				<?php
					$share_post=mysql_query("select * from share_posts where user_id='$user' order by share_date desc");
					$share_post_num=mysql_num_rows($share_post);
					$posts_array=array();
					if($share_post_num!=0){
						for($k=1; $k<=$share_post_num; ++$k){
						$share_row=mysql_fetch_assoc($share_post);
						$share_post_id=$share_row['post_id'];
						array_push($posts_array, $share_post_id);
						}
					}

					$my_post=mysql_query("select * from posts where user_id='$user' order by p_date desc");
					$my_post_num=mysql_num_rows($my_post);
					if($my_post_num!=0){
						for($i=1; $i<=$my_post_num; ++$i){
							$my_post_row=mysql_fetch_assoc($my_post);
							$my_post_id=$my_post_row['post_id'];
							array_push($posts_array, $my_post_id);
						}
					}
					$comma_separated=implode(",", $posts_array);
					$results=mysql_query("select * from posts where post_id in ($comma_separated) order by p_date desc");
					// if (!$results) die ("Select * error: " . mysql_error());
					// $results=mysql_query("select * from posts where user_id='".$user."' order by p_date desc");
					// if (!$results) die ("Select * error: " . mysql_error());
					if($results){$row_post=mysql_num_rows($results);}
					for ($i = 1 ; $i <=$row_post ; ++$i){	
						$each_row = mysql_fetch_row($results);
						$author_detail=mysql_query("select user_id, name, image from users where user_id=$each_row[5]");
						if (!$author_detail) die ("Select name error: " . mysql_error());
						$author_detail_fetch = mysql_fetch_assoc($author_detail);
						$author_name=$author_detail_fetch['name'];
						$author_img=base64_encode($author_detail_fetch['image']);
						$author_id=$author_detail_fetch['user_id'];
						if(!empty($author_img)){
							$str='data:image/jpeg;base64,$author_img';
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
						$share=mysql_query("select * from share_posts where post_id='$post_id' and user_id='$user'");
						$share_fetch=mysql_fetch_assoc($share);
						$share_post_date=$share_fetch['share_date'];
						$share_id=$share_fetch['share_id'];
						$userId=$user;
						if($author_id==$user){
							echo "<div class='my_post'>
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
									</div>
									<form method='post' action=''>
									<div class='delete'>
										<abbr title='Delete post'>
										<label>
											<i class='fa fa-close'>
												<input type='submit' name='delete_post' id='hidden-delete' value='.'>
											</i>
										</label>
										<input type='text' name='delete_post_id' value='$post_id' id='none'>
										</abbr>
									</div>
									</form>
								</div>
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
									".make_like($userId, $postId)." 
                                	".make_posts($postId)."
								</div>
							</div>";
						}
						else{
						echo "<div class='my_post'>
								<div class='author-info' style='display: flex;'>"?>
						<?php
							if(!empty($show_img)){?>
									<img src='data:image/jpeg;base64, <?=$show_img ?>' class='post_icon'>
							<?php }
							else{
								?><img src='account_1.png' class='post_icon'>
								<?php
								}
							echo "<div class='author'>
										<font id='post_author_name'>$name</font><br>
										<font id='post_date'>date: $share_post_date</font>
									</div>
									<form method='post' action=''>
									<div class='delete'>
										<abbr title='Delete post'>
										<label>
											<i class='fa fa-close'>
												<input type='submit' name='delete_share_post' id='hidden-delete' value='.'>
											</i>
										</label>
										<input type='text' name='delete_share_post_id' value='$share_id' id='none'>
										</abbr>
									</div>
									</form>
								</div>";
						?>
						<?php
							
							echo "<div class='content' style='border-left: 2px solid rgba(70,62,122,0.5); padding:10px;'>
							<div class='author-info' style='display: flex;'>";
								if(!empty($author_img)){?>
									<img src='data:image/jpeg;base64, <?=$author_img ?>' class='share_post_icon'>
								<?php }
								else{
									?><img src='account_1.png' class='share_post_icon'>
									<?php
									}
									
								echo "<div class='author'>
										<font id='share_post_author_name'>$author_name</font><br>
										<font id='share_post_date'>date: $post_data</font>
									</div>
								</div>
								<div id='share_post-body'>$post_body</div>";
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
								<div class='interactive'>";
							echo "".make_share_like($user, $share_id)." 
                                	".make_share_posts($share_id)."";
								echo	"</div>

							</div>";
						}
					}
	function make_like($userId, $postId){
		$result = mysql_query("select * from post_like where user_id= '$userId' and post_id='$postId'");
		if($row = mysql_num_rows($result)>0){
			$output = '<a class="like_button" data-action="unlike" data-user_id="'.$userId.'" data-post_id="'.$postId.'"><i class="fa fa-heart" style="color:red; margin-right:0px;"></i></a>';
		}
		else{
			$output = '<a class="like_button" data-action="like" data-user_id="'.$userId.'" data-post_id="'.$postId.'"><i class="fa fa-heart-o" style="color:red; margin-right:0px;"></i></a>';
		}
		return $output;
	 }
	 
	 if($_POST['action_like']=='like'){
		 $userId = $_POST['user_id'];
		 $postId = $_POST['post_id'];
		 $query = "insert into post_like(user_id, post_id) values ('$userId','$postId')";
		$query_result = mysql_query($query);
	 }
	 
	 if($_POST['action_like']=='unlike'){
	     $userId = $_POST['user_id'];
		 $postId = $_POST['post_id'];
		 $query = "delete from post_like where user_id='$userId' and post_id='$postId'";
		$query_result = mysql_query($query);
	 }
	 function make_posts($postId){
		$result = mysql_query("select count(*) as sum from post_like where post_id='$postId'");
	    $row = mysql_fetch_assoc($result);
		$row_result = $row['sum'];
		if($row_result==null){
			$output = '<b>0</b>';
		}else{
			$output = '<b>'.$row_result.'</b>';
		}
		 return $output ;  
	  }
	  function make_share_like($userId, $shareId){
		$sql = "select * from share_like where user_id= '$userId' and share_id='$shareId'";
		$result = mysql_query($sql);
		if($row = mysql_num_rows($result)>0){
			$output = '<a class="share_like_button" data-action="unlike" data-user_id="'.$userId.'" data-share_id="'.$shareId.'"><i class="fa fa-heart" style="color:red; margin-right:0px;"></i></a>';
		}
		else{
			
			$output = '<a class="share_like_button" data-action="like" data-user_id="'.$userId.'" data-share_id="'.$shareId.'"><i class="fa fa-heart-o" style="color:red; margin-right:0px;"></i></a>';
		}
		return $output;
	 }
	 if($_POST['action_like']=='like'){
		 $userId = $_POST['user_id'];
		 $shareId = $_POST['share_id'];
		 $query = "insert into share_like(user_id, share_id) values ('$userId','$shareId')";
		$query_result = mysql_query($query);
	 }
	 
	 if($_POST['action_like']=='unlike'){
	     $userId = $_POST['user_id'];
		 $shareId = $_POST['share_id'];
		 $query = "delete from share_like where user_id='$userId' and share_id='$shareId'";
		$query_result = mysql_query($query);
	 }
	 function make_share_posts($shareId){
		$sql = "select count(*) as sum from share_like where share_id='$shareId'";
		$result = mysql_query($sql);
	    $row = mysql_fetch_assoc($result);
		$row_result = $row['sum'];
		if($row_result==null){
			$output = '<b>0</b>';
		}else{
			$output = '<b>'.$row_result.'</b>';
		}
		 return $output ;
	  }
				?>
			</div>
		</div>
		<div class="third">
			<div class="pp">
				<a href="my_friends_page.php?id=<?php echo $user;?>">Friends</a>
			</div>
			<div class="friends">
				<!-- <center><h4>Friends</h4></center> -->
				<?php
					$have_friend=mysql_query("select * from friends where user_id='$user' and friend=1 order by rand() limit 6");
					if (!$have_friend) die ("Select * error: " . mysql_error());
					$rs=mysql_num_rows($have_friend);
					echo "<div class='grid'>";
					for ($j =0; $j <$rs ; ++$j){	
						$r = mysql_fetch_row($have_friend);
						$user_n=mysql_query("select user_id, name, image, login from users where user_id=$r[1]");
						if (!$user_n) die ("Select name error: " . mysql_error());
						$table_user_name = mysql_fetch_assoc($user_n);
						$name_user=$table_user_name['name'];
						$image_user=base64_encode($table_user_name['image']);
						$login_user=$table_user_name['login'];
						// if(!empty($image_user)){
						// 	$string='data:image/jpeg;base64,$image_user';
						// 	}
						// else{
						// 	$string='account_1.png';
						// }
						$id_user=$table_user_name['user_id'];

						echo "<div class='user'>
								<center><a href='http://socnet/profile_page.php?id=$id_user&login=$login_user'>";
						if(!empty($image_user)){?>
								<img src='data:image/jpeg;base64, <?=$image_user ?>' class='round-image' width='60px' height='60px' style='object-fit: cover;'>
						<?php }
						else{
							?><img src='account_1.png' class='round-image' width='60px'>
							<?php
							}
						echo	"</a></center>
								<center><font>$name_user</font></center>
							</div>";
					}
					echo "</div>";
					
				?>
			</div>
			<br>
			<div class="pp">
				<a href="my_photos_page.php?id=<?php echo $user;?>">Photos</a>
			</div>
			<div class="photos">
				<div class="slideshow-container">
				<?php
					$user_photos=mysql_query("select photo_name from photos where user_id='$user' order by photo_date desc limit 5");
					if (!$user_photos) die ("Select * error: " . mysql_error());
					$rs=mysql_num_rows($user_photos);
					if($rs!=0){
						for ($j =1; $j <=$rs ; ++$j){	
							$r = mysql_fetch_row($user_photos);
							$image_user=base64_encode($r[0]);
							echo "<div class='mySlides fade'>
									  <div class='numbertext'>$j / $rs</div>
									  <img src='data:image/jpeg;base64,$image_user' style='width:100%'>
									  <div class='text'></div>
									</div>";
						}
						echo "<div style='text-align:center'>";
						for($j=1; $j<=$rs; ++$j){
							echo "<span class='dot' onclick='currentSlide($j)'></span>";
						}
						echo "</div>";
						echo "<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>
							<a class='next' onclick='plusSlides(1)'>&#10095;</a>";
					}
					else{
						echo "<center>No photos yet:(</center>";
					}
					?>	
				</div>
			</div>
		</div>
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>
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