// RTU APPOINTMENT SYSTEM

// Intialization
var slctTimeSlt = null;
var slctDate = null;
var prevTimeButton;
var timeButton;

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

function isValidated() {
    var officeId = $('#Office').val();
    var branch = $('#branch').val();
    
    return isFormValidated() && officeId != null && branch != null;
}

nextBtnFirst.addEventListener("click", function(event) {

    
    // Submit to db
    var lname = $('#last-name').val();
    var fname = $('#first-name').val();
    var email = $('#email-address').val();
    var phone = $('#contact-number').val();
    var company = $('#affiliated-company').val();
    var govId = $('#government-ID').val();
    var officeId = $('#Office').val();
    var branch = $('#branch').val();

    var isSuccess = true;

    if(isValidated()) {

        // Check if email is under an appointment
        $.ajax({
            url: "../../includes/chk-email.php",
            type: "POST",
            data: {
                email: email
            },
            cache: false,
            beforeSend: function() {
                $("#screen-overlay").fadeIn(100);
            },
            success: function(dataResult){
            },
            error: function() {
                alert('There might be some problem in the server, please try again later or contact RTU.');
                isSuccess = false;
            }
        }).done(function (dataResult) {
            var dataResult = JSON.parse(dataResult);
                if(dataResult.hasEmail == 200){
                    alert('This email is already registered to an appointment');
                    isSuccess = false;
                } 
            $("#screen-overlay").fadeOut(400);
        });
    
        // Register the personal information
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
            beforeSend: function() {
                $("#screen-overlay").fadeIn(100);
            },
            success: function(dataResult){
    
            },
            error: function() {
                alert('There might be some problem in the server, please try again later or contact RTU.');
                isSuccess = false;
            }
            }).done(function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                        // Insert JS Form Validation
                    } else if(dataResult.statusCode==201){
                       alert("Error occured!"); // Error Page
                    } else if(dataResult.statusCode==202) {
                        isSuccess = false;
                        alert("Email Taken");
                        
                    }
                $("#screen-overlay").fadeOut(400);
            });

        // Check schedules for the selected office, then continue to next page.
		$.ajax({
			url: "../../includes/load-dates.php",
			type: "POST",
			data: {
				officeCode: officeId
			},
			cache: false,
            beforeSend: function() {
                $("#screen-overlay").fadeIn(100);
            },
			success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
			},
            error: function() {
                alert('There might be some problem in the server, please try again later or contact RTU.');
                isSuccess = false;
            }
		}).done(function(dataResult) {
            if(isSuccess) {
                available_dates = JSON.parse(dataResult);

                event.preventDefault();
                slidePage.style.marginLeft = "-25%";
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                current += 1;

                $("#screen-overlay").fadeOut(400);

                setSlctdDate(available_dates[0]);
                startCalendar();
            }   
        }); //Lacks Catch
	} else if(branch == null && officeId == null) {
        alert('Please select a branch and an office.');
    }
});
nextBtnSec.addEventListener("click", function(event) {
    slctDate = slctdDate.text;
    if(slctTimeSlt == null || slctDate == null) { // If User selected a schedule (both time & day)
        // No proper schedule selected
        alert('Please select your appointment schedule.');
    } else if(!isValidated()){
        alert('Please fill-up all the required information.');
    } else {
        var officeId = document.getElementById('Office').value;
        var branch = document.getElementById('branch').value;
        var fName = document.getElementById('first-name').value;
        var lName = document.getElementById('last-name').value;
        var contact = document.getElementById('contact-number').value;
        var email = document.getElementById('email-address').value;
        var purpose = document.getElementById('purpose').value;

        var isSuccess = true;

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
            beforeSend: function() {
                $("#screen-overlay").fadeIn(100);
            },
			success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    JSON.stringify(dataResult);
					// Lacks catch if db fails
                    var loadedofficeValue = dataResult.officeValue;
                    var loadedtimeValue = dataResult.timeValue;

                    document.getElementById('sched-time').innerHTML = String(loadedtimeValue);
                    document.getElementById('visitor-office').innerHTML = String(loadedofficeValue);
			},
            error: function() {
                alert('There might be some problem in the server, please try again later or contact RTU.');
                isSuccess = false;
            }
		}).done(function () {
            $("#screen-overlay").fadeOut(400);
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

        $.ajax({
			url: "../../includes/schedule.php",
			type: "POST",
			data: {
				officeCode: officeId,
				timeCode: slctTimeSlt,
                slctDate: slctDate			
			},
			cache: false,
            beforeSend: function() {
                $("#screen-overlay").fadeIn(100);
            },
			success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
			},
            error: function() {
                alert('There might be some problem in the server, please try again later or contact RTU.');
                isSuccess = false;
            }
		}).done(function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            if(dataResult.statusCode==200){
            }
            else if(dataResult.statusCode==201){
               alert("Please select another schedule");
               isSuccess = false;
            } else if(dataResult.statusCode==202) {
                window.location.replace("../rtuappsys.php");
            }
            $("#screen-overlay").fadeOut(400);
            if(isSuccess) {
                event.preventDefault();
                slidePage.style.marginLeft = "-50%";
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                current += 1;
            }
        });
    }
});

