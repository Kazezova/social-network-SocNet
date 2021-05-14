$(document).ready(function(){
	
	// alert("hihi");

	var user_push, pushing, push = false;
	
	 $('.comment-home-conatiner').hide();	
		
		//home main tabs
		
		$(".tab").click(function(){
			
			$(".tab").removeClass("active");
			
			$(this).addClass("active");
			
			var contentId = $(this).attr("href");
			
			if(!push)
				
			history.pushState({}, '', contentId);
		   
		    $(".container").removeClass("actives");
			
			$('.container[id="'+contentId+'"]').addClass("actives");
			
		    push = false;
				
			return false;
			
		
		}); 
		
		//backpress home tabs
	  
	   $(window).on("popstate", function(e) {
		  
         e.preventDefault();
		 
		 push = true;
		 
		var prevTabs = (window.location.href.indexOf("/") > -1) ? window.location.href.split("/").pop() : false;
			
		if(prevTabs == 'my_profile_page.php') {
					
	 	$('mainTab, ul li a[href="Home"]').click();
				
				
		} else {
				
		$('mainTab, ul li a[href="'+prevTabs+'"]').click();
				
			
		}
					
	 });
		
		//profile main tabs
		
		 $(".profile-tab").click(function(){
			
			$(".profile-tab").removeClass("profile-active");
			
			$(this).addClass("profile-active");
		
			var contentId = $(this).attr("href");
			
			if(!pushing)
				
			history.pushState({}, '', contentId);
		   
			var contentId = contentId.substr(1);
			
		    $(".profile-container-inside").removeClass("profile-actives");
			
			$('.profile-container-inside[id="'+contentId+'"]').addClass("profile-actives");
			
		    pushing = false;
				
			return false;
		
			
		}); 
		
		//backpress profile tabs
		
		$(window).bind("popstate", function(e) {
			
			$('.comment-home-conatiner').hide();	
			
			//alert("hellohello");
			
		  e.preventDefault();
		  
		 pushing = true;
		 
		var prevTab = (window.location.href.indexOf("#") > -1) ? window.location.href.split("#").pop() : false;
			
		
		if(prevTab == false) {
					
	 	   $(' ul li a[href="#grid"]').click();
				
				
		} else {
				
				
		  $('ul li a[href="#'+prevTab+'"]').click();
			
		}
		
		if(prevTab == false) {
					
	 	   $('.profile-grid-container').hide();
			
		   $(".profile-main-container").css("overflow-y", "scroll");
				
				
		}
		
		if(prevTab == false) {
					
	 	   $('.comment-home-conatiner').hide();		
				
		}
		
		if(prevTab == 'profile-grid') {
					
	 	   $('.profile-grid-container').show();	
		   
		   $('.comment-home-conatiner').hide();		
				
		}
		if(prevTab == false) {
					
	 	   $('.edit-profile-container').hide();
			
		}
		  
	 }); 

		 //click like post
	   
	    $(document).on('click', '.like_button', function(){
			
			// alert("like");
			
			var postId = $(this).data('post_id');
			
			var userId = $(this).data('user_id');
			
			var postlike = $(this).data('action');
			
			
			$.ajax({
			   
			   url:"my_profile_page.php",
			   
			   method:"post",
			   
			   data:{action_like:postlike, user_id:userId, post_id:postId},
			   
			   success:function(data){
				   
				   fetch_post();
				   
				   
			   }
		   });
			
			window.location.reload(false); 
		});

		 $(document).on('click', '.share_like_button', function(){
			
			// alert("like");
			
			var shareId = $(this).data('share_id');
			
			var userId = $(this).data('user_id');
			
			var postlike = $(this).data('action');
			
			
			$.ajax({
			   
			   url:"my_profile_page.php",
			   
			   method:"post",
			   
			   data:{action_like:postlike, user_id:userId, share_id:shareId},
			   
			   success:function(data){
				   
				   fetch_post();
				   
				   
			   }
		   });
			
			window.location.reload(false); 
		});
		
		//comments details
		 
		$(document).on('click', '.comment_button', function(e){
			
			//alert("coment");
			
			e.preventDefault();
			
			var postId = $(this).data('post_id');
			
			var userId = $(this).data('user_id');
		
			var userImage = $(this).data('image');
			
			var href = $(this).attr('href');
			
			history.pushState({}, '', href);
			
			$('.comment-home-conatiner').show();
			
			insert_comment(userId, postId);
			
			fetch_comment(userId, postId );
			
			fetch_caption(postId );
			
			fetch_single_post(postId);
			
			fetch_grid_post();
			
			fetch_list_post();
			
		});
		
		
		function insert_comment(userId, postId){
			
			$('#comment_form').unbind('submit').bind('submit', function(e){
		   
		   e.preventDefault();
		   
		   var action = $(this).data('action');
		   
			
		   var postComment = $('#insert_comment').val();
			
	
		   $.ajax({
			   
			   url:"socnet_action.php",
			   
			   method:"post",
			   
			   data:{action:action, post_comment:postComment,  post_id:postId},
			   
			   success:function(data){
				   
				   $('#comment_form')[0].reset();
				  
				 
			      fetch_comment(userId, postId );
				
		          fetch_post();
				   
				  fetch_grid_post();
		   
		          fetch_list_post();
				  
			   }
		   });
		    
	   });
	   
	   
		}
    
	 function fetch_comment(userId, postId )
	   
	   {
		   
		  var action = 'fetch_comment'; 
		   
		   $.ajax({
			   
			   url:"socnet_action.php",
			   
			   method:"post",
			   
			   data:{action_comment:action, user_id:userId, post_id:postId},
			   
			   success:function(data){
				   
				   $('.comment-comment-container').html(data);
				   
			      
				   
				   user_post(postId);
		    
			       user_grid_post(postId);
		    
		 
			   }
		   });
	   }
	   
	   
	    function fetch_caption(postId)
	   
	   {
		   
		  var action = 'fetch_caption'; 
		   
		   $.ajax({
			   
			   url:"socnet_action.php",
			   
			   method:"post",
			   
			   data:{action_caption:action, post_id:postId},
			   
			   success:function(data){
				   
				   $('.comment-post-container').html(data);
				   
			 
			   }
		   });
	   }
	   
	   //close comment
	  
	  $('.comment-close').on('click', function(e){
		   
		   e.preventDefault();
		   
		  window.history.back();
			  
		 
	     });
		
		
 }); 		