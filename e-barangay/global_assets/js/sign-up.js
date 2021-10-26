// File Upload Checklists
let chck_id = document.getElementById("chck_idcard");
let chck_sf = document.getElementById("chck_selfie");
let chck_sg = document.getElementById("chck_sig");

// Upload Inputs
let uload_id = document.getElementById("upload_idcard");
let uload_sf = document.getElementById("upload_selfie");
let uload_sg = document.getElementById("upload_sig");
let uload_dp = document.getElementById("upload_dp");

// Upload Button
let uload_btn = document.getElementById("upload_button");

// Validate Message
let valmsg_file = document.getElementById("file-upload-msg");
let valmsg_dp = document.getElementById("dp-upload-msg");

let valmsg_uname = document.getElementById("uname-msg");
let valmsg_email = document.getElementById("email-msg");
let valmsg_cntct = document.getElementById("cntct-msg");

var uload_btn_names = ["ID (Front & Back)", "Selfie", "Specimen Signature"];
var all_uploads = [uload_id, uload_sf, uload_sg];
var checklist = [chck_id, chck_sf, chck_sg];

var isPhone_valid = false;
var isUsername_valid = false;
var isEmail_valid = false;

renderUpload();

function uploadClick() {
    for(let i = 0; i < all_uploads.length; ++i) {
        if(all_uploads[i].files.length == 0) {
            all_uploads[i].click();
            break;
        }
    }
}

function checkUpload(file_upload) {
    const file = file_upload.value;
    valmsg_file.innerHTML = "";
    
    if(file == "") {
        valmsg_file.innerHTML += "This file is required.";
    } else if(!fileValidator(file)) {
        valmsg_file.innerHTML += "This only accepts .png and .jpg files. ";
        file_upload.value = "";
    } else if(!fileSizeValidator(file_upload)) {
        valmsg_file.innerHTML += "Maximum file size is 10 MB. ";
        file_upload.value = "";
    } else {
        valmsg_file.innerHTML = "";
        renderUpload();

        return true;
    }

    return false;
}

function checkDpUpload() {
    const file = uload_dp.value;
    valmsg_dp.innerHTML = "";

    if(file == "") {
        valmsg_dp.innerHTML += "This file is required.";
    } else if(!fileValidator(file)) {
        valmsg_dp.innerHTML += "This only accepts .png and .jpg files. ";
        uload_dp.value = "";
    } else if(!fileSizeValidator(uload_dp)) {
        valmsg_dp.innerHTML += "Maximum file size is 10 MB. ";
        uload_dp.value = "";
    } else {
        valmsg_dp.innerHTML = "";
        document.getElementById("uploaded_dp").src = window.URL.createObjectURL(uload_dp.files[0]);

        return true;
    }

    document.getElementById("uploaded_dp").src = "../global_assets/img/blank-profile.png";
    return false;
}

function renderUpload() {
    var isButtonRendered = false;

    for(let i = 0; i < all_uploads.length; ++i) {
        if(all_uploads[i].files.length == 0) {
            if(!isButtonRendered) {
                uload_btn.style.display = "block";
                uload_btn.value = "Upload " + uload_btn_names[i];

                isButtonRendered = true;
            }
        } else {
            checklist[i].checked = true;
            checklist[i].disabled = false;
        }
    }

    if(!isButtonRendered) {
        uload_btn.style.display = "none";
    }
}

function renderChecklist() {
    for(let i = 0; i < checklist.length; ++i) {
        if(!checklist[i].checked) {
            all_uploads[i].value = "";
            checklist[i].disabled = true;
        }
    }
    renderUpload();
}

function fileValidator(file_upload) {
    var allowed_extensions = new Array("jpg","png");

    // Split function will split the filename by dot(.), and pop function will pop the last element from the array 
    // which will give you the extension as well. If there will be no extension then it will return the filename.
    var file_extension = file_upload.split('.').pop().toLowerCase(); 

    for(var i = 0; i <= allowed_extensions.length; i++) {
        if(allowed_extensions[i]==file_extension) {
            return true; // valid file extension
        }
    }

    return false;
}

function fileSizeValidator(file_upload) {
    const fileSize = file_upload.files[0].size / 1024 / 1024;
    if(fileSize > 10) {
        return false;
    }

    return true;
}

function validateAllUploads() {
    for(let i = 0; i < all_uploads.length; ++i) {
        if(!checkUpload(all_uploads[i])) {
            return false;
        }
    }

    return true;
}

let modal_password = document.getElementById("assign_password");

function submitAccount() {
    if(checkDpUpload() && validateAllUploads()) {
        if(!isPhone_valid) {
            valmsg_cntct.innerHTML = "Your contact number is invalid.";
        } else if(!isEmail_valid) {
            valmsg_email.innerHTML = "Your email is invalid.";
        } else {
            openModal("assign_password");
        }   
    }
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

function isUsernameValidated() {
    let Uname = document.getElementById("txtUsername").value;
    let cUname = document.getElementById("txtConUsername").value;

    if(Uname.length < 7) {
        valmsg_uname.innerHTML = "Username length must be greater than 6 characters. ";
        return false;
    } else if(!isUsername_valid) {
        valmsg_uname.innerHTML = "This username is not available. ";
        return false;
    } else if(Uname != cUname) {
        valmsg_uname.innerHTML = "Confirm username does not match. ";
        return false;
    } else {
        valmsg_uname.innerHTML = "";
        return true;
    }
    
    
}

function validateUsername(value, type) {
    $.ajax({
        url: "controllers/api/check-account",
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

function submitForm() {
    let formAccount = document.getElementById('frmAcc');

    if(isUsernameValidated() && isPasswordValidated() && isUsername_valid) {
        if(checkDpUpload() && validateAllUploads()) {
            
            var tmpSubmit = document.createElement('button');
            formAccount.appendChild(tmpSubmit);
            tmpSubmit.click();
            formAccount.removeChild(tmpSubmit);
        }
        closeModal("assign_password");
    } 
}

// When the user clicks on the button, open the modal
function openModal(modal) {
    document.getElementById(modal).style.display = "block";
}

// When the user clicks on <span> (x), close the modal
function closeModal(modal) {
    document.getElementById(modal).style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if(event.target == modal_password) {
        modal_password.style.display = "none";
    }
}