// Upload messages
let msg_img = document.getElementById('uploaded_img');
let msg_file = document.getElementById('uploaded_file');
let all_file_msg = document.getElementById('all_file_msg');

// Input files
let uload_img = document.getElementById("photo_update");
let uload_file = document.getElementById("file_update");

let update_msg_area = document.getElementById("update_text_msg");

renderUpload();

function renderUpload() {
    if(uload_img.files.length == 0) {
        msg_img.style.display = "none";
    } else {
        var target = msg_img.getElementsByClassName("filename")[0];
        target.innerHTML = uload_img.value.split("\\").pop();
        msg_img.style.display = "inline-block";
    }
    
    if(uload_file.files.length == 0) {
        msg_file.style.display = "none";
    } else {
        var target = msg_file.getElementsByClassName("filename")[0];
        target.innerHTML = uload_file.value.split("\\").pop();
        msg_file.style.display = "inline-block";
    }
    

}

function checkUpload(file_upload) {
    const file = file_upload.value;
    all_file_msg.innerHTML = "";
    var val_res;

    if(file == "") {
        val_res = true;
    } else if(file_upload == uload_img) {
        if(!fileValidator(file, ["jpg", "png"])) {
            all_file_msg.innerHTML = "This image upload only accepts .jpg and .png files";
            val_res = false;
        } else if(!fileSizeValidator(file_upload, 10)) { // Max 10 MB for photos.
            all_file_msg.innerHTML = "Maximum image upload size is 10 MB.";
            val_res = false;
        } else {
            val_res = true;
        }
    } else {
        if(!fileValidator(file, ["docx", "pdf"])) {
            all_file_msg.innerHTML = "This file upload only accepts .docx and .pdf files";
            val_res = false;
        } else if(!fileSizeValidator(file_upload, 20)) {
            all_file_msg.innerHTML = "Maximum file upload size is 20 MB.";
            val_res = false;
        } else {
            val_res = true;
        }
    }

    if(!val_res) {
        file_upload.value = "";
    }

    renderUpload();
    return val_res;
}   

function fileValidator(file_upload, allowed_extensions) {
    //var allowed_extensions = new Array("jpg","png");

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

function fileSizeValidator(file_upload, maxSize) {
    const fileSize = file_upload.files[0].size / 1024 / 1024;
    if(fileSize > maxSize) {
        return false;
    }

    return true;
}

function submitForm() {
    let formAccount = document.getElementById('frmUpdate');

    if(update_msg_area.textContent != "") {
        if(checkUpload(uload_img) && checkUpload(uload_file)) {
            var tmpSubmit = document.createElement('button');
            formAccount.appendChild(tmpSubmit);
            tmpSubmit.click();
            formAccount.removeChild(tmpSubmit);
        }
    } else {
        all_file_msg.innerHTML = "Please state a message first.";
    }
}