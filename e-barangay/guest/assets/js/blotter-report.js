// Upload Input
let uload_id = document.getElementById("idfile");
let chck_id = document.getElementById("chckup");

// Upload Button
let uload_btn = document.getElementById("upload_button");

// Validate Message
let valmsg_file = document.getElementById("file-upload-msg");

uload_id.onchange = function () {
    if(checkUpload(this)) {
        chck_id.checked = true;
        chck_id.disabled = false;
        uload_btn.style.display = "none";
    }
}

chck_id.onchange = function () {
    uload_btn.style.display = "block";
    uload_id.value = "";
    chck_id.disabled = true;
}

function submitAccount() {
    if(checkUpload(uload_id)) {
        let form = document.getElementById("frmBlotter");
        var tmpSubmit = document.createElement('button');
        form.appendChild(tmpSubmit);
        tmpSubmit.click();
        form.removeChild(tmpSubmit);
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

