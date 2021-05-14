function guess(){
	var tries = $("try").textContent;
	tries=tries-1;
	if (tries==0){
		alert("You have used up login attempts, you can try again after 30 minutes");
	} 
	else{
		$("try").innerHTML=tries;
	}
}