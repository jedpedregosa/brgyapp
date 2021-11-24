// Settings button
let btn_settings = document.getElementById("settings");
let btn_uname = document.getElementById("btn_user");
let btn_pword = document.getElementById("btn_pword");

// Forms
let frm_uname = document.getElementById("frm_user");
let frm_pword = document.getElementById("frm_pword");

// Validation Message
let valmsg_uname = document.getElementById("uname-msg");

// Fields
let txt_uname = document.getElementById("txtUsername");

var isUsername_valid = false;

btn_settings.onclick = function () {
    openModal('assign_password')
}

btn_uname.onclick = function () {
    if(isUsernameValidated()) {
        var tmpSubmit = document.createElement('button');
        frm_uname.appendChild(tmpSubmit);
        tmpSubmit.click();
        frm_uname.removeChild(tmpSubmit);
    }
}

btn_pword.onclick = function () {
    if(isPasswordValidated()) {
        var tmpSubmit = document.createElement('button');
        frm_pword.appendChild(tmpSubmit);
        tmpSubmit.click();
        frm_pword.removeChild(tmpSubmit);
    }
}

function openModal(modal) {
    document.getElementById(modal).style.display = "block";
}

// When the user clicks on <span> (x), close the modal
function closeModal(modal) {
    document.getElementById(modal).style.display = "none";
}

function isPasswordValidated() {
    let nPass = document.getElementById("txtPassword").value;
    let cPass = document.getElementById("txtConPassword").value;
    let PassMsg = document.getElementById("password-msg");

    if(nPass.length < 8) {
        PassMsg.innerHTML = "Password length must be greater than 7 characters.";
        return false;
    } else if (nPass != cPass) {
        PassMsg.innerHTML = "Confirm password does not match.";
        return false;
    } else {
        PassMsg.innerHTML = "";
        return true;
    }
}

function validateUsername(value) {
    $.ajax({
        url: "../controllers/api/check-account",
        type: "POST",
        data: {
            uniq_id: value
        },
        cache: false,
        success: function(dataResult) {
            var req_result;

            try {
                req_result = JSON.parse(dataResult);

                if(req_result.res_av_status == 100) {
                    isUsername_valid = true;
                    valmsg_uname.innerHTML = "";
                            
                } else { 
                    isUsername_valid = false;
                    valmsg_uname.innerHTML += "This username is not available. ";

                }
            } catch(err) {}
        }
    })
}

function isUsernameValidated() {
    let Uname = document.getElementById("txtUsername").value;

    if(Uname.length < 7) {
        valmsg_uname.innerHTML = "Username length must be greater than 6 characters. ";
        return false;
    } else if(!isUsername_valid) {
        valmsg_uname.innerHTML = "This username is not available. ";
        return false;
    } else {
        valmsg_uname.innerHTML = "";
        return true;
    } 
}

function cardSearch() {
    var input, filter, cards, cardContainer, title, i;
    input = document.getElementById("txtSearch");
    filter = input.value.toUpperCase();
    cardContainer = document.getElementById("resident-card");

    if(cardContainer) {
        cards = cardContainer.getElementsByClassName("card");
        for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card-name");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
        }
    }
}

  