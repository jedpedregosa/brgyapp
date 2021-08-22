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
        // Check schedules for the selected office, then continue to next page.
		$.ajax({
			url: "../../requests/load-dates",
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
                showAlertServerError();
                $("#screen-overlay").fadeOut(400);
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
            $("#screen-overlay").fadeOut(400);
        }); //Lacks Catch
	} else if(branch == null) {
        Fnon.Alert.Warning({
            message: 'Please select a campus.',
            title: 'Selected Campus',
            btnOkText: 'Okay',
            btnOkColor: 'White',
            btnOkBackground: '#002060',
            fontFamily: 'Poppins, sans-serif'
        });
    } else if(officeId == null) {
        Fnon.Alert.Warning({
            message: 'Please select an office.',
            title: 'Selected Office',
            btnOkText: 'Okay',
            btnOkColor: 'White',
            btnOkBackground: '#002060',
            fontFamily: 'Poppins, sans-serif'
        });
    } else {
        showValidationError();
    }
});
nextBtnSec.addEventListener("click", function(event) {
    slctDate = slctdDate.text;
    if(slctDate == null) { // If User selected a schedule (both time & day)
        // No proper schedule selected
        Fnon.Alert.Warning({
            message: 'Please select a date for your appointment.',
            title: 'Selected Date',
            btnOkText: 'Okay',
            btnOkColor: 'White',
            btnOkBackground: '#002060',
            fontFamily: 'Poppins, sans-serif'
        });
    } else if(slctTimeSlt == null) {
        Fnon.Alert.Warning({
            message: 'Please select a time for your appointment.',
            title: 'Selected Timeslot',
            btnOkText: 'Okay',
            btnOkColor: 'White',
            btnOkBackground: '#002060',
            fontFamily: 'Poppins, sans-serif'
        });
    } else if(!isValidated()){
        showValidationError();
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
			url: "../../requests/schedule",
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
                showAlertServerError();
                $("#screen-overlay").fadeOut(400);
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
			url: "../../requests/schedule",
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
                showAlertServerError();
                $("#screen-overlay").fadeOut(400);
                isSuccess = false;
            }
		}).done(function (dataResult) {
            var dataResult = JSON.parse(dataResult);
            if(dataResult.statusCode==200){
            }
            else if(dataResult.statusCode==201){
                showSchedNotAvailableError();
                isSuccess = false;
            } else if(dataResult.statusCode==202) {
                window.location.replace("../rtuappsys");
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
    var isChecked = document.getElementById("agreement").checked;

    if(slctTimeSlt == null || slctDate == null) { // If User selected a schedule (both time & day)
        // No proper schedule selected
        Fnon.Alert.Warning({
            message: 'You have not selected your schedule yet.',
            title: 'Selected Schedule',
            btnOkText: 'Okay',
            btnOkColor: 'White',
            btnOkBackground: '#002060',
            fontFamily: 'Poppins, sans-serif'
        });
    } else if(!isValidated()){
        showValidationError();
    } else if(!isChecked) {
        Fnon.Alert.Warning({
            message: 'To continue, please confirm below that you are giving <strong>Rizal Technological University</strong> the consent' + 
            ' to collect and process your data.',
            title: 'Please Confirm',
            btnOkText: 'Okay',
            btnOkColor: 'White',
            btnOkBackground: '#002060',
            fontFamily: 'Poppins, sans-serif'
        });
    }else { // Resubmit personal information & Confirm Appointment
        var lname = $('#last-name').val();
        var fname = $('#first-name').val();
        var email = $('#email-address').val();
        var phone = $('#contact-number').val();
        var company = $('#affiliated-company').val();
        var govId = $('#government-ID').val();

        var isSuccess = true;

        // Register the personal information
        $.ajax({
            url: "../../requests/reg-appointment",
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
                showAlertServerError();
                $("#screen-overlay").fadeOut(400);
                isSuccess = false;
            }
            }).done(function (dataResult) {
                var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){ // Continue to submit appointment
                        if(isSuccess) {
                            $.ajax({ 
                                url: "../../requests/sub-appointment",
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
                                    isSuccess = false;
                                    showAlertServerError();
                                    $("#screen-overlay").fadeOut(400);
                                }
                            }).done(function (appResult) {
                                    var appResult = JSON.parse(appResult);
                                    if(appResult.statusCode==200){
                                        // Insert JS Form Validation
                                        window.location.replace("../your-appointment");
                                    } else if(appResult.statusCode==201){
                                        showInternalError();
                                        $("#screen-overlay").fadeOut(400);
                                    } else {
                                        showSchedNotAvailableError();
                                        $("#screen-overlay").fadeOut(400);
                                    }
                                    
                            });
                        }
                    } else if(dataResult.statusCode==201){
                        showAlertServerError();
                        $("#screen-overlay").fadeOut(400);
                    } else if(dataResult.statusCode==202) {
                        showIdNotAvailableError();
                        isSuccess = false;
                        $("#screen-overlay").fadeOut(400);
                    } else {
                        showEmailNotAvailableError();
                        $("#screen-overlay").fadeOut(400);
                    }
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
    
    let off_wait = document.getElementById('off-wait');
    let off_none = document.getElementById('off-none');

    if(branch != "") {
        $.ajax({
            url: "../../requests/load-offices",
            type: "POST",
            data: {
                branch: branch,
            },
            cache: false,
            beforeSend: function(){
                var opt = document.createElement('option');
                opt.disabled = true;
                opt.selected = true;
                opt.hidden = true;
                opt.innerHTML = "Please wait...";
                office_select.appendChild(opt);
                office_select.disabled = true;
            },
            error: function() {
                showAlertServerError();
            },
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);

            }
        }).done(function(dataResult) {
            office_select.innerHTML = "";
            
            var available_offices = JSON.parse(dataResult);

            if(available_offices.length > 0) {
                for(let i = 0; i < available_offices.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = available_offices[i][0];
                    opt.innerHTML = available_offices[i][1];
                    office_select.appendChild(opt);
                    office_select.disabled = false;
                }
            } else {
                var opt = document.createElement('option');
                opt.disabled = true;
                opt.selected = true;
                opt.hidden = true;
                opt.innerHTML = "No Office Available";
                office_select.appendChild(opt);
                office_select.disabled = true;
            }
        });
    }
}

