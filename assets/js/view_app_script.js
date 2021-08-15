const selected = document.querySelector(".selected");
const optionsContainer = document.querySelector(".options-container");
const optionsList = document.querySelectorAll(".option");
const slots = ["8:00 AM", "8:30 AM", "9:00 AM", "9:30 AM",
	"10:00 AM", "10:30 AM", "11:00 AM", "11:30 AM", "12:00 PM", "12:30 PM", "1:00 PM",
	"1:30 PM", "2:00 PM", "2:30 PM", "3:00 PM"];
selected.addEventListener("click", () => {
  optionsContainer.classList.toggle("active");
});

optionsList.forEach(o => {
  o.addEventListener("click", () => {
    selected.innerHTML = o.querySelector(".lbl_date").innerHTML;
    optionsContainer.classList.remove("active");
  });
});

const selected2 = document.querySelector(".selected2");
const optionsContainer2 = document.querySelector(".options-container2");
const optionsList2 = document.querySelectorAll(".option2");

selected2.addEventListener("click", () => {
  optionsContainer2.classList.toggle("active2");
});

optionsList2.forEach(o2 => {
  	o2.addEventListener("click", () => {
		selected2.innerHTML = o2.querySelector(".lbl_time").innerHTML;
		optionsContainer2.classList.remove("active2");
	});
});

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

function dateSelect(slct_date) {
	let date = slct_date.value;
	let time_show = document.querySelector(".time_show");
	let time_wait = document.querySelector(".time_wait");
	let time_slots = document.querySelector(".options-container2");

	$.ajax({
		url: "../requests/load-slots",
		type: "POST",
		data: {
			view_date: date,
		},
		cache: false,
		beforeSend: function(){
			document.querySelector(".time_none").style.display = "none";
			time_show.style.display = "none";
			time_wait.style.display = "block";
		},
		success: function(dataResult){
			var dataResult = JSON.parse(dataResult);
		}
	}).done(function(dataResult) {
		document.querySelector(".time_wait").style.display = "none";
		var available_slots = JSON.parse(dataResult);

		for(let i = 0; i < available_slots.length; i++) {
			document.getElementById("div" + available_slots[i][0]).style.display = "block";
			if(!available_slots[i][1]) {
				document.getElementById("div" + available_slots[i][0]).style.display = "none";
			}

		}
		time_show.style.display = "block";
	});
}