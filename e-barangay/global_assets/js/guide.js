let close = document.getElementById("img-close");
let modal = document.getElementById("res_img_modal");
let caption = document.getElementById("img_caption");

let prev_button = document.getElementById("img-prev");
let next_button = document.getElementById("img-next");

var current_index = 0;

let img_data = [
    "<strong> 1. Login Page </strong> – As you click the login page you will be prompted to input your email address or username or contact number and password. This fields are required to access your account. If you don’t have an account you can click the signup tab to create an account.",
    "<strong> 2. Landing page or Home page </strong> – After your login you will be directly going to landing page again which is the home tab, same as the non-user or guest it will also shows the same content and same navigation tab. You will also notice on the top right corner of the website the account username of resident who login. The only difference is the E-Services tab is now present.",
    "<strong> 3. E-Services tab </strong>– This tab shows the services that are available in the barangay. You can also see here your profile and log out tab.",
    "<strong> 4. Barangay Clearance Form </strong>– As you click Barangay Clearance on the E-Services tab you will be directly going to this page. All fields with * are required, it must be filled-out or signed. You will also need to specify what is the purpose of your request and upload you valid ID.",
    "<strong> 5. Barangay Identification Form </strong>– You will be taken directly to this page if you click Barangay Identification on the E-Services tab. All fields with * are required, it must be filled-out or signed. You will also need to upload you valid ID.",
    "<strong> 6. Barangay Indigency Form </strong>– This form will prompt if you click Barangay Indigency on E-Services tab. Same as the Barangay Clearance Form all fields marked with an asterisk (*) must be completed or signed.",
    "<strong> 7.	Burial Certification </strong>- If you select Barangay Indigency from the E-Services menu, this form will appear. Unless otherwise specified, all fields marked with a * are necessary. This form needs the Burial Information like birth and death date. It also required to upload a valid ID.",
    "<strong> 8.	Certificate of Employment Form </strong>- If you select Barangay Identification from the E-Services option, you will be directed directly to this website. Same as Barangay Clearance and Indigency forms. All with (*) are required to be filled out.",
    "<strong> 9.	Certificate to Travel Form </strong>– This form will show after clicking the Certificate to Travel at E-Services options. Aside from required field with an asterisk (*) you also need to input the driver information and destination in order to complete this request. ",
    "<strong> 10. Proof of Residency Form </strong>– Just like on Certificate of Employment you can access this by clicking it on the E-Services tab. All fields with * are required, it must be filled-out or signed. A valid ID is also required to accept your request.",
    "<strong> 11. Incident Report </strong>– Incident Report can be access after clicking it on the E-Services menu. This has Complainant and Defendant Information form that are required with an asterisk (*) to filled up or signed. ",
    "<strong> 12. Profile Page </strong>– This can be access by clicking it on the E-Services menu tab. Only Residents who signed up and approved by the admin can see their profile. They can edit their information and change username and password in this page. ",

];

function showImgModal (val, index){
    let modalImg = document.getElementById("sample_photo");   

    current_index = index;
    modal.style.display = "block";
    modalImg.src = val;
    caption.innerHTML = img_data[current_index];

    if(current_index == 0) {
        prev_button.style.display = "none";
        next_button.style.display = "block";
    } else if(current_index == 11) {
        next_button.style.display = "none";
        prev_button.style.display = "block";
    } else {
        next_button.style.display = "block";
        prev_button.style.display = "block";
    }
}

prev_button.onclick = function () {
    current_index -= 1;
    showImgModal("../global_assets/img/guide/user-guide-" + (current_index + 1) + ".png", current_index);
}

next_button.onclick = function () {
    current_index += 1;
    showImgModal("../global_assets/img/guide/user-guide-" + (current_index + 1) + ".png", current_index);
}

close.onclick = function () {
    modal.style.display = "none";
}