function showAlertServerError() {
    Fnon.Alert.Danger({
        message: 'The are seem to be a server error. Please try again later or contact RTU.',
        title: 'Server Error',
        btnOkText: 'Okay',
        titleColor: 'White',
        fontFamily: 'Poppins, sans-serif'
    });
}

function showSchedNotAvailableError() {
    Fnon.Alert.Warning({
        message: 'Your schedule is not available anymore, please select another schedule.',
		title: 'Unfortunately,',
		btnOkText: 'Okay',
        titleBackground: '#002060',
		titleColor: 'White',
		fontFamily: 'Poppins, sans-serif'
    });
}

function showEmailNotAvailableError() {
    Fnon.Alert.Warning({
        message: 'This email is currently used in an appointment, please use another email.',
		title: 'Unfortunately,',
		btnOkText: 'Okay',
        titleBackground: '#002060',
		titleColor: 'White',
		fontFamily: 'Poppins, sans-serif'
    });
}

function showInternalError() {
    Fnon.Alert.Danger({
        message: 'An error occured, please try again later.',
		title: 'We\'re Sorry',
		btnOkText: 'Okay',
		titleColor: 'White',
		fontFamily: 'Poppins, sans-serif'
    });
}

function showValidationError() {
    Fnon.Alert.Warning({
        message: 'Please fill-up all the required information.',
		title: 'Your Information',
		btnOkText: 'Okay',
        titleBackground: '#002060',
		titleColor: 'White',
		fontFamily: 'Poppins, sans-serif'
    });
}

function showIdNotAvailableError() {
    Fnon.Alert.Warning({
        message: 'Your information has an appointment already.',
		title: 'Unfortunately,',
		btnOkText: 'Okay',
        titleBackground: '#002060',
		titleColor: 'White',
		fontFamily: 'Poppins, sans-serif'
    });
}
