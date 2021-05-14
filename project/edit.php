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
	if(is_null($university)){
		$university='-';
	}
	if(is_null($specialty)){
		$specialty='-';
	}
	if(is_null($uni_status)){
		$uni_status='-';
	}
	if(is_null($uni_date_of_issue)){
		$uni_date_of_issue='-';
	}
	if(is_null($work)){
		$work='-';
	}
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
	$update=$_POST['update'];
	if(isset($update)){
		$img_type = substr($_FILES['img_upload']['type'], 0, 5);
		$img_size = 2*1024*1024;
		if(!empty($_FILES['img_upload']['tmp_name']) and $img_type === 'image' and $_FILES['img_upload']['size'] <= $img_size){ 
		$img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
		}
		$new_name=$_POST['new_name'];
		$new_surname=$_POST['new_surname'];
		$day=$_POST['new_day'];
		$month=$_POST['new_month'];
		$year=$_POST['new_year'];
		if($day=='none' or $month=='none' or $year=='none'){
			$new_bd=$bd;
		}
		else{
			$new_bd="$day.$month.$year";
		}
		$new_gender=$_POST['new_gender'];
		if(is_null($new_gender)){
			$new_gender=$gender;
		}
		else{
			$new_gender=$_POST['new_gender'];
		}
		$new_country=$_POST['new_country'];
		$new_city=$_POST['new_city'];	
		$new_relationship=$_POST['new_relationship'];
		if(is_null($new_relationship)){
			$new_relationship=$relationship;
		}
		else{
			$new_relationship=$_POST['new_relationship'];
		}
		$new_phone=$_POST['new_phone'];
		if(!empty($img)){
			$up_img=mysql_query("update users set image='$img' where user_id='$user'");
			if(!$up_img) die ("Insert error: " . mysql_error());
		}
		$up=mysql_query("update users set name='$new_name', surname='$new_surname', birthday='$new_bd', gender='$new_gender', country='$new_country',city='$new_city', relationship='$new_relationship', phone='$new_phone' where user_id='$user'");
			if(!$up) die ("Insert error: " . mysql_error());
		header("Location:edit.php");
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
	<link rel="stylesheet" type="text/css" href="edit_page_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
		<div class="seconds">
			<form action="" method="post" enctype="multipart/form-data">
			<div class="profile" style="display: block;">
			<div style="display: flex;">
			<div class="profile-image">
				<div>
				    <label class="change_label">
				      <i class="fa fa-user-plus"></i>
				      <input type="file" name="img_upload">
				    </label>
				</div>
			</div>
			<div class="profile-info">
				<div class="flex">
					<div class="word">
						<font id="spaces">Name: </font><br>
						<font id="spaces">Surname: </font><br>
						<font id="spaces">Birthday: </font><br>
						<font id="spaces">Gender: </font><br>
						<font id="spaces">Country: </font><br>
						<font id="spaces">City: </font><br>
						<font id="spaces">Relationship: </font><br>
						<font id="spaces">Phone: </font>
					</div>
					<div class="info">
						<input type="text" name="new_name" value="<?=$name;?>" id="new-input" required="required"><br>
						<input type="text" name="new_surname" value="<?=$surname;?>" id="new-input" required="required"><br>
						<div style="display: flex;">
							<select name="new_day" id="new-select-bd">
								<option value="none">Day</option>
	                            <option value="01">1</option>
	                            <option value="02">2</option>
	                            <option value="03">3</option>
	                            <option value="04">4</option>
	                            <option value="05">5</option>
	                            <option value="06">6</option>
	                            <option value="07">7</option>
	                            <option value="08">8</option>
	                            <option value="09">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>  
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>  
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
	                            <option value="28">28</option>
	                            <option value="29">29</option>
	                            <option value="30">30</option>
	                            <option value="31">31</option>
							</select>
							<select name="new_month" id="new-select-bd">
								<option value="none">Month</option>
	                            <option value="01" name="month">January</option>
	                            <option value="02">February</option>
	                            <option value="03">March</option>
	                            <option value="04">April</option>
	                            <option value="05">May</option>
	                            <option value="06">June</option>
	                            <option value="07">July</option>
	                            <option value="08">August</option>
	                            <option value="09">September</option>
	                            <option value="10">October</option>
	                            <option value="11">November</option>
	                            <option value="12">December</option>
							</select>
							<select name="new_year" id="new-select-bd">
								<option value="none">Year</option>
	                            <option value="year" name="2020">2020</option>
	                            <option value="2019">2019</option>
	                            <option value="2018">2018</option>
	                            <option value="2017">2017</option>
	                            <option value="2016">2016</option>
	                            <option value="2015">2015</option>
	                            <option value="2014">2014</option>
	                            <option value="2013">2013</option>
	                            <option value="2012">2012</option>
	                            <option value="2011">2011</option>
	                            <option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								<option value="2005">2005</option>
								<option value="2004">2004</option>  
								<option value="2003">2003</option>
								<option value="2002">2002</option>
								<option value="2001">2001</option>
								<option value="2000">2000</option>
								<option value="1999">1999</option>
								<option value="1998">1998</option>
								<option value="1997">1997</option>
								<option value="1996">1996</option>  
								<option value="1995">1995</option>
								<option value="1994">1994</option>
								<option value="1993">1993</option>
								<option value="1992">1992</option>
								<option value="1991">1991</option>
								<option value="1990">1990</option>
	                            <option value="1989">1989</option>
	                            <option value="1988">1988</option>
	                            <option value="1987">1987</option>
	                            <option value="1986">1986</option>
								<option value="1985">1985</option>
								<option value="1984">1984</option>
								<option value="1983">1983</option>
								<option value="1982">1982</option>  
								<option value="1981">1981</option>
								<option value="1980">1980</option>
								<option value="1979">1979</option>
								<option value="1978">1978</option>
								<option value="1977">1977</option>
								<option value="1976">1976</option>
	                            <option value="1975">1975</option>
	                            <option value="1977">1974</option>
	                            <option value="1973">1973</option>
	                            <option value="1972">1972</option>
								<option value="1971">1971</option>
								<option value="1970">1970</option>
								<option value="1969">1969</option>
								<option value="1968">1968</option>  
								<option value="1967">1967</option>
								<option value="1966">1966</option>
								<option value="1965">1965</option>
								<option value="1964">1964</option>
								<option value="1963">1963</option>
								<option value="1962">1962</option>
	                            <option value="1961">1961</option>
	                            <option value="1960">1960</option>
	                            <option value="1959">1959</option>
	                            <option value="1958">1958</option>
								<option value="1957">1957</option>
								<option value="1956">1956</option>
								<option value="1955">1955</option>
								<option value="1954">1954</option>  
								<option value="1953">1953</option>
								<option value="1952">1952</option>
								<option value="1951">1951</option>
								<option value="1950">1950</option>
							</select>
						</div>
				        	<select class="form-control" name="new_gender" id="new-select">
							<option disabled="disabled">Select a Gender</option>
							<option selected disabled hidden><?=$gender;?></option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Others">Others</option>
							</select>
						<input type="text" name="new_country" value="<?=$country;?>" id="new-input"><br>
						<input type="text" name="new_city" value="<?=$city;?>" id="new-input"><br>
						<select class="form-control" name="new_relationship" id="new-select">
							<option selected disabled hidden><?=$relationship;?></option>
							<option value="Single">Single</option>
							<option value="In a relationship">In a relationship</option>
							<option value="Crushing">Crushing</option>
							<option value="Married">Married</option>
							<option value="It's complicated">It's complicated</option>
							<option value="Broken hearted">Broken Hearted</option>
						</select>
						<input type="text" name="new_phone" value="<?=$phone;?>" id="new-input"><br>
					</div>
				</div>
			</div>
			</div>
			<center><input type="submit" name="update" value="save" id="upload_button" style="float: none;"></center>
			</div>
			</form>
		</div>
		<div class="third">
			<div class="links">
				<div class="row" style="background-color: rgba(70,62,122,0.1);">
					<a href="edit.php?id=<?=$user?>">Main Information</a>
				</div>
				<div class="row">
					<a href="edit_education.php?id=<?=$user?>">Education</a>
				</div>
				<div class="row">
					<a href="edit_career.php?id=<?=$user?>">Career</a>
				</div>
				<div class="row">
					<a href="edit_interest.php?id=<?=$user?>">Interest</a>
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