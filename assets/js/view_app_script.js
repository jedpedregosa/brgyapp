let options = {  
    weekday: "long", year: "numeric", month: "short",  
    day: "numeric", hour: "2-digit", minute: "2-digit", second: "2-digit" 
}; 

function display_c(){
	var refresh=1000; // Refresh rate in milli seconds
	mytime=setTimeout('display_ct()',refresh);
}

function display_ct() {
	var date = document.querySelector('.status .date');

	var x = new Date();

	date.innerHTML = x.toLocaleTimeString("en-us", options);
	display_c();
}