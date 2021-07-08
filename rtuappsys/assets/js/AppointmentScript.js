// RTU APPOINTMENT SYSTEM

// Intialization
var slctTimeSlt = null;
var slctDate = null;

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
		
    if(lname!="" && fname!="" && phone!="" && email!=""){
		$.ajax({
			url: "../../includes/reg-appointment.php",
			type: "POST",
			data: {
				lname: lname,
				email: email,
				phone: phone,
				fname: fname				
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
					}
				}
			});
		}
});
nextBtnSec.addEventListener("click", function(event) {
    slctDate = slctdDate.text;
    if(slctTimeSlt == null || slctDate == null) { // If User selected a schedule (both time & day)
        var alertDate = document.getElementById('alertSelectSched');
        alertDate.style.display = 'block';
    } else {
        var officeId = document.getElementById('Office').value;
        var branch = document.getElementById('branch').value;
        var studNo = document.getElementById('student-number').value;
        var fName = document.getElementById('first-name').value;
        var lName = document.getElementById('last-name').value;
        var contact = document.getElementById('contact-number').value;
        var email = document.getElementById('email-address').value;
        var govID = document.getElementById('government-ID').value;
        var purpose = document.getElementById('purpose').value;

        document.getElementById('resStudno').innerHTML = studNo;
        document.getElementById('resFname').innerHTML = lName + " " + fName;
        document.getElementById('resContact').innerHTML = contact;
        document.getElementById('resEmail').innerHTML = email;
        document.getElementById('resBranch').innerHTML = branch;
        document.getElementById('resGovId').innerHTML = govID;
        document.getElementById('resDate').innerHTML = slctDate;
        document.getElementById('resTime').innerHTML = slctTimeSlt;
        document.getElementById('resOffice').innerHTML = officeId;
        document.getElementById('resPurpose').innerHTML = purpose;
        
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
    if(slctTimeSlt == tmslot) {
        slctTimeSlt = null;
    } else {
        slctTimeSlt = tmslot;
    }
}