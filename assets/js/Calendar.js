
var available_dates;
var available_slots;
var currentDate;
var date;
var finalDate;
var daySelected;
let affect_months;

function setSlctdDate(dateID) {
	var txtDate = document.getElementById("slctdDate");
	txtDate.text = dateID;
	daySelected = new Date(dateID).getDate();
	document.querySelector('.date .day_num').innerHTML = daySelected;

	if(timeButton) {
		timeButton.style.backgroundColor = ''; // SET THE SELECTED BUTTON TO UNHOLD
    	timeButton.style.color = '';
		slctTimeSlt = null;
	}
	

	var officeId = $('#Office').val();
	$.ajax({
		url: "../../requests/load-slots",
		type: "POST",
		data: {
			date: dateID,
			office: officeId
		},
		cache: false,
		beforeSend: function(){
			document.getElementById("slots").style.display = "none";
			document.getElementById("slotsload").style.display = "block";
		},
		success: function(dataResult){
			var dataResult = JSON.parse(dataResult);

		}
	}).done(function(dataResult) {
		document.getElementById("slotsload").style.display = "none";
		document.getElementById("slots").style.display = "block";
		var available_slots = JSON.parse(dataResult);

		for(let i = 0; i < available_slots.length; i++) {
			tmslotbutton = document.getElementById(available_slots[i][0]);
				
			tmslotbutton.disabled = !(available_slots[i][1]);

		}
	});
	  
}
function startCalendar() {
	currentDate = new Date(available_dates[0]);
	date = new Date(currentDate);
	daySelected = currentDate.getDate();

	affect_months = available_dates.length / 30;
	renderCalendar(); 
}
function n(n){
    return n > 9 ? "" + n: "0" + n;
}
function isInArray(value) {
	return (available_dates.find(item => {return item == value}) || []).length > 0;
  }

	const renderCalendar = () => {
		date.setDate(1);

		var slctyear = date.getFullYear();
		var slctmonth = date.getMonth() + 1;

		const monthDays = document.querySelector(".days");

		const lastDay = new Date(date.getFullYear(),date.getMonth()+ 1, 0).getDate();

		const prevLastDay = new Date(date.getFullYear(),date.getMonth(),0).getDate();

		const firstDayIndex = date.getDay();

		const lastDayIndex = new Date(date.getFullYear(), date.getMonth()+1,0).getDay();

		const nextDays = 7 - lastDayIndex - 1;

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

		document.querySelector('.date .month_ttl').innerHTML = months[date.getMonth()];
		document.querySelector('.date .year_ttl').innerHTML = date.getFullYear();
		document.querySelector('.date .day_num').innerHTML = daySelected;

		let days = "";

		for(let x=firstDayIndex; x>0; x--){
			days += `<div class="prev-date">${prevLastDay - x + 1}</div>`;
		}

		for(let i=1; i<=lastDay; i++){
			rawDate = slctyear + "-" + n(slctmonth) + "-" + n(i);
			loadDate = new Date(slctmonth + " " + i + " " + slctyear);
			finalDate = loadDate.toLocaleDateString("en-US");
			
			var dayAvailable = isInArray(rawDate);

			if(i=== currentDate.getDate() && date.getMonth() === currentDate.getMonth() && date.getFullYear() == currentDate.getFullYear() && (loadDate.getDay() != 0 && loadDate.getDay() != 6) && dayAvailable) {
				days += `<div class="today"><input type="radio" name="day" id="${i}" value="${finalDate}" onclick = "setSlctdDate('${finalDate}')" checked>
				<label for="${i}">${i}</label></div>`;
			} else if(i < currentDate.getDate() && date.getMonth() === currentDate.getMonth() && date.getFullYear() == currentDate.getFullYear()) {
				days += `<div class="prev-date">${i}</div>`;
			} else if((loadDate.getDay() == 0 || loadDate.getDay() == 6) || !dayAvailable){
				days += `<div class="prev-date">${i}</div>`;
			} else {
				days += `<input type="radio" name="day" class="select_day" id="button${i}" value="${finalDate}" onclick = "setSlctdDate('${finalDate}')">
				<label for="button${i}">${i}</label>`;
			}
		}

		for(let j=1; j<=nextDays;j++){
			days += `<div class="next-date">${j}</div>`;
		}
		monthDays.innerHTML = days;
	}

document.querySelector('.controls .prev_btn').addEventListener('click',()=>{
	if(currentDate.getMonth() + 1 <= date.getMonth()) {
		date.setMonth(date.getMonth()-1);
		renderCalendar();
	}

});

document.querySelector('.controls .next_btn').addEventListener('click',()=>{
	if(currentDate.getMonth() + affect_months > date.getMonth()) {
		date.setMonth(date.getMonth()+1);
		renderCalendar();
	}
});

//renderCalendar();

