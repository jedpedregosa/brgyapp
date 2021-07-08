var date = new Date(getServerTime());

function getServerTime() {
	return $.ajax({async: false}).getResponseHeader( 'Date' );
}

function setSlctdDate(dateID) {
	var txtDate = document.getElementById("slctdDate");
	txtDate.text = dateID;
}
	const renderCalendar = () => {
		date.setDate(1);

		var slctyear = date.getFullYear().toString().substr(-2);
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
		document.querySelector('.date .day_num').innerHTML = new Date().getDate();

		let days = "";

		for(let x=firstDayIndex; x>0; x--){
			days += `<div class="prev-date">${prevLastDay - x + 1}</div>`;
		}

		for(let i=1; i<=lastDay; i++){
			if(i===new Date(getServerTime()).getDate() && date.getMonth() === new Date(getServerTime()).getMonth() && date.getFullYear() == new Date(getServerTime()).getFullYear()) {

				days += `<div class="today"><input type="radio" name="day" id="${i}" value="${slctyear + slctmonth + i}" onclick = "setSlctdDate(${slctyear + slctmonth + i})">
				<label for="${i}">${i}</label></div>`;
			} else {
			days += `<input type="radio" name="day" class="select_day" id="button${i}" value="${slctyear + slctmonth + i}" onclick = "setSlctdDate(${slctyear + slctmonth + i})">
			<label for="button${i}">${i}</label>`;
			}
		}

		for(let j=1; j<=nextDays;j++){
			days += `<div class="next-date">${j}</div>`;
		}
		monthDays.innerHTML = days;
	}

document.querySelector('.controls .prev_btn').addEventListener('click',()=>{
	date.setMonth(date.getMonth()-1);
	renderCalendar();
});

document.querySelector('.controls .next_btn').addEventListener('click',()=>{
	date.setMonth(date.getMonth()+1);
	renderCalendar();
});

renderCalendar();

