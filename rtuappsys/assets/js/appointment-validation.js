// Input Fields
const purpose = document.getElementById('purpose');
const first_name = document.getElementById('first-name');
const last_name = document.getElementById('last-name');
const contact_number = document.getElementById('contact-number');
const affiliated_company = document.getElementById('affiliated-company');
const email_address = document.getElementById('email-address');
const governmentID = document.getElementById('government-ID');

// Error Labels
const error_purpose = document.getElementById('error-purpose');
const error_first_name = document.getElementById('error-first-name');
const error_last_name = document.getElementById('error-last-name');
const error_contact_number = document.getElementById('error-contact-number');
const error_affiliated_company = document.getElementById('error-affiliated-company');
const error_email_address = document.getElementById('error-email-address');
const error_governmentID = document.getElementById('error-government-ID');

var wordRegex = /^[a-zA-Z ]*$/;
var word2Regex = /^[A-Za-z0-9\-\_]*$/;
var word3Regex = /^[A-Za-z0-9\-.' \_]*$/;
var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
var numberRegex = /^[0-9-+]*$/;

function isFormValidated() {
    return isPurposeValid() && isFirstNameValid() && isLastNameValid() && isContactValid() && isCompanyValid() && isEmailValid() && isGovermentIdValid();
}
function isPurposeValid() {
    if(purpose.value == null || purpose.value == ''){
        error_purpose.textContent = "Please fill up this field";
    } else {
        error_purpose.textContent = "";
        return true;
    }
    return false;
}

function isFirstNameValid() {
    if(first_name.value == null || first_name.value == ''){
        error_first_name.textContent = "Please fill up this field";
    } else if (!first_name.value.match(wordRegex) || first_name.value.length < 2){
        error_first_name.textContent = "Invalid First Name";
    } else{
        error_first_name.textContent ="";
        return true;
    }
    return false;
}

function isLastNameValid() {
    if(last_name.value == null || last_name.value == ''){
        error_last_name.textContent = "Please fill up this field";
    } else if (!last_name.value.match(wordRegex) || last_name.value.length < 2){
        error_last_name.textContent = "Invalid Last Name";
    } else{
        error_last_name.textContent="";
        return true;
    }
    return false;
}

function isContactValid() {
    if(contact_number.value == null || contact_number.value == ''){
        error_contact_number.textContent = "Please fill up this field";
    } else if (!contact_number.value.match(numberRegex) || contact_number.value.length > 15 || contact_number.value.length < 6){
        error_contact_number.textContent = "Invalid Contact Number";
    } else{
        error_contact_number.textContent="";
        return true;
    }
    return false;
}

function isCompanyValid() {
    if(affiliated_company) {
        if(affiliated_company.value == null || affiliated_company.value == ''){
            error_affiliated_company.textContent = "Please fill up this field";
        } else if (!affiliated_company.value.match(word3Regex) || affiliated_company.value.length < 2){
            error_affiliated_company.textContent = "Invalid Company Name";
        } else{
            error_affiliated_company.textContent="";
            return true;
        }
        return false;
    }
    return true;
}

function isEmailValid() {
    if(email_address.value == null || email_address.value == ''){
        error_email_address.textContent = "Please fill up this field";
    } else if (!email_address.value.match(emailRegex) || email_address.value.length < 2){
        error_email_address.textContent = "Invalid Email Address";
    } else {
        if(error_email_address) {
            error_email_address.textContent="";
        }
        return true;
    }
    return false;
}

function isGovermentIdValid() {
    if(governmentID) {
        if(governmentID.value == null || governmentID.value == ''){
            error_governmentID.textContent = "Please fill up this field";
        } else if (!governmentID.value.match(word2Regex) || governmentID.value.length < 2){
            error_governmentID.textContent = "Invalid Governement ID";
        } else{
            error_governmentID.textContent="";
            return true;
        }
        return false;
    }
    return true;
}

purpose.addEventListener("keyup", function(event){
    isPurposeValid();
});

first_name.addEventListener("keyup", function(event){
    isFirstNameValid();
});

last_name.addEventListener("keyup", function(event){
    isLastNameValid();
});

contact_number.addEventListener("keyup", function(event){
    isContactValid();
});

if(affiliated_company) {
    affiliated_company.addEventListener("keyup", function(event){
        isCompanyValid();
    });
}

email_address.addEventListener("keyup", function(event){
    isEmailValid();
});

if(governmentID) {
    governmentID.addEventListener("keyup", function(event){
        isGovermentIdValid();
    });
}
