document.getElementById('wait').style.display = 'block'; 
  document.getElementById('button').style.display = 'none';
  var display = document.querySelector('.display'); 
  var timeLeft = parseInt(display.innerHTML); 
  
  var timer = setInterval(function(){
    if (--timeLeft >= 0) { 
      display.innerHTML = timeLeft;
    } else {
      document.getElementById('wait').style.display = 'none'; 
     document.getElementById('button').style.display = 'block'; 
      clearInterval(timer)
    }
}, 1000)


  