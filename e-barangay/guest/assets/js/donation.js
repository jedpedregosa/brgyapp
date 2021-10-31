
let donation_type = document.getElementById("slct_donation");
let file_upload = document.getElementById("filePay");
let valmsg_file = document.getElementById("don-upload-msg");
let upload_tag = document.getElementById("btn_upload");

donation_type.onchange = function () {
    if(this.value == "dntn1") {
        document.getElementById("kind-div").style.display = "block";
        document.getElementById("charity-div1").style.display = "none";
        document.getElementById("charity-div2").style.display = "none";
    } else if(this.value == "dntn2") {
        document.getElementById("charity-div1").style.display = "block";
        document.getElementById("charity-div2").style.display = "block";
        document.getElementById("kind-div").style.display = "none";
    }
}

function checkUpload(isValidation) {
    const file = file_upload.value;
    valmsg_file.innerHTML = "";
    
    upload_tag.value = file.split("\\").pop();
    if(file == "") {
        upload_tag.value = "Upload Photo";
        return true;
    } else if(!fileValidator(file)) {
        valmsg_file.innerHTML += "This only accepts .png and .jpg files. ";
        file_upload.value = "";
    } else if(!fileSizeValidator(file_upload)) {
        valmsg_file.innerHTML += "Maximum file size is 10 MB. ";
        file_upload.value = "";
    } else {
        valmsg_file.innerHTML = "";
        return true;
    }

    upload_tag.value = "Upload Photo";
    return false;
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

function submitForm() {
    let formAccount = document.getElementById('frmDonation');

    if(checkUpload()) {        
        var tmpSubmit = document.createElement('button');
        formAccount.appendChild(tmpSubmit);
        tmpSubmit.click();
        formAccount.removeChild(tmpSubmit);
    } 
}