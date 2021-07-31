const date = new Date();
const months = [
		"JAN",
		"FEB",
		"MAR",
		"APR",
		"MAY",
		"JUNE",
		"JULY",
		"AUG",
		"SEPT",
		"OCT",
		"NOV",
		"DEC",
		]


document.querySelector('.status .date').innerHTML = months[date.getMonth()] + " " + date.getDate() + ", " + date.getFullYear();
document.querySelector('.status .time').innerHTML = ("0" + (date.getHours() % 12 || 12)).slice(-2) + ":" + ("0" +(date.getMinutes())).slice(-2) + ":" + ("0" + (date.getSeconds())).slice(-2);