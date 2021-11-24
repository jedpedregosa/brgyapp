// Settings button
let btn_settings = document.getElementById("settings");
let btn_uname = document.getElementById("btn_user");
let btn_pword = document.getElementById("btn_pword");

let btn_edit = document.getElementById("btn_edit");
let btn_cancel = document.getElementById("btn_cancel");
let btn_save = document.getElementById("btn_save");

// Forms
let frm_uname = document.getElementById("frm_user");
let frm_pword = document.getElementById("frm_pword");
let frm_acc = document.getElementById("frm_acc");

// Validation Message
let valmsg_uname = document.getElementById("uname-msg");

// Fields
let txt_uname = document.getElementById("txtUsername");

// Form Fields
let txt_fname = document.getElementById("Fname");
let txt_mname = document.getElementById("Mname");
let txt_lname = document.getElementById("Lname");
let txt_sffx = document.getElementById("Suffix");
let txt_civ = document.getElementById("CivStat");
let txt_ctzn = document.getElementById("Ctznshp");
let txt_bday = document.getElementById("Bdate");
let txt_sex = document.getElementById("Sex");
let txt_hnum = document.getElementById("HouseNum");
let txt_stname = document.getElementById("StName");
let txt_cntct = document.getElementById("Contact");
let txt_email = document.getElementById("Email");
let txt_fbname = document.getElementById("FbName");
let txt_voter = document.getElementById("Voter");

var isUsername_valid = false;
var isPhone_valid = false;
var isEmail_valid = false;
var onEditStatus = false;

btn_save.onclick = function () {
    var tmpSubmit = document.createElement('button');
    frm_acc.appendChild(tmpSubmit);
    tmpSubmit.click();
    frm_acc.removeChild(tmpSubmit);
}

if(!onEditStatus) {
    btn_save.style.display = 'none';
}

btn_edit.onclick = function () {
    txt_fname.readOnly = false;
    txt_mname.readOnly = false;
    txt_lname.readOnly = false;
    txt_sffx.readOnly = false;
    txt_civ.disabled = false;
    txt_ctzn.readOnly = false;
    txt_bday.readOnly = false;
    txt_sex.disabled = false;
    txt_hnum.readOnly = false;
    txt_stname.disabled = false;
    txt_cntct.readOnly = false;
    txt_email.readOnly = false;
    txt_fbname.readOnly = false;
    txt_voter.readOnly = false;
    onEditStatus = true;
    btn_save.style.display = 'inline-block';
    this.style.display = 'none';
}

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

function validateUsername(value, type) {
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
                    switch(type) {
                        case 'a':
                            isPhone_valid = true;
                            valmsg_cntct.innerHTML = "";
                            break;
                        case 'b':
                            isUsername_valid = true;
                            valmsg_uname.innerHTML = "";
                            break;
                        case 'c':
                            isEmail_valid = true;
                            valmsg_email.innerHTML = "";
                            break;
                        default:
                    }
                } else {
                    switch(type) {
                        case 'a':
                            isPhone_valid = false;
                            valmsg_cntct.innerHTML += "Please enter another contact number. ";
                            break;
                        case 'b':
                            isUsername_valid = false;
                            valmsg_uname.innerHTML += "This username is not available. ";
                            break;
                        case 'c':
                            isEmail_valid = false;
                            valmsg_email.innerHTML += "This email is not available. ";
                            break;
                        default:
                    }
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