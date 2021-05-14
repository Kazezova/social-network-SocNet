<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <title>SocNet</title>
	<link rel="stylesheet" type="text/css" href="index-style.css">
	<link rel="stylesheet" type="text/css" href="sign.css">
	<link rel="icon" type="image" href="icon.png">
	<link rel="stylesheet" type="text/css" href="footer.css">
	<link rel="stylesheet" type="text/css" href="main_page_style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style type="text/css">
		.container{
	margin: 0 200px;
}

section{
	height: 100%;
	display: flex;
}
.left{
	width: 100%;
	margin-top:50px; 
}
.card{
	border-radius: 10px;
	box-shadow:0px 0px 14px 8px #BBC1CF;
}
.cardTitle{
	background-color: rgba(70,62,122,1);
	border-top-right-radius:10px;
	border-top-left-radius:10px;
	padding: 10px;
}
.cardTitle h2{
	font-weight: normal;
	font-size: 22px;
	margin: 0;
	padding: 0;
	color: #fff;
}
.cardInformation{
	width: 100%;
	color: #000;
}
.rigth{
	width: 30%;
	margin-top:50px; 
}
.question{
	width: 100%;
	height: 100%;
	padding: 5px;
	margin: 5px;
}
.commentators{
	width: 100%;
	height: 100%;
	padding: 5px;
	margin: 5px;
}

.accordion {
    position: relative;
    margin-bottom: 15px;
	margin-right:40px;
	margin-left:-30px;
}
p{
	color: #000;
}
.accordion li {
    background: #e2e2e2;
    margin-bottom: 5px;
    border-left: 2px solid #f66;
}
ul li {
    list-style-type: none;
}
li {
    display: list-item;
    text-align: -webkit-match-parent;
}
.accordion-item {
    cursor: pointer;
    padding: 7px 5px 7px 10px;
    font-size: 16px;
    font-weight: 600;
}
.accordion-content {
    display: none;
    padding: 5px 5px 10px 10px;
    background: #e2e2e2;
    position: relative;
}
.accordion-content:before {
    content: '';
    background: #acadad;
    width: 200px;
    height: 1px;
    display: block;
    position: absolute;
    top: 0;
    left: 10px;
}
#div1{
  display: none;
}
#div2{
  display: none;
}
#div3{
  display: none;
}
#div4{
  display: none;
}
#div5{
  display: none;
}
#div6{
  display: none;
}
.marker {
    color: rgba(70,62,122,1);
}


	</style>
</head>
<body>
<header>
		<center><h1>SocNet</h1></center>
</header>
			
