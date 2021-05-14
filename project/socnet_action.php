<?php session_start();
    error_reporting(0);
	
    include('connect.php'); 
	

	  // comments and caption
	  
	   if($_POST['action']=='comment'){
		
		 $userId = $_SESSION['user_id'];
		
		 $postId = $_POST['post_id'];
		 
		 $postComment = $_POST['post_comment'];
		
		 
		 $query = "INSERT INTO `post_comment`(`user_id`, `post_id`, `post_comments`,`post_date`) VALUES ('$userId','$postId','$postComment','".date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))."')";
		
		 $query_result = mysqli_query($conn, $query);
		 
		 if($query_result){
			 
		  
		 }
	 }	
	
       if(isset($_POST['action_comment'])){
		
		$userId = $_POST['user_id'];
		
		$postId = $_POST['post_id'];
		 
		//join two table user and post_comment 
		
		$sql = "SELECT * FROM `post_comment` INNER JOIN  `users` ON post_comment.user_id = users.user_id 
		
		WHERE post_comment.post_id = '$postId' ORDER BY `id` ASC";
		
		$result = mysqli_query($conn, $sql);
			
	    while($row = mysqli_fetch_assoc($result)){
		
		     
		  $postComment = $row['post_comments'];
		  
		  $username = $row['name'];
		  
		  $userImage =base64_encode($row['image']);
		  
		  $postDate = $row['post_date'];
		  

		  if($userImage==null){
			  
			  $user_image = "<img src='account_1.png'/>";
			  
		  }else{
			  
			    $user_image = "<img src='data:image/jpeg;base64,$userImage' style='object-fit: cover;'/>";
			
		  }
		  
		 
		  
		  echo"<div class='comment-comment-inner-container image'>
	
	              $user_image
	
	           </div>
		 
		  
		      <div class='comment-comment-inner-container name' >
			     
                <div class='comment-name-container'>
							 
				 
			    <p class='comment-name'><b>$username:</b> $postComment</p>
					   
				</div>	  

			  <div class='comment-time-container'>
					 
					    
		       <p class='comment-date'>".make_comment_time($postDate)."</p> 
					   
					   
					 
			  </div>
					  
			 
			  
			  </div>
				
			   ";
		  
		}
		
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
		  if($seconds==0){
		  	return "Just now";
		  }
		  if($seconds <=60 ){
			  return "$seconds s ago";
		  }
		   else if($minutes <= 60){
			   
			   if($minutes==1){
				   
				   return "1m";
				   
			   }else{
				   
				   return "$minutes m"; 
			   }
		   }
		  
		  else if($hours <= 24){
			   
			   if($hours==1){
				   
				   return "1h";
				   
			   }else{
				   
				   return "$hours h"; 
			   }
		   }
		   else if($days <= 7){
			   
			   if($days==1){
				   
				   return "1d";
				   
			   }else{
				   
				   return "$days d"; 
			   }
		   }
		    else if($weeks <= 4.3){
			   
			   if($weeks==1){
				   
				   return "1w";
				   
			   }else{
				   
				   return "$weeks w"; 
			   }
		   }
		    else if($months <= 12){
			   
			   if($months==1){
				   
				   return "1m";
				   
			   }else{
				   
				   return "$months m"; 
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
	  
	 if(isset($_POST['action_caption'])){
		
		$postId = $_POST['post_id'];
		 
		//join two table user and user_post 
		
		$sql = "SELECT * FROM `posts` INNER JOIN  `users` ON posts.user_id = users.user_id 
		
		WHERE posts.post_id = '$postId' ";
		
		$result = mysqli_query($conn, $sql);
			
	    while($row = mysqli_fetch_assoc($result)){
		
		     
		  $post_body = $row['p_body'];
		  
		  $author_name = $row['name'];
		  
		  $author_img = base64_encode($row['image']);
		  
		  $post_data = $row['date'];
		  
		  $post_img =  base64_encode($row['p_image']);
		  
		  $post_video_name = $row['p_video_name'];
		  
		  
		  echo "<div class='post' style='margin-top:0px;'>
								<div class='author-info' style='display: flex;'>";
		if(!empty($author_img)){
							echo "<img src='data:image/jpeg;base64,$author_img' class='post_icon' style='object-fit: cover;'>";
							}
						else{
							echo "<img src='account_1.png' class='post_icon'>";
						}

									
							echo     "<div>
										<font id='post_author_name'>$author_name</font><br>
										<font id='post_date'>date: $post_data</font>
									</div>
								</div>
								<div class='content'>
								<div id='post-body'>$post_body</div>";
		if(!empty($post_img)){
							echo "<div class='post_image'>
										<center><img src='data:image/jpeg;base64,$post_img' class='post-picture' style='max-height:450px; max-width: 450px;'></center>
									</div>";
						}
						if(!empty($post_video_name)){

							echo "<div class='post_video' style='max-height:450px; max-width: 450px;'>
									<video class='post_video' controls>
										<source src='videos/$post_video_name' type='video/mp4'>
									</video>
								</div>";
						}
		  
		  
		}
	}  
	   
	 function make_caption_date($conn, $postId){
		  
	    $sql = "SELECT * FROM `posts` WHERE `post_id` = '$postId'";
		
		$result = mysqli_query($conn, $sql);
			
	    while($row = mysqli_fetch_assoc($result)){
		
		$date = $row['p_date'];
		
		
		$output = '<p style="font-size:14px; margin-top:3px; color:#aaa; text-align:left;">'.make_caption_time($date).'</p>';
			
		}
		
		 return $output ;
		  
	  }
	  
	  
	   function make_caption_time($time_ago){
		  
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
			  
			  return "$seconds s ago";
		  }
		   else if($minutes <= 60){
			   
			   if($minutes==1){
				   
				   return "1m";
				   
			   }else{
				   
				   return "$minutes m"; 
			   }
		   }
		  
		  else if($hours <= 24){
			   
			   if($hours==1){
				   
				   return "1h";
				   
			   }else{
				   
				   return "$hours h"; 
			   }
		   }
		   else if($days <= 7){
			   
			   if($days==1){
				   
				   return "1d";
				   
			   }else{
				   
				   return "$days d"; 
			   }
		   }
		    else if($weeks <= 4.3){
			   
			   if($weeks==1){
				   
				   return "1w";
				   
			   }else{
				   
				   return "$weeks w"; 
			   }
		   }
		    else if($months <= 12){
			   
			   if($months==1){
				   
				   return "1m";
				   
			   }else{
				   
				   return "$months m"; 
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
    
	 function make_posts($conn, $postId){
		  
		 $sql = "SELECT count(*) As sum FROM `post_like` WHERE `post_id` = '$postId'";
		
		$result = mysqli_query($conn, $sql);
			
	    $row = mysqli_fetch_assoc($result);
		
		$row_result = $row['sum'];
		
		if($row_result==null){
			
			$output = '<p><b>0 Likes</b></p>';
					
			
		}else{
			
			$output = '<p><b>'.$row_result.' Likes</b></p>';
			
		}
		
		 return $output ;
		  
	  }
	
	 
 ?>