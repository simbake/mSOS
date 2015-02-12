
    /*
 * Auto logout
 */
var timer = 0;
function set_interval() {
  showTime()
  // the interval 'timer' is set as soon as the page loads
  timer = setInterval("auto_logout()", 240000);
  // the figure '1801000' above indicates how many milliseconds the timer be set to.
  // Eg: to set it to 5 mins, calculate 3min = 3x60 = 180 sec = 180,000 millisec.
  // So set it to 180000
}

function reset_interval() {
  showTime()
  //resets the timer. The timer is reset on each of the below events:
  // 1. mousemove   2. mouseclick   3. key press 4. scroliing
  //first step: clear the existing timer

  if(timer != 0) {
    clearInterval(timer);
    timer = 0;
    // second step: implement the timer again
    timer = setInterval("auto_logout()", 240000);
    // completed the reset of the timer
  }
}

function auto_logout() {

  // this function will redirect the user to the logout script
  window.location = "<?php echo base_url(); ?>user_management/logout";
}

/*
* Auto logout end
*/
  function showTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
h=checkTime(h);
m=checkTime(m);
s=checkTime(s);
$("#clock").text(h+":"+m);
t=setTimeout('showTime()',1000);

}
function checkTime(i)
{
if (i<10)
  {
  i="0" + i;
  }
return i;
}  
	$(document).ready(function() {
					$('.alert-success').fadeOut(10000, function() {
    // Animation complete.
});
});