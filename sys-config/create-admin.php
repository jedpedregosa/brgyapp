<html> 
    <head>
        <title>Add Office Admin</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function loadOffices() {
                var branch = document.getElementById('branch').value;
                var office_select = document.getElementById('office');

                office_select.innerHTML = "";
                
                if(branch != "") {
                    $.ajax({
                        url: "controllers/load-open-office",
                        type: "POST",
                        data: {
                            branch: branch,
                        },
                        cache: false,
                        beforeSend: function(){

                        },
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                        }
                    }).done(function(dataResult) {
                        var available_offices = JSON.parse(dataResult);

                        for(let i = 0; i < available_offices.length; i++) {
                            var opt = document.createElement('option');
                            opt.value = available_offices[i][0];
                            opt.innerHTML = available_offices[i][1];
                            office_select.appendChild(opt);
                            office_select.disabled = false;
                        }
                    });
                }
            }
        </script>
    </head>
    <body>
        <?php 
            session_name("cid");
            session_start();

            if(isset($_SESSION["add-admin-response"])) {
                $response = $_SESSION["add-admin-response"];
                if($response == 200) {
                    $oadmn_id = $_SESSION["add-admin-id"];
                    echo $oadmn_id . " is created. <br> <br>"; 

                    $_SESSION["add-admin-response"] = null;
                    $_SESSION["add-admin-id"] = null;
                }
            }
            
        ?>
        <form action = "controllers/add-admin" method = "post">
            Last Name:
            <input type = "text" name = "lname" required> <br>
            First Name:
            <input type = "text" name = "fname" required> <br>
            Email:
            <input type = "text" name = "email" required> <br>
            Contact:
            <input type = "text" name = "contact" required> <br>
            Password:
            <input type = "password" name = "pass" required> <br>
            <br>
            <select id = "branch" onchange = "loadOffices()" required>
                <option value="" disabled selected hidden>RTU Branch</option>
                <option value="Boni Campus">Boni Campus</option>
                <option value="Pasig Campus">Pasig Campus</option>
            </select>
            <select id = "office" name = "office" required>
                <option value="" disabled selected hidden>Office</option>
            </select>
            
            <input type = "submit" name = "add_admin" value = "Add Admin">
        </form>
    </body>
</html>
    

