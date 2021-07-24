// Input Fields
        const lastname = document.getElementById('lastname');
        const lastname1 = document.getElementById('lastname1');
        const lastname2 = document.getElementById('lastname2');
        const lastname3 = document.getElementById('lastname3');
        const email = document.getElementById('email');
        const email1 = document.getElementById('email1');
        const student_number = document.getElementById('student_number');
        const employee_number = document.getElementById('employee_number');


        // Error Labels
        const error_last_name = document.getElementById('error_last_name');
        const error_last_name1 = document.getElementById('error_last_name1');
        const error_last_name2 = document.getElementById('error_last_name2');
        const error_last_name3 = document.getElementById('error_last_name3');
        const error_email = document.getElementById('error_email');
        const error_email1 = document.getElementById('error_email1');
        const error_student_number = document.getElementById('error_student_number');
        const error_employee_number = document.getElementById('error_employee_number');

        lastname.addEventListener("keyup", function(event) {
            var validRegex = /^[a-zA-Z]*$/;
            if (!lastname.value.match(validRegex)) {
                lastname.style.border = "2px solid red";
                error_last_name.style.color = "red";
                error_last_name.textContent = "Invalid Name";
            } else if (lastname.value == null || lastname.value == '') {
                lastname.style.border = "2px solid red";
                error_last_name.style.color = "red";
                error_last_name.textContent = "Please fill up this field";
            } else {
                lastname.style.border = "2px solid blue";
                error_last_name.textContent = "";
            }
        });


        lastname1.addEventListener("keyup", function(event) {
            var validRegex = /^[a-zA-Z]*$/;
            if (!lastname1.value.match(validRegex)) {
                lastname1.style.border = "2px solid red";
                error_last_name1.style.color = "red";
                error_last_name1.textContent = "Invalid Name";
            } else if (lastname1.value == null || lastname1.value == '') {
                lastname1.style.border = "2px solid red";
                error_last_name1.style.color = "red";
                error_last_name1.textContent = "Please fill up this field";
            } else {
                lastname1.style.border = "2px solid blue";
                error_last_name1.textContent = "";
            }
        });


        lastname2.addEventListener("keyup", function(event) {
            var validRegex = /^[a-zA-Z]*$/;
            if (!lastname2.value.match(validRegex)) {
                lastname2.style.border = "2px solid red";
                error_last_name2.style.color = "red";
                error_last_name2.textContent = "Invalid Name";
            } else if (lastname2.value == null || lastname2.value == '') {
                lastname2.style.border = "2px solid red";
                error_last_name2.style.color = "red";
                error_last_name2.textContent = "Please fill up this field";
            } else {
                lastname2.style.border = "2px solid blue";
                error_last_name2.textContent = "";
            }
        });


        lastname3.addEventListener("keyup", function(event) {
            var validRegex = /^[a-zA-Z]*$/;
            if (!lastname3.value.match(validRegex)) {
                lastname3.style.border = "2px solid red";
                error_last_name3.style.color = "red";
                error_last_name3.textContent = "Invalid Name";
            } else if (lastname3.value == null || lastname3.value == '') {
                lastname3.style.border = "2px solid red";
                error_last_name3.style.color = "red";
                error_last_name3.textContent = "Please fill up this field";
            } else {
                lastname3.style.border = "2px solid blue";
                error_last_name3.textContent = "";
            }
        });


        email.addEventListener("keyup", function(event) {

            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if (email.value == null || email.value == '') {
                error_email.style.color = "red";
                error_email.textContent = "Please fill up this field";
                email.style.border = "2px solid red";
            } else if (!email.value.match(validRegex)) {
                error_email.style.color = "red";
                error_email.textContent = "Invalid Email Address";
                email.style.border = "2px solid red";
            } else {
                error_email.style.color = "blue";
                error_email.textContent = "";
                email.style.border = "2px solid blue";
            }
        });


        email1.addEventListener("keyup", function(event) {

            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            if (email1.value == null || email1.value == '') {
                error_email1.style.color = "red";
                error_email1.textContent = "Please fill up this field";
                email1.style.border = "2px solid red";
            } else if (!email1.value.match(validRegex)) {
                error_email1.style.color = "red";
                error_email1.textContent = "Invalid Email Address";
                email1.style.border = "2px solid red";
            } else {
                error_email1.style.color = "blue";
                error_email1.textContent = "";
                email1.style.border = "2px solid blue";
            }
        });



        student_number.addEventListener("keyup", function(event) {

            var validRegex = /^[0-9]+-[0-9]*$/;

            if (student_number.value == null || student_number.value == '') {
                error_student_number.style.color = "red";
                error_student_number.textContent = "Please fill up this field";
                student_number.style.border = "2px solid red";
            } else if (!student_number.value.match(validRegex) || student_number.value.length != 11) {
                error_student_number.style.color = "red";
                error_student_number.textContent = "Invalid Student Number";
                student_number.style.border = "2px solid red";
            } else {
                error_student_number.textContent = "";
                student_number.style.border = "2px solid blue";
            }

        });

        employee_number.addEventListener("keyup", function(event) {
            var validRegex = /^[A-Z]+-[0-9]+-[0-9]+-[0-9]+-[0-9]*$/;

            if (employee_number.value == null || employee_number.value == '') {
                error_employee_number.style.color = "red";
                error_employee_number.textContent = "Please fill up this field";
                employee_number.style.border = "2px solid red";
            } else if (!employee_number.value.match(validRegex) || employee_number.value.length != 12) {
                error_employee_number.style.color = "red";
                error_employee_number.textContent = "Invalid Employee Number";
                employee_number.style.border = "2px solid red";
            } else {
                error_employee_number.textContent = "";
                employee_number.style.border = "2px solid blue";
            }

        });