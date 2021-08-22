const date = new Date();
const months = [
		"January",
	    "February",
	    "March",
	    "April",
	    "May",
	    "June",
	    "July",
	    "August",
	    "September",
	    "October",
	    "November",
	    "December",
	    ]


document.querySelector('.date').innerHTML = months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear(); // ex. July 24, 2021
document.querySelector('.dayname').innerHTML = new Date().toLocaleString('en-us', {  weekday: 'long' }); // Saturday