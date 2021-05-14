<?php
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_GET['photo_id']) && !isset($_GET['profile_id'])){
		die();
		exit();
	}
	else{
		$user=$_SESSION['user_id'];
		$photo_id=$_GET['photo_id'];
  		$profile_id=$_GET['profile_id'];
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
	$profile_query = mysql_query("select * from users where user_id='$profile_id'");
  	if (!$profile_query) die("Unable to connect to MySQL: " . mysql_error());
  	$row = mysql_fetch_assoc($profile_query);
  	$profile_name=$row['name'];
  	$profile_surname=$row['surname'];
  	$profile_show_img = base64_encode($row['image']);

  	$select_photo= mysql_query("select * from photos where photo_id='$photo_id'");
  	$row_photo = mysql_fetch_assoc($select_photo);
  	$image=base64_encode($row_photo['photo_name']);
  	$photo_like=$row_photo['like'];
  	$photo_date=$row_photo['photo_date'];
  	$photo_description=$row_photo['photo_description'];
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
	$upload_image_button=$_POST['upload_image_button'];
	if(isset($upload_image_button)){
		$img_type = substr($_FILES['user_photo']['type'], 0, 5);
		$img_size = 2*1024*1024;
		if(!empty($_FILES['user_photo']['tmp_name']) and $img_type=='image' and $_FILES['user_photo']['size'] <= $img_size){ 
		$img = addslashes(file_get_contents($_FILES['user_photo']['tmp_name']));
		}
		$date=date("Y-m-d h:i:sa");
		$up=mysql_query("insert into photos (photo_name, photo_date, user_id)  values ('".$img."','".$date."','".$user."')");
		if(!$up) die ("Insert error: " . mysql_error());
		header("Location:my_photos_page.php?id=$user");
	}
?>
<?php
if($_POST['action_like']=='1'){
	$check_like=mysql_query("select * from photo_like where user_id='$user' and photo_id='$photo_id'");
	$check_num=mysql_num_rows($check_like);
	if($check_num==0){
 	$query_result = mysql_query("insert into photo_like(user_id, photo_id) values ('$user','$photo_id')");
 	}
 	
}
if($_POST['action_unlike']=='0'){
	$query_result = mysql_query("delete from photo_like where user_id='$user' and photo_id='$photo_id'");
 }
?>
<?php
 if(isset($_POST['new_comment_send'])){
	$photoComment = $_POST['new_comment'];
	$insert_comment = mysql_query("insert into photo_comment (user_id, photo_id, photo_comment, comment_date) values ('$user', '$photo_id', '$photoComment', '".date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))."')");
	header("Location:profile_photos_page_detail.php?photo_id=$photo_id&profile_id=$profile_id");
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
	<link rel="stylesheet" type="text/css" href="photo_detail_page.css">
	<style type="text/css">
		.each-photo-comment{
			margin-bottom: 10px; 
			display: flex;
		}
		#comment-author-icon{
			border-radius: 50%;
		  	width: 33px; 
		  	height: 33px;
		  	object-fit: cover;
		}
		.comment-name-surname{
			font-size: 13px;
		  	font-weight: bold;
		  	color: #463E7A;
		  	font-family: 'Verdana', sans-serif;
		}
		.comment-date{
			font-size: 12px;
			font-weight: normal;
		  	font-family: 'Verdana', sans-serif;
		  	color: gray;
		}
		.comment{
			width: 420px;
			min-height: 15.2px;
			font-size: 13px;
		  	font-weight: normal;
		  	color: #000;
		  	font-family: 'Verdana', sans-serif;
		}
		.new-comment{
	  display: flex;
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
							<img src='data:image/jpeg;base64, <?=$show_img ?>' alt='' width='35px' height='35px' style='object-fit: cover;' class='round-image'>
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
		<div class="photo">
			Photos<?php echo " "; echo $profile_name; echo " "; echo $profile_surname; ?> 
			<br>
			<br>
			<div class="display-photos">
				<?php
					$user_photos=mysql_query("select photo_name, photo_id from photos where user_id='$profile_id'");
					if (!$user_photos) die ("Select * error: " . mysql_error());
					$rs=mysql_num_rows($user_photos);
					for ($j =0; $j <$rs ; ++$j){	
						$r = mysql_fetch_row($user_photos);
						$image_user=base64_encode($r[0]);
						$image_id=$r[1];
						echo "
						<div class='each-photo'>
							<a href='profile_photos_page_detail.php?photo_id=$image_id&profile_id=$profile_id'><img src='data:image/jpeg;base64,$image_user' id='myImg '></a>
						</div>";
					}
				?>
			</div>
			<div id="myModal" class="modal">
			  <span class="close" onclick="modal.style.display='none'">&times;</span>
			    <img class="modal-content" id="img01" src="data:image/jpeg;base64, <?php echo $image;?>">
			    <div class='interactive'>
			        <div id="caption">
			          <div class="author-info">
			            <img src="data:image/jpeg;base64, <?php echo $profile_show_img;?>" id='author-icon'>
			            <div class="margin">
			              <div class="name-surname">
			              <?php echo $profile_name; echo " "; echo $profile_surname;?>
			              </div>
			              <div class="date">
			              <?php echo $photo_date;?>
			              </div>
			            </div>
			            <div class="like">
			              <font style="display: flex;">
				              		<?php
				              			echo "".make_posts()."".make_like()."";
                                		function make_like(){
                                		$user=$_SESSION['user_id'];
										$photo_id=$_GET['photo_id'];
		 								$sql = "select * from photo_like where user_id= '$user' and photo_id='$photo_id'";
										$result = mysql_query($sql);
										$num=mysql_num_rows($result);
										if(mysql_num_rows($result)>0){
										$output = '<abbr title="Unlike"><label><form method="post"><i class="fa fa-heart" style="color:red; cursor:pointer;"><input type="submit" name="action_unlike" value="0" id="hidden-unmark"></form></i></label></abbr>';
										}
										else{
										$output = '<abbr title="Like"><label><form method="post"><i class="fa fa-heart-o" style="color:red; cursor:pointer;"><input type="submit" name="action_like" value="1" id="hidden-unmark"></form></i></label></abbr>';
										}
										return $output;
				 						}
									 
									 
									 
									 function make_posts(){
									 	$user=$_SESSION['user_id'];
										$photo_id=$_GET['photo_id'];
										$sql = "select count(*) as sum from photo_like where photo_id='$photo_id'";
										$result = mysql_query($sql);
									    $row = mysql_fetch_assoc($result);
										$row_result = $row['sum'];
										if($row_result==null){
											$output =0;
										}else{
											$output =$row_result;
										}
										 return $output ;
									  }
				              		?>
				              		<!-- <?=$photo_like?><i class="fa fa-heart-o"></i><br> -->

				              	</font>
			            </div>
			          </div>
			          <div class="photo-info">
			            <div class="marked-person">
				        		<?php
				        		$tag_friends=mysql_query("select person_id from tags where user_id='$profile_id' and photo_id='$photo_id'");
								if (!$tag_friends) die ("Select * error: " . mysql_error());
								$tag_friends_num=mysql_num_rows($tag_friends);
								$array=array();
								for($k=1; $k<=$tag_friends_num; ++$k){
									$friend_row=mysql_fetch_row($tag_friends);
									$friend_id=$friend_row[0];
									array_push($array, $friend_id);
								}
								$comma_separated=implode(",", $array);
				        			$select_tag=mysql_query("select * from users where user_id in ($comma_separated)");
				        			if($select_tag){
				        				$select_tag_num=mysql_num_rows($select_tag);
				        			}
				        			if($select_tag_num!=0){
				        				echo "<div class='inline-flex'><font>In this photo:  </font>";
				        			for($a=1; $a<=$select_tag_num; ++$a){
				        				$tag_table = mysql_fetch_assoc($select_tag);
										$name_u=$tag_table['name'];
										$surname_u=$tag_table['surname'];
										$id_u=$tag_table['user_id'];
										echo "<div class='flexx'>";
										if($id_u==$user){
											echo "<a href='http://socnet/my_profile_page.php?id=$id_u'>";
										}
										else{
											echo "<a href='http://socnet/profile_page.php?id=$id_u'>";
										}
										
										echo "$name_u $surname_u</a>
											</div>
											";
				        			}
				        			echo "</div>";
				        			}
				        		?>
				        		
				        	</div>
				            <div class="author-comment">
				            	<?=$photo_description?>
				           	</div>
				        
			        
			        <hr id="hr1">
			            
			          </div>
			          <div class="comments">
			          	<?php
							$select_comments = mysql_query("select * FROM photo_comment inner join users on photo_comment.user_id = users.user_id where photo_comment.photo_id = '$photo_id' order by id ASC");
	  						while($row = mysql_fetch_assoc($select_comments)){
		  					$photo_comment = $row['photo_comment'];
		  					$comment_author_name = $row['name'];
		  					$comment_author_surname = $row['surname'];
		  					$userImage =base64_encode($row['image']);
		  					$commentDate = $row['comment_date'];
					  		if($userImage==null){
					  			$comment_author_image = "<img src='account_1.png' id='comment-author-icon'/>";
					  		}else{
						    	$comment_author_image = "<img src='data:image/jpeg;base64,$userImage' id='comment-author-icon'/>";
						    }
						    echo "<div class='each-photo-comment'>
						          	<div>
						          		$comment_author_image
						          	</div>
						          	<div class='margin'>
							              	<div class='comment-name-surname'>
							              		$comment_author_name $comment_author_surname
							              	</div>
							              	<div class='comment'>
							              		$photo_comment
							              	</div>
							              	<div class='comment-date'>
							              		".make_comment_time($commentDate)."
							              	</div>
							              	
							        </div>
						          </div>";
							}
						function make_comment_time($time_ago){
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
						  if($seconds ==0 ){
							  return "Just now";
						  }
						  if($seconds <=60 ){
							  return "$seconds seconds ago";
						  }
						   else if($minutes <= 60){
							   if($minutes==1){
								   return "1 minute ago";
							   }else{
								   return "$minutes minutes ago"; 
							   }
						   }
						  else if($hours <= 24){
							   if($hours==1){
								   return "1 hour ago";
							   }else{
								   return "$hours hours ago"; 
							   }
						   }
						   else if($days <= 7){
							   if($days==1){
								   return "1 day ago"; 
							   }else{
								   return "$days days ago"; 
							   }
						   }
						    else if($weeks <= 4.3){
							   if($weeks==1){
								   return "1 week ago";
							   }else{
								   return "$weeks weeks ago"; 
							   }
						   }
						    else if($months <= 12){
							   if($months==1){
								   return "1 month ago";
							   }else{
								   return "$months m ago"; 
							   }
						   }
						    else {
							   
							   if($years==1){
								   return "1y";
								   
							   }else{
								   return "$years y"; 
							   }
						   }
					  }
			          	?>
			          </div>
			          <div class="new-comment">
			            <div>
			            	<?php
								if(!empty($show_img)){?>
										<img src='data:image/jpeg;base64, <?=$show_img ?>' id='author-icon'>
								<?php }
								else{
									?><img src='account_1.png' id='author-icon'>
									<?php
									}
							?>
			            </div>
			            <div class="comment-input">
			              <form method="post">
			              	<input type="text" name="new_comment" placeholder="Write a comment" id="new-comment" autocomplete="off">
			            </div>
			            <div class="comment-send">
			              	<input type="submit" name="new_comment_send" value="send" id="send">
			            </div>
			            </form>
			            </div>
			        </div> 
			    </div>
			</div>
			<script type="text/javascript">
			  var modal = document.getElementById("myModal");
			  window.onclick=function(event){
			  if (event.target==modal) {
			    modal.style.display='none';
			  }
			}
			</script>
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