submitBtn.addEventListener("click", function() {

    if(current < 3) {
        bullet[current - 1].classList.add("active");
        progressCheck[current - 1].classList.add("active");
        current += 1;
    }

    var officeId = document.getElementById('Office').value;
    var branch = document.getElementById('branch').value;
    var purpose = document.getElementById('purpose').value;

    if(slctTimeSlt == null || slctDate == null) { // If User selected a schedule (both time & day)
        // No proper schedule selected
        alert('Please select your appointment schedule.');
    } else if(!isValidated()){
        alert('Please fill-up all the required information.');
    } else { // Resubmit personal information & Confirm Appointment
        var lname = $('#last-name').val();
        var fname = $('#first-name').val();
        var email = $('#email-address').val();
        var phone = $('#contact-number').val();
        var company = $('#affiliated-company').val();
        var govId = $('#government-ID').val();

        var isSuccess = true;

        // Check if email is under an appointment
        $.ajax({
            url: "../../includes/chk-email.php",
            type: "POST",
            data: {
                email: email
            },
            cache: false,
            beforeSend: function() {
                $("#screen-overlay").fadeIn(100);
            },
            success: function(dataResult){
            },
            error: function() {
                alert('There might be some problem in the server, please try again later or contact RTU.');
                isSuccess = false;
            }
        }).done(function (dataResult) {
            var dataResult = JSON.parse(dataResult);
                if(dataResult.hasEmail == 200){
                    alert('This email is already registered to an appointment');
                    isSuccess = false;
                } 
            $("#screen-overlay").fadeOut(400);
        });

        // Register the personal information
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
            beforeSend: function() {
                $("#screen-overlay").fadeIn(100);
            },
            success: function(dataResult){

            },
            error: function() {
                alert('There might be some problem in the server, please try again later or contact RTU.');
                isSuccess = false;
            }
            }).done(function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){ // Continue to submit appointment
                        if(isSuccess) {
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
                                beforeSend: function() {
                                    $("#screen-overlay").fadeIn(100);
                                },
                                success: function(appResult){
                                },
                                error: function() {
                                    alert('There might be some problem in the server, please try again later or contact RTU.');
                                    $("#screen-overlay").fadeOut(400);
                                }
                            }).done(function (appResult) {
                                    var appResult = JSON.parse(appResult);
                                    if(appResult.statusCode==200){
                                        // Insert JS Form Validation
                                        window.location.replace("../your-appointment.php");
                                    } else if(appResult.statusCode==201){
                                        alert("Error occured !"); // Error Page
                                        $("#screen-overlay").fadeOut(400);
                                    } else {
                                        alert("Your selected schedule is not available.");
                                        $("#screen-overlay").fadeOut(400);
                                    }
                                    
                            });
                        }
                    } else if(dataResult.statusCode==201){
                        alert("Error occured!"); // Error Page
                    } else if(dataResult.statusCode==202) {
                        isSuccess = false;
                        alert("Email Taken");
                    }
                $("#screen-overlay").fadeOut(400);
            });
    }
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
    timeButton = document.getElementById(tmslot);
    if(slctTimeSlt == tmslot) {
        slctTimeSlt = null;

        timeButton.style.backgroundColor = "white"; // SET THE SELECTED BUTTON TO UNHOLD
        timeButton.style.color = "#002060";

        timeButton.style.backgroundColor = ''; // SET THE SELECTED BUTTON TO UNHOLD
        timeButton.style.color = '';
    } else if(slctTimeSlt == null) {
        slctTimeSlt = tmslot;

        timeButton.style.backgroundColor = "#002060"; // SET THE SELECTED BUTTON TO HOLD
        timeButton.style.color = "white";

    } else {
        slctTimeSlt = tmslot;

        timeButton.style.backgroundColor = "#002060"; // SET THE SELECTED BUTTON TO HOLD
        timeButton.style.color = "white";

        prevTimeButton.style.backgroundColor = ''; // SET THE PREVIOUS SELECTED BUTTON TO UNHOLD
        prevTimeButton.style.color = '';
    }
    prevTimeButton = timeButton;
}

function loadOffices() {
    var branch = document.getElementById('branch').value;
    var office_select = document.getElementById('Office');

    office_select.innerHTML = "";
    
    if(branch != "") {
        $.ajax({
            url: "../../includes/load-offices.php",
            type: "POST",
            data: {
                branch: branch,
            },
            cache: false,
            beforeSend: function(){

            },
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
            }
        }).done(function(dataResult) {
            var available_offices = JSON.parse(dataResult);

            for(let i = 0; i < available_offices.length; i++) {
                var opt = document.createElement('option');
                opt.value = available_offices[i][0];
                opt.innerHTML = available_offices[i][1];
                office_select.appendChild(opt);
                office_select.disabled = false;
            }
        });
    }
}