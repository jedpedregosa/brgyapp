// RTU APPOINTMENT SYSTEM

// Intialization
var slctTimeSlt = null;
var slctDate = null;
var prevTimeButton;

const slidePage = document.querySelector(".slide-page"); // important for flipping next
const nextBtnFirst = document.querySelector(".firstNext"); // first next button
const prevBtnSec = document.querySelector(".prev-1"); // calendar previous button
const nextBtnSec = document.querySelector(".next-1"); // calendar next button
const prevBtnThird = document.querySelector(".prev-2"); // personal previous button
const nextBtnThird = document.querySelector(".next-2"); // personal next button
const prevBtnFourth = document.querySelector(".prev-3"); // confirmation previous button
const submitBtn = document.querySelector(".submit"); // confirm button 
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bullet");
let current = 1;

nextBtnFirst.addEventListener("click", function(event) {

    // Submit to db
    var lname = $('#last-name').val();
	var fname = $('#first-name').val();
	var email = $('#email-address').val();
	var phone = $('#contact-number').val();
    var company = $('#affiliated-company').val();
    var govId = $('#government-ID').val();
    /*
    var companyElement = document.getElementById("affiliated-company");
    var govIdElement = document.getElementById("government-ID");

    if(companyElement && govIdElement) {
        company = companyElement.text;
        govId = govIdElement.text;
    } */
    var isAvail = true;
    if(validateEmail(email)) {
        $.ajax({
			url: "../../includes/chk-email.php",
			type: "POST",
			data: {
				email: email
			},
			cache: false,
			success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
					if(dataResult.hasEmail == 200){
                        alert('Engk!! Email');
                        isAvail = false;
                    } 
				}
                
			});

    } else {
        alert('Engk!! Email');
        return false; // Issue: Not stopping the whole block
    }
    if(!isAvail) {
        return false;
    }
		
    if(lname!="" && fname!="" && phone!="" && email!=""){
		$.ajax({
			url: "../../includes/reg-appointment.php",
			type: "POST",
			data: {
				lname: lname,
				email: email,
				phone: phone,
				fname: fname,
                company: company,
                govId: govId
			},
			cache: false,
			success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
					if(dataResult.statusCode==200){
                        // Insert JS Form Validation
                        event.preventDefault();
                        slidePage.style.marginLeft = "-25%";
                        bullet[current - 1].classList.add("active");
                        progressCheck[current - 1].classList.add("active");
                        current += 1;
					}
					else if(dataResult.statusCode==201){
					   alert("Error occured !"); // Error Page
					} else if(dataResult.statusCode==202) {
                        alert("Nakuha nayan bunak");
                    }
				}
			});
		}
});
nextBtnSec.addEventListener("click", function(event) {
    slctDate = slctdDate.text;
    if(slctTimeSlt == null || slctDate == null) { // If User selected a schedule (both time & day)
        // Validation Here
    } else {
        var officeId = document.getElementById('Office').value;
        var branch = document.getElementById('branch').value;
        var fName = document.getElementById('first-name').value;
        var lName = document.getElementById('last-name').value;
        var contact = document.getElementById('contact-number').value;
        var email = document.getElementById('email-address').value;
        var purpose = document.getElementById('purpose').value;

        var company = "none";
        var govId = "none";

        var companyElement = document.getElementById("affiliated-company");
        var govIdElement = document.getElementById("government-ID");

        if(companyElement && govIdElement) {
            company = companyElement.value;
            govId = govIdElement.value;
        } 

        $.ajax({
			url: "../../includes/schedule.php",
			type: "POST",
			data: {
				officeCode: officeId,
				timeCode: slctTimeSlt				
			},
			cache: false,
			success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    JSON.stringify(dataResult);
					// Lacks catch if db fails
                    var loadedofficeValue = dataResult.officeValue;
                    var loadedtimeValue = dataResult.timeValue;

                    document.getElementById('sched-time').innerHTML = String(loadedtimeValue);
                    document.getElementById('visitor-office').innerHTML = String(loadedofficeValue);
			}
		});

        // For Date Formatting
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

        document.getElementById('visitor-fname').innerHTML = fName + " " + lName;
        document.getElementById('visitor-contact').innerHTML = contact;
        
        document.getElementById('visitor-branch').innerHTML = branch;

        if(companyElement && govIdElement) {
            document.getElementById('visitor-govId').innerHTML = govId;
            document.getElementById('visitor-email-com').innerHTML = company;
        } else {
            document.getElementById('visitor-email-com').innerHTML = email;
        }
        
        document.getElementById('sched-date').innerHTML = new Date(slctDate).toLocaleDateString("en-US", options);
        
        document.getElementById('sched-purpose').innerHTML = purpose;
        
        event.preventDefault();
        slidePage.style.marginLeft = "-50%";
        bullet[current - 1].classList.add("active");
        progressCheck[current - 1].classList.add("active");
        current += 1;
    }
});

submitBtn.addEventListener("click", function() {
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    current += 1;

    var officeId = document.getElementById('Office').value;
    var branch = document.getElementById('branch').value;
    var purpose = document.getElementById('purpose').value;
    
    // Confirm Appointment
    $.ajax({ 
        url: "../../includes/sub-appointment.php",
        type: "POST",
        data: {
            branch: branch,
            officeId: officeId,
            date: slctDate,
            purpose: purpose,	
            time: slctTimeSlt			
        },
        cache: false,
        success: function(dataResult){
            var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    // Insert JS Form Validation
                    window.location.replace("../your-appointment.php");
                }
                else if(dataResult.statusCode==201){
                   alert("Error occured !"); // Error Page
                }
            }
    });
});
prevBtnSec.addEventListener("click", function(event) {
    event.preventDefault();
    slidePage.style.marginLeft = "0%";
    bullet[current - 2].classList.remove("active");
    progressCheck[current - 2].classList.remove("active");
    current -= 1;
});
prevBtnThird.addEventListener("click", function(event) {
    event.preventDefault();
    slidePage.style.marginLeft = "-25%";
    bullet[current - 2].classList.remove("active");
    progressCheck[current - 2].classList.remove("active");
    current -= 1;
});

// Fuctions

function load_timeslot(tmslot) {
    var timeButton = document.getElementById(tmslot);
    if(slctTimeSlt == tmslot) {
        slctTimeSlt = null;

        timeButton.style.backgroundColor = "white"; // SET THE SELECTED BUTTON TO UNHOLD
        timeButton.style.color = "#00b050";
    } else if(slctTimeSlt == null) {
        slctTimeSlt = tmslot;

        timeButton.style.backgroundColor = "#00b050"; // SET THE SELECTED BUTTON TO HOLD
        timeButton.style.color = "white";

    } else {
        slctTimeSlt = tmslot;

        timeButton.style.backgroundColor = "#00b050"; // SET THE SELECTED BUTTON TO HOLD
        timeButton.style.color = "white";

        prevTimeButton.style.backgroundColor = "white"; // SET THE PREVIOUS SELECTED BUTTON TO UNHOLD
        prevTimeButton.style.color = "#00b050";
    }
    prevTimeButton = timeButton;
}
function validateEmail(value) {
    var input = document.createElement('input');
  
    input.type = 'email';
    input.required = true;
    input.value = value;
  
    return typeof input.checkValidity === 'function' ? input.checkValidity() : /\S+@\S+\.\S+/.test(value);
}