<section class="container">
		<div class="left">
			<div class="card">
				<div class="cardTitle">
					<h2>Rules of site SocNet.com</h2>
				</div>
				<div class="cardInformation">
					<div class="question">
						 <font color="red">Ignorance of the rules does not relieve you of liability for their violation, we strongly recommend that you read them.</font> 
					</div>
					<hr>
					<div class="question">
						Across the entire site is strictly prohibited:
						<p> 1.Racism, inciting ethnic hatred, propaganda of fascism / Nazism.</p>
						<p>2.Advocacy of drugs and advertising of resources containing their advertising and information</p>
					</div>
					<hr>
					<div class="question">
						<h2 class="marker">Account</h2>
							<ul class="accordion">
								<li>
									<div class="accordion-item" onmousedown="viewDiv()">Number of accounts</div>
									<div id="div1" class="accordion-content">Each user can have only one account. Found fakes will be blocked.
									</div>
								</li>
							</ul>
					</div>
					<hr>
					<div class="question">
								<h2 class="marker">Login</h2>
							<ul class="accordion">
								<li>
									<div class="accordion-item" onmousedown="viewDiv1()">Login Content</div>
									<div id="div2" class="accordion-content">- Nicknames should not contain obscene language (both direct and veiled), offensive language (including racist nature), text related to pornography.
										<p>- Your nickname should not fake existing nicknames (use nicknames that are difficult to distinguish by writing from any other user's nickname)</p>
									</div>
								</li>
							</ul>
							<ul class="accordion">
								<li>
									<div class="accordion-item" onmousedown="viewDiv2()">Login Length</div>
									<div id="div3" class="accordion-content">The nickname must be between 3 and 13 visible characters.
									</div>
								</li>
							</ul>
					</div>
					<hr>
					<div class="question">
							<h2 class="marker">Custom avatars</h2>
							<ul class="accordion">
								<li>
									<div class="accordion-item" onmousedown="viewDiv3()">Image content</div>
									<div id="div4" class="accordion-content">- user avatar - a static image with the file extension .png or .jpg (.jpeg)
																			<p>	- the image should not contain obscene language or obscene gestures.</p>
																			<p>	- the image should not contain 18+ content</p>
																			<p>	- the image should not contain violence or propaganda (drugs, religion, fascism, etc.)</p>
									</div>
								</li>
							</ul>
					</div>
					<hr>
					<div class="question">
						<h2 class="marker">Chat Rules</h2>
						Users entering the chat accept voluntary obligations to abide by the rules listed below!
							<ul class="accordion">
								<li>
									<div class="accordion-item" onmousedown="viewDiv4()">1. Profanity, no matter what language it is in</div>
									<div id="div5" class="accordion-content">- open mate and profanity / obscene language.
																			<p>	- a mat artificially veiled / modified by replacing letters in it with other characters / symbols / letters, while maintaining the semantic load of the original word or phrase.	</p>
																					<p>- quoting from literary / musical / animated works or from the text of a message from another chat user that contains obscene language.
									</p></div>	
								</li>
							</ul>
							<ul class="accordion">
								<li>
									<div class="accordion-item" onmousedown="viewDiv5()">2. Insults</div>
									<div id="div6" class="accordion-content">- sending messages aimed at humiliating the honor and dignity of the individual on the grounds of race, nationality, origin, attitude to religion. (Addressed to the entire chat, personally to the chat participants or their close circle)
																			<p>- deliberate humiliation of the honor and dignity of the person by using the nickname of another chat user.</p>
																			<p>- deliberate humiliation of honor and dignity of the person, expressed in indecent form. (addressed to the entire chat, personally to the chat participants and their close circle)</p>
																			<p>- sending messages, provocative or inflammatory in nature, aimed at inciting hatred, enmity, conflict in the chat (banned at the discretion of the moderator, depending on the situation)</p>
									</div>
								</li>
							</ul>
					</div>
					
					<hr>
					<div class="question" style = "height: 50px">
						<center> </center>
					</div>
					
					
				</div>
			</div>
			
		</div>
	</section>
	

<script type="text/javascript">
function viewDiv(){
	display = document.getElementById("div1").style.display;
	if(display=='none'){
		document.getElementById("div1").style.display = "block";
	 }else{
		document.getElementById("div1").style.display = "none";
		}
};

function viewDiv1(){
	display = document.getElementById("div2").style.display;
	if(display=='none'){
		document.getElementById("div2").style.display = "block";
	 }else{
		document.getElementById("div2").style.display = "none";
		}
};
function viewDiv2(){
	display = document.getElementById("div3").style.display;
	if(display=='none'){
		document.getElementById("div3").style.display = "block";
	 }else{
		document.getElementById("div3").style.display = "none";
		}
};
function viewDiv3(){
	display = document.getElementById("div4").style.display;
	if(display=='none'){
		document.getElementById("div4").style.display = "block";
	 }else{
		document.getElementById("div4").style.display = "none";
		}
};
function viewDiv4(){
	display = document.getElementById("div5").style.display;
	if(display=='none'){
		document.getElementById("div5").style.display = "block";
	 }else{
		document.getElementById("div5").style.display = "none";
		}
};
function viewDiv5(){
	display = document.getElementById("div6").style.display;
	if(display=='none'){
		document.getElementById("div6").style.display = "block";
	 }else{
		document.getElementById("div6").style.display = "none";
		}
};
  
</script>	
	
</html>