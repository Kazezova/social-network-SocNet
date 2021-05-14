<?php
  error_reporting(0);
	
  include('connect.php');  
	
  $user = $_SESSION['user_id'];

  $sql = "SELECT * FROM `users` WHERE `user_id` = '$user'";
		
  $result = mysqli_query($conn, $sql);
			
  while($row = mysqli_fetch_assoc($result)){
		
  $profileImage = base64_encode($row['image']);
		 
  if($profileImage == null){
			  
  $userImage = "<img src='icon/account_1.png' />";
			  
	 }
	 else{
			  
  $userImage = "<img src='data:image/jpeg;base64,$profileImage' style='object-fit: cover;'/>";
			
	  }
		  
 }    
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  
  <meta charset="utf-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
   <div class="back-coment">
   <div class="comment-body-container">
	     
	<div class="comment-nav-container">
	
	 <ul>
	   
	   <li class="comment-icon"><a class="comment-close"><img src="icon/back.png" style="width:25px; height:25px;"></a></li>
	   
	   <li class="comment-name"><a>Comments</a></li>
	   
	 
	 </ul>
	
	</div>
	  
	  <div class="comment-main-container">
	      
		    <div class="comment-post-container">
		         
				
	  
	         </div>
			

		    <div class="comment-comment-container">
	            
			  
	        </div>
	  
	  </div>
	  
	  
	
	<div class="comment-bottom-container">
	
	     <form  method="post" id="comment_form" data-action="comment">
	   
	 		
	      <div class="comment-bottom-inner-container image">
	              
	           <?php echo $userImage; ?>
	
	      </div>
		 
		  
		  <div class="comment-bottom-inner-container comment">
	
	           <input type="text" name="comment"  placeholder="Add a comment..." id="insert_comment" autocomplete="off"></input>
					
	
	      </div>
		  
		  <div class="comment-bottom-inner-container submit">
	
	          <button type="submit" name="submit" id="submit"><img src="icon/sendsend.png" id="sendsend"></button>
					
	
	      </div>
		  
		 </form>
	       			 
	</div>

    </div>

	  </div>

</body>
</html>