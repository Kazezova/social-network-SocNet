<?php
	session_start();
	error_reporting(0);
  	$connect = mysql_connect("127.0.0.1", "root", "");
	if (!$connect) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db("socnet_data_base")
					or die("Unable to select database: " . mysql_error());
	$userId = $_SESSION['user_id'];
	
	$receiver_id=$_SESSION['receiver_id'];
	
	$logout=$_POST['logout'];
	if($logout){
		unset($_SESSION["id"]);
		unset($_SESSION["name"]);
		header("Location:index.php");
	}
  
  //fetch users
  
  if(isset($_POST['action_users'])){
  		$have_dialog=mysql_query("select receiver_id from dialog where user_id='$userId'");
					if (!$have_dialog) die ("Select * error: " . mysql_error());
		$rs=mysql_num_rows($have_dialog);
	  	for ($j =0; $j <$rs ; ++$j){	
			$r = mysql_fetch_row($have_dialog);
			$query_result=mysql_query("select user_id, name, image from users where user_id=$r[0]");
	    // $query_result = mysql_query("select user_id, name, image from users where user_id != '$userId'");
	
		$row = mysql_fetch_assoc($query_result);
			
			$userImage = base64_encode($row['image']);
			
			$userName = $row['name'];
			$receiver_id=$_GET['receiver_id'];
			$userId = $row['user_id'];
			if($userImage == null){
				
				$user_image = "<img src='icon/account_1.png'/>";
				
			}
			else{
				
				$user_image = "<img src='data:image/jpeg;base64,$userImage' style='object-fit: cover;'>";
			}
			$receiver_id=$_SESSION['receiver_id'];
			echo " <div class='user-main-details' data-user_id='".$userId."'>
			
			<div class='user-main-container-inside'>
		  
		                 <div class='user-main-inside photo'>
		  
		                     <div class='user-main-image'>
		  
		                        $user_image
		 
		                     </div>
		 
		                 </div>
						 
						 <div class='user-main-inside text'>
		  
		                        <div class='user-main-name'>
		  
		                          <p>$userName</p>
								  
		                        </div>
								
								<div class='user-main-message'>
								
								 ".make_user_last_seen_message($userId)."
		                       
		                        </div>
							  
		                 </div>
		            
					  </div>
					  
					  </div>
					  
					  </div>
					  " ;
		
			}
  }
  
  function make_user_last_seen_message($userId){
	  
	   $senderId = $_SESSION['user_id'];
	  
	   $receiverId = $userId;

	   $result = mysql_query("select * from user_chat where (sender_id = '$senderId' and receiver_id ='$receiverId') or (sender_id = '$receiverId' and receiver_id = '$senderId') order by user_id desc limit 1");
	   
	   $query_result3 = mysql_query("select message, date, chat_status from users where user_id != '$userId'");
	   
	   // $row3 = mysql_fetch_assoc($result3);
	   
	   // $userName = $row3['name'];	
	   
	   while($row = mysql_fetch_assoc($result)){
		   
		   $userMessage = $row['message'];
		   
		   $date = $row['date'];
		   
		   $lastSeen = $row['chat_status'];
		   
		   $time = date('D d', STRTOTIME($date));
		   
		   if($lastSeen == 0){
		   
		   $output = '
									
									<div class="user-last-message dates">
		                            
									 <p>'.$time.'</p>
		                       
		                            </div>';
		   }else{
			   
			    $output = '
									
									<div class="user-last-message date">
		                            
									 <p>'.$time.'  </p>
									 
		                       
		                            </div>';
		
		   }
	   }
	   
	   return $output;
  }
  
  if(isset($_POST['action_users_nav'])){
	  
	   $userId = $_POST['user_id'];
	  
	    $query_result = mysql_query("select name, date, image from users where user_id = '$userId'");
	
		while($row = mysql_fetch_assoc($query_result)){
			
			$userImage = base64_encode($row['image']);
			
			$userName = $row['name'];
			
			$date = $row['date'];
			
			
			if($userImage == null){
				
				$user_image = "<img src='icon/account_1.png'/>";
				
			}else{
				
				$user_image = "<img src='data:image/jpeg;base64,$userImage' style='object-fit: cover;'>";
			}
			
		echo " <div class='main-navbar-inside photo'>
            
			           <div class='navbar-image'>
            
			            $user_image
   
                       </div>
   
                  </div> 
				  <center>
				  <div class='main-navbar-inside name'>
            
			             <div class='navbar-name'>
            
			              <p><b>$userName</b></p>
   
                         </div> 
						 
						 <div class='navbar-time'>
            
			              ".make_status($date)."
   
                         </div> 
   
                  </div> </center>
				  
				  ";	
			
		}
		
  }
  

  
  if(isset($_POST['action_users_profile'])){
	  
	   $userId = $_POST['user_id'];
	  
	   $query_result = mysql_query("select name, image, date from users where user_id = '$userId'");
	
		while($row = mysql_fetch_assoc($query_result)){
			
			$userImage = $row['image'];
			
			$userName = $row['name'];
			
			$date = $row['date'];
			
			if($userImage == null){
				
				$user_image = "<img src='icon/account_1.png'/>";
				
			}else{
				
				$user_image = "<img src='$userImage' style='object-fit: cover;'/>";
			}
			
		echo " <div class='user-profile-image'>
					           
			       $user_image
							   
				 </div>
							 
			    <div class='user-profile-name'>
					  
				 <p><b>$userName</b></p>
								 
				 </div>
							 
				 <div class='user-profile-time'>
					  
				    ".make_status($date)."
								
				 </div>";
		
		}
  }
  
  function make_status($status){
	  
	  date_default_timezone_set('Asia/Oral');
	  
	  $current_timeStamp = STRTOTIME(date("Y-m-d H:i:s"). '-10 second');
	  
	  $current_time = date("Y-m-d H:i:s", $current_timeStamp);
	  
	       if($status > $current_time){
				
				$output = '<p>online</p>';
				
			}else{
				
				$output = '<p>'.make_status_time($status).'</p>';
			}
			
		
		return $output;
	  
  }
 
  
  function make_status_time($time_ago){
	  
	  $time_ago = STRTOTIME($time_ago);
	  
	  $current_time = time();
	  
	  $time_diff = $current_time - $time_ago;
	  
	  $seconds = $time_diff;
	  
	  $mins = round($time_diff/60);
	  
	  $hours = round($time_diff/3600);
	  
	  $days = round($time_diff/86400);
	  
	  $weeks = round($time_diff/604800);
	  
	  $months = round($time_diff/2600640);
	  
	  $years = round($time_diff/31207680);
	  
	  if($seconds <= 60){
		  if($seconds == 1){
			  
			 return "1s ago";
			 
		  }else{
			  
			  return "$seconds s ago";
		  }
		
	  }
	  else if($mins <= 60){
		  
		  if($mins == 1){
			  
			 return "1m ago";
			 
		  }else{
			  
			  return "$mins m ago";
		  }
	  }
	  else if($hours <= 24){
		  
		  if($hours == 1){
			  
			 return "1h ago";
			 
		  }else{
			  
			  return "$hours h ago";
		  }
	  }
	  else if($days <= 7){
		  
		  if($days == 1){
			  
			 return "1d ago";
			 
		  }else{
			  
			  return "$days d ago";
		  }
	  }
	  else if($weeks <= 4.3){
		  
		  if($weeks == 1){
			  
			 return "1w ago";
			 
		  }else{
			  
			  return "$weeks w ago";
		  }
	  } 
	  else if($months <= 12){
		  
		  if($months == 1){
			  
			 return "1months ago";
			 
		  }else{
			  
			  return "$months m ago";
		  }
	  }
	  else {
		  
		  if($years == 1){
			  
			 return "1years ago";
			 
		  }else{
			  
			  return "$years y ago";
		  }
	  }
  }
  
  if(isset($_POST['action_send_message'])){
	  
	   $senderId = $_SESSION['user_id'];
	  
	   $receiverId = $_POST['user_id'];
	
	   $senderMessage = $_POST['send_message'];
	   
	   $result = mysql_query("insert into user_chat (sender_id, receiver_id, message,chat_status,type) values ('$senderId','$receiverId','$senderMessage','1','text')");
	   
	   if($result){
		   
		  
	   }
	
	
  }
  
  if(!isset($receiver_id)){}
   if(isset($_POST['action_fetch_message'])){
	  
	   $senderId = $_SESSION['user_id'];
	  
	   $receiverId = $_POST['user_id'];
	 
	   $result = mysql_query("select * from user_chat where (sender_id = '$senderId' and receiver_id = '$receiverId') or (sender_id = '$receiverId' and receiver_id = '$senderId')");
	   
	   while($row = mysql_fetch_assoc($result)){
		   
		   $userMessage = $row['message'];
		   
		   $sendId = $row['sender_id'];
		   
		   $userImage = $row['user_image'];
		   
           $chatStatus = $row['chat_status'];
		   
		   $type = $row['type'];
		   
		   $imageMessages = $row['image_message'];
		   
		   $videoMessages = $row['video_message'];
		   
		   $fileMessages = $row['file_message'];
		   
		   $musicMessages = $row['music_message'];
		   
		    if($type == 'text'){
			   
			   //chat text
			   
			    if($chatStatus == 1){
		   		   
		   if($senderId == $sendId){
		   
		   echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-image'>
						  
						          <img src='icon/ticktick.png' />
								  
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-display-name'>
						        
								    <p>$userMessage</p>
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-image'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					   <div class='chat-left-display-name'>
						        
						  <p>$userMessage </p>
						     
						    </div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
				 </script>"; 
			   
		   }
		   
		  }else{
			  
			 if($senderId == $sendId){
		   
		   echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-image'>
						  
						         <img src='icon/double-tick.png' />
								 
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-display-name'>
						        
								    <p>$userMessage</p>
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-image'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					   <div class='chat-left-display-name'>
						        
						  <p>$userMessage </p>
						     
						    </div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
				 </script>"; 
			   
		   } 
			  
		  }
		   	
			   
		   }elseif($type == 'image'){
			   
			   //chat image
			   
			if($chatStatus == 1){
		   		   
				if($senderId == $sendId){
		   
					echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-images'>
						  
						          <img src='icon/ticktick.png' />
								  
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-image'>
						        
								    <img src='$imageMessages' />
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_image').value = '';
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-images'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-image'>
						        
						  <img src='$imageMessages' />
						     
						</div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_image').value = '';
				 </script>"; 
			   
		   }
		   
		  }else{
			  
			 if($senderId == $sendId){
		   
		   echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-images'>
						  
						                  <img src='icon/double-tick.png' />
								 
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-image'>
						        
								   <img src='$imageMessages' />
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_image').value = '';
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-images'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-image'>
						        
						  <img src='$imageMessages' />
						     
						 </div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_image').value = '';
				 </script>"; 
			   
		   } 
			  
		  }
		   	
			   
		   }
		   
		   
		   elseif($type == 'video'){
			   
			   //chat video
			   
			if($chatStatus == 1){
		   		   
				if($senderId == $sendId){
		   
					echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-video'>
						  
						          <img src='icon/ticktick.png' />
								  
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-video'>
								   
								   <video controls>
									  <source src='$videoMessages' type='video/mp4'>
									</video>				
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_video').value = '';
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-video'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-video'>
						        
						  <video controls>
							 <source src='$videoMessages' type='video/mp4'>
						</video>	
						     
						</div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_video').value = '';
				 </script>"; 
			   
		   }
		   
		  }else{
			  
			 if($senderId == $sendId){
		   
		   echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-video'>
						  
						                  <img src='icon/double-tick.png' />
								 
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-video'>
						        
								  <video controls>
									  <source src='$videoMessages' type='video/mp4'>
									</video>	
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_video').value = '';
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-video'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-video'>
						        
						 <video controls>
							<source src='$videoMessages' type='video/mp4'>
						</video>	
						     
						 </div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_video').value = '';
				 </script>"; 
			   
		   } 
			  
		  }
		   	
			   
		   }
		   
		    elseif($type == 'file'){
			   
			   //chat file
			   
			if($chatStatus == 1){
		   		   
				if($senderId == $sendId){
		   
					echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-file'>
						  
						          <img src='icon/ticktick.png' />
								  
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-file'>
								   
										<embed src='$fileMessages'/>	
								
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_file').value = '';
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-file'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-file'>
						        
						  <embed src='$fileMessages'/>		
						     
						</div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_file').value = '';
				 </script>"; 
			   
		   }
		   
		  }else{
			  
			 if($senderId == $sendId){
		   
		   echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-file'>
						  
						                  <img src='icon/double-tick.png' />
								 
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-file'>
						        
								  <embed src='$fileMessages'/>		
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_file').value = '';
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-file'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-file'>
						        
						 <embed src='$fileMessages'/>		
						     
						 </div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_file').value = '';
				 </script>"; 
			   
		   } 
			  
		  }
		   	
			   
		   }
		   
		   
		   else{
			   
			   //chat music
			   
			if($chatStatus == 1){
		   		   
				if($senderId == $sendId){
		   
					echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-music'>
						  
						          <img src='icon/ticktick.png' />
								  
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-music'>
								   
										<audio controls>
											<source src='$musicMessages'/>
										</audio>
								
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_music').value = '';
							document.getElementById('send_music').innerHTML = document.getElementById('send_music').innerHTML;
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-music'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-music'>
						        
						  <audio controls>
							<source src='$musicMessages'/>
					    </audio>	
						     
						</div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_music').value = '';
					document.getElementById('send_music').innerHTML = document.getElementById('send_music').innerHTML;
				 </script>"; 
			   
		   }
		   
		  }else{
			  
			 if($senderId == $sendId){
		   
		   echo "<div class='chat-chat-right'>
						  
						     <div class='chat-right-page image'>
						  
						          <div class='chat-display-music'>
						  
						                  <img src='icon/double-tick.png' />
								 
						         </div>
								 
						      </div>
						      
							  <div class='chat-right-page name'>
						        
								   <div class='chat-message-music'>
						        
								  <audio controls>
										<source src='$musicMessages'/>
									</audio>	
						     
						           </div>
						     
						      </div>
							  
						  </div>
						  <script>
							var objDiv = document.getElementById('block');
							objDiv.scrollTop = objDiv.scrollHeight;
							document.getElementById('send_music').value = '';
							document.getElementById('send_music').innerHTML = document.getElementById('send_music').innerHTML;
						 </script>";
						  
		   }else{
			   
			  echo "<div class='chat-left'>
						  
				    <div class='chat-left-page image'>
						  
				       <div class='chat-left-display-music'>
						   
						 ". make_chat_user_image($receiverId)."
						  
						 </div>
								 
				     </div>
						  
				      <div class='chat-left-page name'>
						        
					    <div class='chat-left-message-music'>
						
						<audio controls>
							<source src='$musicMessages' />
					    </audio>
						        	
						     
						 </div>
						     
					  </div>
						  
						  
				  </div>
				  <script>
					var objDiv = document.getElementById('block');
					objDiv.scrollTop = objDiv.scrollHeight;
					document.getElementById('send_music').value = '';
					document.getElementById('send_music').innerHTML = document.getElementById('send_music').innerHTML;
				 </script>"; 
			   
		   } 
			  
		  }
		   	
			   
		   }
		   
		   
		     
		      
	   }
	   
   }
   
   
   function make_chat_user_image($receiverId){
	   
	    $query_result = mysql_query("select image from users where user_id = '$receiverId'");
	
		while($row = mysql_fetch_assoc($query_result)){
			
			$userImage = base64_encode($row['image']);
			
			if($userImage == null){
				
				$output = '<img src="icon/account_1.png"/>';
				
			}else{
			$output = '<img src="data:image/jpeg;base64,'.$userImage.'" style="object-fit: cover;">';
			}
			
		}
		
		return $output;
	   
   }
   
   
   function make_chat_last_seen_message($receiverId){
	   
	    $query_result = mysql_query("select image from user_chat inner join users on user_chat.user_id = users.user_id where user_chat.user_id = '$receiverId'");
	
		while($row = mysql_fetch_assoc($query_result)){
			
			$userImage = $row['image'];
			
			if($userImage == null){
				
				$output = '<img src="icon/account_1.png"/>';
				
			}else{
				
				$output = '<img src="'.$userImage.'" style="object-fit: cover;"/>';
			}
			
		}
		
		return $output;
	   
   }
   
   
    if(isset($_POST['action_users_last_seen_message'])){
	  
	   $senderId = $_SESSION['user_id'];
	  
	   $receiverId = $_POST['user_id'];
	 
	   $result = mysql_query("update user_chat set chat_status='0' where (sender_id = '$receiverId' and receiver_id = '$senderId' and chat_status='1')");
	   
	   
	   if($result){
		   
		  echo "update last seen"; 
	   }
	 
	 
	}
	
	
	 if(isset($_POST['action_status'])){
	  
	   $userId = $_SESSION['user_id'];
	  
	   $result = mysql_query("update users SET date = now() where user_id = '$userId'");
	   
	   
	   if($result){
		   
		  echo "update "; 
	   }
	 
	 
	}
	 
	//search users
	
	if(isset($_POST['action_search_users'])){
	  
	  $userId = $_SESSION['user_id'];
	  
	  $search = $_POST['Search'];
	  
	    $query_result = mysql_query("select receiver_id, receiver_name from dialog where receiver_name like '%$search%' and user_id = '$userId'");
		
		while($row = mysql_fetch_assoc($query_result)){
			
			
			
			$userName = $row['receiver_name'];
			
			$userId = $row['receiver_id'];
			$image_query=mysql_query("select image from users where user_id='$userId'");
			$image_row=mysql_fetch_assoc($image_query);
			$userImage = base64_encode($image_row['image']);
			if($userImage == null){
				
				$user_image = "<img src='icon/account_1.png'/>";
				
			}else{
				
				$user_image = "<img src='data:image/jpeg;base64, $userImage' style='object-fit: cover;'>";
			}
			$receiver_id=$_SESSION['receiver_id'];
			
			echo "<div class='search-main-container-inside' data-user_id='".$userId." data-receiver_id='".$receiver_id."'>
		  
							 <div class='search-main-inside photo'>
		  
								  <div class='search-main-image'>
		  
									$user_image
		 
		                          </div>
		 
		                     </div>
						 
							<div class='user-main-inside text'>
		  
		                        <div class='search-main-name'>
		  
		                          <p>$userName</p>
								  
		                        </div>
							
							</div>
							
					</div>";
		
		}
	}
	
	
		//send chat image messages
	
	if($_FILES['files']['name'] != ''){
	  
	$senderId = $_SESSION['user_id'];
	
	$receiverId = $_POST['userId'];

	$target_dir = "chatImages/";
	  
    $name  = $_FILES['files']['name'] ;
	
	$target_file_name = $target_dir . basename($name);
	
	$chat_url = "chatImages/".$name ; 
		
	move_uploaded_file($_FILES['files']['tmp_name'], $target_file_name);
	 
	   $result = mysql_query("insert into user_chat(sender_id, receiver_id, image_message,chat_status,type) values ('$senderId','$receiverId','$chat_url','1','image')");
	   
	   if($result){
		   
		   echo "success";
		  
	   }
	

	
	  
  } 
  
  //send chat video messages
	
	if($_FILES['filess']['name'] != ''){
	  
	$senderId = $_SESSION['user_id'];
	
	$receiverId2 = $_POST['userIdd'];

	$target_dir = "chatVideos/";
	  
    $name  = $_FILES['filess']['name'] ;
	
	$target_file_name = $target_dir . basename($name);
	
	$video_url = "chatVideos/".$name ; 
		
	move_uploaded_file($_FILES['filess']['tmp_name'], $target_file_name);
	 
	   $result = mysql_query("insert into user_chat (sender_id, receiver_id, video_message,chat_status,type) values ('$senderId','$receiverId2','$video_url','1','video')");
	   
	   if($result){
		   
		   echo "success";
		  
	   }
	
	
	
	  
  } 
  
    //send chat file messages
	
	if($_FILES['filesss']['name'] != ''){
	  
	$senderId = $_SESSION['user_id'];
	
	$receiverId3 = $_POST['userIddd'];

	$target_dir = "chatFiles/";
	  
    $name  = $_FILES['filesss']['name'] ;
	
	$target_file_name = $target_dir . basename($name);
	
	$file_url = "chatFiles/".$name ; 
		
	move_uploaded_file($_FILES['filesss']['tmp_name'], $target_file_name);
	 
	   $result = mysql_query("insert into user_chat (sender_id, receiver_id, file_message,chat_status,type) values ('$senderId','$receiverId3','$file_url','1','file')");
	   
	   if($result){
		   
		   echo "success";
		  
	   }
	
	
	
	  
  } 
  
    //send chat music messages
	
	if($_FILES['filessss']['name'] != ''){
	  
	$senderId = $_SESSION['user_id'];
	
	$receiverId4 = $_POST['userIdddd'];

	$target_dir = "chatMusic/";
	  
    $name  = $_FILES['filessss']['name'] ;
	
	$target_file_name = $target_dir . basename($name);
	
	$music_url = "chatMusic/".$name ; 
		
	move_uploaded_file($_FILES['filessss']['tmp_name'], $target_file_name);
	 
	   $result = mysql_query("insert into user_chat (sender_id, receiver_id, music_message,chat_status,type) values ('$senderId','$receiverId4','$music_url','1','music')");
	   
	   if($result){
		   
		   echo "success";
		  
	   }
	
	  
  } 
  
  //send chat file messages
	
	if($_FILES['filesssss']['name'] != ''){
	  
	$senderId = $_SESSION['user_id'];
	
	$receiverId5 = $_POST['userIddddd'];

	$target_dir = "chatFiles/";
	  
    $name  = $_FILES['filesssss']['name'] ;
	
	$target_file_name = $target_dir . basename($name);
	
	$file_urll = "chatFiles/".$name ; 
		
	move_uploaded_file($_FILES['filesssss']['tmp_name'], $target_file_name);
	 
	   $result = mysql_query("insert into user_chat (sender_id, receiver_id, file_message,chat_status,type) values ('$senderId','$receiverId5','$file_urll','1','file')");
	   
	   if($result){
		   
		   echo "success";
		  
	   }
	  
  } 
  
  ?>
