$(document).ready(function(){
	
	setInterval(function(){
		
		fetch_users();
		
		users_online_offline_status();
		
	},1000);
	$(document).on('keyup','#type_message', function(){
		
		var TypeMessage = $('#type_message').val();
		
	      if(TypeMessage.length > 0){
			  
			  $('#like').hide();
			  
			  $('#send').show();
			  
		  }else{
			  
			 $('#like').show(); 
			 
			 $('#send').hide();
		  }
		 
	});
		
	$(document).on('click','#setting', function(){
		
		$('.setting-model').show();
		
	});
	
	$('body').on('click', function(){
		
		$('.setting-model').hide();
		
	});
	
	fetch_users();
	
	function fetch_users()
	{
		
		var action = "fetch_users";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_users:action},
			
			success:function(data){
				
			$('.user-main-container').html(data);
			
			
			}
			
		});
		
	}
	
	//users search
	
		$(document).on('keyup','#search_users', function(){
		
		var TypeSearch = $('#search_users').val();
		
	      if(TypeSearch.length > 0){
			  
			  $('.user-main-container').hide();
			  
			  $('.search-main-container').show();
			  
		  }else{
			  
			 $('.user-main-container').show(); 
			 
			 $('.search-main-container').hide();
		  }
		 
	});
	
	
	$(document).on('keyup','#search_users', function(){
		
			var Search = $('#search_users').val();
		
			if(Search != ''){
				
				fetch_search_users(Search);
				
			}else{
				
				fetch_search_users();
			}
		
		});
		
		
		
	
	function fetch_search_users(Search)
	{
		
		var action = "fetch_search_users";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_search_users:action, Search:Search},
			
			success:function(data){
				
			$('.search-users-container').html(data);
			
			}
			
		});
		
	}
	
	$(document).on('click','.search-main-container-inside', function(){
		
		var userId = $(this).data('user_id');
	
		fetch_users_top_nav(userId);
		
		fetch_users_profile(userId);
		
		type_messages(userId);
		
		fetch_message(userId); 

        users_last_seen_message(userId);
		
			
	});
	
	$(document).on('click','.hidden', function(){
		var receiverId = $(this).data('receiver_id');
		fetch_users_top_nav(receiverId);
		
		fetch_users_profile(receiverId);
		
		type_messages(receiverId);
		
		fetch_message(receiverId); 

        users_last_seen_message(receiverId);
		
		send_music_messages(receiverId);
		
		send_video_messages(receiverId);
		
		send_file_messages(receiverId);
		
		send_image_messages(receiverId);
		
		send_gif_messages(receiverId);
	});
	document.getElementById('hidden').click();
	
	//user main details

	$(document).on('click','.user-main-details', function(){
		
		var userId = $(this).data('user_id');
		
		fetch_users_top_nav(userId);
		
		fetch_users_profile(userId);
		
		type_messages(userId);
		
		fetch_message(userId); 

        users_last_seen_message(userId);
		
		send_music_messages(userId);
		
		send_video_messages(userId);
		
		send_file_messages(userId);
		
		send_image_messages(userId);
		
		send_gif_messages(userId);
	});

	
	function type_messages(userId){
	
	$('#send').unbind('click').bind('click', function(){
			
		var SendMessage = $('#type_message').val();
		
		send_message(userId, SendMessage);
	   
	
	});
	
	}
	
	
	fetch_users_top_nav(userId);
	
	function fetch_users_top_nav(userId)
	{
		
		var action = "fetch_users_top_nav";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_users_nav:action, user_id:userId},
			
			success:function(data){
				
			$('.main-navbar').html(data);
			
			}
			
		});
		
	}
	
	fetch_users_profile(userId);
	
	function fetch_users_profile(userId)
	{
		
		var action = "fetch_users_profile";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_users_profile:action, user_id:userId},
			
			success:function(data){
				
			$('.user-profile-detail').html(data);
			
			}
			
		});
		
	}
	
	
	  
	send_message(userId, SendMessage);
	
	function send_message(userId, SendMessage)
	{
		
		var action = "send_message";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_send_message:action, user_id:userId, send_message:SendMessage},
			
			success:function(data){
				
			$('#type_message').val('');	
				  
			fetch_message(userId);
			
			
			}
			
		});
		
	}
	
	//send chat image message
	
						function send_image_messages(userId){
								$( '#select_image' ).unbind('click').bind( 'click', function() {
								  $( '#send_image' ).trigger( 'click' );
								});
								
								$('#send_image').unbind('change').bind('change', '#send_image', function(){
		
										var formData = new FormData();
										
										var inputFile = document.getElementById('send_image').files[0];
										
										
										 formData.append("files", inputFile);
										
										 formData.append("userId", userId);
										 
										 
										$.ajax({
											
											url:"messenger_action.php",
											
											method:"post",
											
											data:formData,
											
											contentType:false,
											
											cache:false,
											
											processData:false,
											
											success:function(data){
												
											fetch_message(userId); 
											
											}
											
										});
										
									});
								}
	
	
	//send chat video message
	


						
						function send_video_messages(userId){
								$( '#select_video' ).unbind('click').bind( 'click', function() {
								  $( '#send_video' ).trigger( 'click' );
								});
								
								$('#send_video').unbind('change').bind('change', '#send_video', function(){
		
										var formData = new FormData();
										
										var inputFile = document.getElementById('send_video').files[0];
										
										 formData.append("filess", inputFile);
										
										 formData.append("userIdd", userId);
										 
										$.ajax({
											
											url:"messenger_action.php",
											
											method:"post",
											
											data:formData,
											
											contentType:false,
											
											cache:false,
											
											processData:false,
											
											success:function(data){
												
											fetch_message(userId); 
											
											}
											
										});
										
									});
								}
								
	//send file message
	

	
						
						function send_file_messages(userId){
								$( '#select_file' ).unbind('click').bind( 'click', function() {
								  $( '#send_file' ).trigger( 'click' );
								  
								});
								
								$('#send_file').unbind('change').bind('change', '#send_file', function(){
		
										var formData = new FormData();
										
										var inputFile = document.getElementById('send_file').files[0];
										
										 formData.append("filesss", inputFile);
										
										 formData.append("userIddd", userId);
										 
										$.ajax({
											
											url:"messenger_action.php",
											
											method:"post",
											
											data:formData,
											
											contentType:false,
											
											cache:false,
											
											processData:false,
											
											success:function(data){
												
											fetch_message(userId); 
											
											}
											
										});
										
									});
								}
								
								
	//send chat music message
	

	
						
						function send_music_messages(userId){
								$( '#select_music' ).unbind('click').bind( 'click', function() {
								  $( '#send_music' ).trigger( 'click' );
								});
								
								$('#send_music').unbind('change').bind('change', '#send_music', function(){
		
										var formData = new FormData();
										
										var inputFile = document.getElementById('send_music').files[0];
										
										 formData.append("filessss", inputFile);
										
										 formData.append("userIdddd", userId);
										 
										 
										$.ajax({
											
											url:"messenger_action.php",
											
											method:"post",
											
											data:formData,
											
											contentType:false,
											
											cache:false,
											
											processData:false,
											
											success:function(data){
												
											fetch_message(userId); 
											
											}
											
										});
										
									});
								}
								
								
	//send gif message
	

	
						
						function send_gif_messages(userId){
								$( '#select_gif' ).unbind('click').bind( 'click', function() {
								  $( '#send_gif' ).trigger( 'click' );
								  
								});
								
								$('#send_gif').unbind('change').bind('change', '#send_gif', function(){
		
										var formData = new FormData();
										
										var inputFile = document.getElementById('send_gif').files[0];
										
										 formData.append("filesssss", inputFile);
										
										 formData.append("userIddddd", userId);
										 
										$.ajax({
											
											url:"messenger_action.php",
											
											method:"post",
											
											data:formData,
											
											contentType:false,
											
											cache:false,
											
											processData:false,
											
											success:function(data){
												
											fetch_message(userId); 
											
											}
											
										});
										
									});
								}
	
	//users top nav
	
	   fetch_message(userId);
	
	  function fetch_message(userId)
	  {
		
		var action = "fetch_message";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_fetch_message:action, user_id:userId},
			
			success:function(data){
				
			$('.chat-chat-container').html(data);	
				  
			
			}
			
		});
		
	}
	
	
	 users_last_seen_message(userId);
	
	  function users_last_seen_message(userId)
	  {
		
		var action = "users_last_seen_message";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_users_last_seen_message:action, user_id:userId},
			
			success:function(data){
				
			 //alert(data);	  
			
			}
			
		});
		
	}
	
	users_online_offline_status();
	
	  function users_online_offline_status()
	  {
		
		var action = "users_online_offline_status";
		
		$.ajax({
			
			url:"messenger_action.php",
			
			method:"post",
			
			data:{action_status:action},
			
			success:function(data){
				
			 //alert(data);	  
			
			}
			
		});
		
	}
	
	
});