let btn_up = document.getElementById("btn_upload");

let frm = document.getElementById("frmClearance");

let chck_id = document.getElementById("chck_id");

// Validate Message
let valmsg_file = document.getElementById("file-upload-msg");
let valmsg_dp = document.getElementById("dp-upload-msg");

// Uploads
let upload_id = document.getElementById("upload_idcard");
let uload_dp = document.getElementById("upload_dp");

function submitClearance() {
    if(checkUpload(upload_id) && checkDpUpload()) {
        var tmpSubmit = document.createElement('button');
        frm.appendChild(tmpSubmit);
        tmpSubmit.click();
        frm.removeChild(tmpSubmit);
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
        chck_id.checked = true;
        btn_up.style.display = 'none';
        chck_id.disabled = false;

        return true;
    }

    return false;
}

chck_id.onchange = function () {
    if(!chck_id.checked) {
        chck_id.checked = false;
        btn_up.style.display = 'block';
        chck_id.disabled = true;
        upload_id.value = "";
    }
}

btn_up.onclick = function () {
    upload_id.click();
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

    document.getElementById("uploaded_dp").src = "../../global_assets/img/blank-profile.png";
    return false;
}

// When the user clicks on the button, open the modal
function openModal(modal) {
    document.getElementById(modal).style.display = "block";
}

// When the user clicks on <span> (x), close the modal
function closeModal(modal) {
    document.getElementById(modal).style.display = "none";
}
