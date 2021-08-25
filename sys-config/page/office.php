<?php 
/******************************************************************************
 * 	Rizal Technological University Online Appointment System
 * 		
 * 	File: 
 * 		office.php (Access Page) -- 
 *  Description:
 * 		1. Displays the office and office admin table.
 * 
 * 	Date Created: 14th of August, 2021
 * 	Github: https://github.com/jedpedregosa/rtuappsys
 * 
 *	Issues:	
 *  Lacks: 
 *  Changes:
 * 	
 * 	
 * 	RTU Boni System Team
 * 	BS-IT (Batch of 2018-2022)
 ******************************************************************************/

    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

    $all_office = getAllOffice();
    $all_office_size = sizeof($all_office);

    $all_admin = getAllOfficeAdmin();
    $all_admin_size = sizeof($all_admin);

    $isAlert = false;
    $isSuccess = false;

    if(isset($_SESSION["err_code"])) {
        $isAlert = true;
        if($_SESSION["err_code"] == 300) {
            $isSuccess = true;
            if(isset($_SESSION["add_office_id"])) {     
                $office_id = $_SESSION["add_office_id"];
    
                $title = "Add an Office";
                $msg = "Office  <strong>" . $office_id . "</strong>  was created successfully.";

                unset($_SESSION["add_office_id"]);
            } else if(isset($_SESSION["add-admin-id"]) && isset($_SESSION["add-admin-pw"])) {
                $pw = $_SESSION["add-admin-pw"];
                $id = $_SESSION["add-admin-id"];

                $title = "Add an Admin Account";
                $msg = "Office admin  <strong>" . $id . "</strong>  with password  <strong>" . $pw . "</strong>  was created successfully.";

                unset($_SESSION["add-admin-id"]);
                unset($_SESSION["add-admin-pw"]);
            }
        } else if($_SESSION["err_code"] == 301) {
            $title = "Error Add Office";
            $msg = "The office has an identical office existing.";
        } else {
            $title = "Error";
            $msg = "Oops, it seems that we are experiencing an error.";
        }
        unset($_SESSION["err_code"]);
    } else if(isset($_SESSION["off_dltres"])) {
        $isAlert = true;
        $val = $_SESSION["off_dltres"];

        if(isset($_SESSION["off_dltd"])) {
            if($val == 300) {
                $off_id = $_SESSION["off_dltd"];
                
                if(isset($_SESSION["admn_dltd"])) {
                    $title = "Delete Office";
                    $msg = "Office <strong>" . $off_id . "</strong> and Admin <strong>" . $_SESSION["admn_dltd"] . "</strong> was deleted successfully."; 
                    
                    unset($_SESSION["admn_dltd"]);
                } else {
                    $title = "Delete Office";
                    $msg = "Office <strong>" . $off_id . "</strong> was deleted successfully. ";  
                }
                
            } else if($val == 301) {
                $off_id = $_SESSION["off_dltd"];
    
                $title = "Can\'t Delete Office";
                $msg = "Unable to delete <strong>" . $off_id . "</strong>. The office is still under an appointment.";
            } else {
                $title = "Error";
                $msg = "Oops, it seems that we are experiencing an error on deleting this office.";
            }
            $isSuccess = true;
            unset($_SESSION["off_dltd"]);
        } else if($val == 302){
            if(isset($_SESSION["admn_dltd"])) {
                $title = "Delete Office Admin";
                $msg = "Office Admin <strong>" . $_SESSION["admn_dltd"] . "</strong> was deleted successfully.";  

                $isSuccess = true;
                unset($_SESSION["admn_dltd"]);
            } else {
                $title = "Error";
                $msg = "Oops, it seems that we are experiencing an error on deleting this admin office.";
            }         
        } else {
            $title = "Error";
            $msg = "Oops, it seems that we are experiencing an error on deleting this office.";
        }
        unset($_SESSION["off_dltres"]);
    } else if(isset($_SESSION["updt_res"])) {
        $isAlert = true;
        if($_SESSION["updt_res"] == 300) {
            if(isset($_SESSION["updt_office"])) {
                $title = "Update Office";
                $msg = "Office <strong>" . $_SESSION["updt_office"] . "</strong> was updated successfully.";  
                $isSuccess = true;

                unset($_SESSION["updt_office"]);
            } else {
                $title = "Error";
                $msg = "Oops, it seems that we are experiencing an error updating this office.";
            }
        } else if($_SESSION["updt_res"] == 301) {
            $title = "Error Update Office";
            $msg = "Update on office <strong>" . $_SESSION["updt_office"] . "</strong> will create an identical office.";

            unset($_SESSION["updt_office"]);
        } else if($_SESSION["updt_res"] == 400) {
            if(isset($_SESSION["updt_pass"]) && isset($_SESSION["updt_admid"])) {
                $title = "Password Reset";
                $msg = "Created <strong>" . $_SESSION["updt_pass"] . "</strong> as new password for office admin <strong>" . $_SESSION["updt_admid"] . "</strong>.";  
                
                $isSuccess = true;

                unset($_SESSION["updt_pass"]);
                unset($_SESSION["updt_admid"]);
            } else if(isset($_SESSION["updt_admid"])) {
                $title = "Update Office Admin";
                $msg = "Office Admin <strong>" . $_SESSION["updt_admid"] . "</strong> successfully updated.";
                
                $isSuccess = true;
                
                unset($_SESSION["updt_admid"]);
            } else {
                $title = "Error";
                $msg = "Oops, it seems that we are experiencing an error updating this admin.";
            }
        } else {
            $title = "Error";
            $msg = "Oops, it seems that we are experiencing an error updating this office.";
        }
        unset($_SESSION["updt_res"]);
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All Offices - System Configuration | RTUAppSys</title>

    <link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/css/SA-Office.css" . FILE_VERSION; ?>">
    <link rel="stylesheet" href="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/css/fnon.min.css" />

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>

    <!-- Side Navigation Bar -->
    <div class="sidebar">

        <!-- User Image Container -->
        <div class="user-con">

            <!-- User Image Container -->
            <div class="user-img">
                <!-- User Image -->
                <div class="bar-user-img">
                    <img src="../assets/img/user-icon.png" id="bar-pic">
                </div>
                <!-- //User Image -->
            </div>
            <!-- //User Image Container -->

            <!-- User Name, Title and Line -->
            <div class="name"><?php echo $config_admin_id; ?></div>
            <div class="job">Administrator</div>
            <div class="line"></div>
            <!-- //User Name, Title and Line -->

        </div>
        <!-- //User Image Container -->

        <!-- Navigation List -->
        <ul class="nav-list">
            <li>
                <i class="qr"><img src="../assets/img/qr_code_scan.svg"></i>
                <input id="searchQR" type="text" placeholder="Search QR Key..." oninput="Typing()">
                <a href="" onclick='return check(this, 0)'>
					<span class="bi bi-arrow-right-short" id="arrow"></span>
				</a>
				<span class="tooltip">Search QR</span>
            </li>
            <li>
                <a href="main">
                    <i class="bi bi-columns-gap"></i>
                    <span class="links_name">DASHBOARD</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="javascript:window.location.reload(true)" class="active">
                    <i class="bi bi-door-open"></i>
                    <span class="links_name">OFFICES</span>
                </a>
                <span class="tooltip">Offices</span>
            </li>
            <li>
                <a href="view/appointment">
                    <i class="bi bi-calendar3"></i>
                    <span class="links_name">APPOINTMENTS</span>
                </a>
                <span class="tooltip">Appointments</span>
            </li>
            <li>
                <a href="view/feedback">
                    <i class="bi bi-star"></i>
                    <span class="links_name">FEEDBACK</span>
                </a>
                <span class="tooltip">Feedback</span>
            </li>
            <li>
                <a href="sys-settings">
                    <i class="bi bi-gear"></i>
                    <span class="links_name">SETTINGS</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
            <div class="line2"></div>
            <a href = "logout">
                <li class="logout">
                    <i class='bi bi-box-arrow-right' id="log_out"></i>
                    <span class="logout-label">Logout</span>  
                </li>
            </a>
        </ul>
        <!-- //Navigation List -->

    </div>
    <!-- //Side Navigation Bar -->

    <!-- Header -->
    <section class="header-section">
        <div class="header-border">
            <div class="header">
                <div class="sys-title">
                    <img src="../assets/img/menu.png" id="btn"> RTU APPOINTMENT SYSTEM
                </div>

                <div class="user-wrapper">
                    <!-- User Image Container -->
                    <div class="header-user-con">

                        <!-- User Image -->
                        <div class="header-user-img">
                            <img src="../assets/img/user-icon.png" id="header-pic">
                        </div>
                        <!-- //User Image -->
                    </div>
                    <!-- //User Image Container -->

                    <div class="user-name">
                        <a href="sys-settings">
                            <h5><?php echo $config_admin_id; ?></h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //Header -->

    <!-- Contents -->
    <div class="Appt_area">
        <div class="contents">

            <div class="main-container">
                <div class="text-container">
                    <h4>Offices</h4>
                    <div class="add_icon-container" style="position: relative; left: 95px; top: -16px;">
                        <button class="add_icon" title="Add Office" id="add_office" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">
                            <img src="../assets/img/add.png">
                        </button>
                    </div>
                </div>
                <div class="functions-container">

                    <div class="select-1-container">
                        <!--Add Select View By Here-->
                        <select class="select-table" style="padding-top: 8px;" onchange = "searchTableOffice(2, this.value)">
                            <option value="">All Campus</option>
                            <option value="Boni Campus">Boni Campus</option>
                            <option value="Pasig Campus">Pasig Campus</option>
                        </select>
                    </div>
                    <div class="select-2-container">
                        <select class="select-table" style="padding-top: 8px;" onchange = "searchTableOffice(4, this.value)">
                            <option value="">All Offices</option>
                            <option value="Open">Open Offices</option>
                            <option value="Closed">Closed Offices</option>
                        </select>
                    </div>

                    <div class="search-bar-container">
                        <!--Add Search Bar Here-->
                        <input type="text" class="searchTerm" placeholder="Search By Name" onkeyup = "searchTableOffice(1, this.value)">
                        <button disabled class="searchButton">
                          <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>
                <div class="table-container">
                    <table id = "tbl_office">
                        <tr class="table-header">
                            <th style="width: 20%;">OFFICE ID</th>
                            <th style="width: 20%;">OFFICE NAME</th>
                            <th style="width: 20%;">RTU CAMPUS</th>
                            <th style="width: 30%;">DESCRIPTION</th>
                            <th style="width: 20%;">STATUS</th>
                            <th colspan="2" style="width: 5%;">ACTIONS</th>
                        </tr>
            <?php
                foreach((array)$all_office as $office) {
                    ?>
                        <tr>
                            <td style = "white-space: nowrap">
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-warning"><?php echo htmlspecialchars($office[0]); ?></span>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($office[1]); ?></td>
                            <td><?php echo htmlspecialchars($office[3]); ?></td>
                            <td><?php echo htmlspecialchars($office[2]); ?></td>
                            <td>
                                <?php 
                                    $isOpen = "true";
                                    if($office[4]) {
                                        ?>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-success">OPEN</span>
                                </div>
                                        <?php
                                    } else {
                                        $isOpen = "false";
                                        ?>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-error">CLOSED</span>
                                </div>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td>
                            <button class="delete" title="Delete Record"
                                onclick = "confirmODelete('<?php echo addslashes($office[0]); ?>','<?php echo addslashes($office[1]); ?>', '<?php echo addslashes($office[3]); ?>')">
                                <img src="../assets/img/delete_icon.png">
                            </button>
                            <button class="edit" title="Edit Record" id="add_admin" 
                                onclick="editOffice('<?php echo htmlspecialchars($office[0]); ?>', '<?php echo addslashes($office[1]); ?>', '<?php echo addslashes($office[2]); ?>', <?php echo $isOpen; ?>)" style="width:auto;">
                                <img src="../assets/img/edit_icon.png">
                            </button>
                            </td>
                        </tr>
                    <?php
                }
            ?>  
                    </table>
                    <p class="record-count" id="record-count">Total of <?php echo $all_office_size; ?> Office(s). </p>
                </div>

            </div>

            <div class="main-container">
                <div class="text-container">
                    <h4>Administrators</h4>
                    <div class="add_icon-container" style="position: relative; left: 180px; top: -16px;">
                        <button class="add_icon" title="Add Administrator" id="add_admin" onclick="document.getElementById('id02').style.display='block'" style="width:auto;">
                            <img src="../assets/img/add.png">
                        </button>
                    </div>
                </div>
                <div class="functions-container">
                    <div class="search-bar-container">
                        <!--Add Search Bar Here-->
                    <input type="text" class="searchTerm" placeholder="Search By Office ID" onkeyup = "searchTableAdmin(0, this.value)">
                        <button disabled class="searchButton">
                          <i class="bi bi-search"></i>
                        </button>
                    </div>

                </div>
                <div class="table-container">
                    <table id = "tbl_admin">
                        <tr class="table-header">
                            <th>OFFICE ID</th>
                            <th>ADMIN ID</th>
                            <th>LAST NAME</th>
                            <th>FIRST NAME</th>
                            <th>EMAIL</th>
                            <th>CONTACT NO.</th>
                            <th colspan="2" style="width: 5%;">ACTIONS</th>
                        </tr>
            <?php 
                foreach((array)$all_admin as $admin) {
                    ?>
                        <tr>
                            <td style = "white-space: nowrap">
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-warning"><?php echo htmlspecialchars($admin[0])?></span>
                                </div>
                            </td>
                            <td style = "white-space: nowrap">
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-indeterminate"><?php echo htmlspecialchars($admin[1])?></span>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($admin[2])?></td>
                            <td><?php echo htmlspecialchars($admin[3])?></td>
                            <td><?php echo htmlspecialchars($admin[4])?></td>
                            <td><?php echo htmlspecialchars($admin[5])?></td>
                            <td><button class="delete" title="Delete Record" 
                                onclick = "confirmAdmDel('<?php echo addslashes($admin[1])?>', '<?php echo addslashes($admin[2])?>')">
                                    <img src="../assets/img/delete_icon.png">
                            </button>
                            <button class="edit" title="Edit Record" id="add_admin" 
                                onclick="editAdmin('<?php echo htmlspecialchars($admin[1])?>', '<?php echo addslashes($admin[2])?>', '<?php echo addslashes($admin[3])?>', '<?php echo addslashes($admin[4])?>', '<?php echo addslashes($admin[5])?>')" style="width:auto;">
                                <img src="../assets/img/edit_icon.png">
                            </button>
                            </td>
                        </tr>
                    <?php
                }     
                
            ?>
                    </table>
                    <p class="record-count" id="record-count">Total of <?php echo $all_admin_size; ?> Office Admin(s). </p>
                </div>

            </div>
            <div class="button-group-container">

            <div class="download-all" style="position:relative; left: 20%;">
                    <a href = "download/all-office"><i class="bi bi-check2-circle"></i> &nbsp; Download List of Offices</a>
                    <a href = "download/all-office-admin"><i class="bi bi-door-closed"></i> &nbsp; Download List of Admins</a>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="id01" class="modal">
            <form class="modal-content animate" action="../controllers/add-office" method="POST">

                <div class="imgcontainer">
                  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="" alt="" class="">
                </div>
                
                <p class="greetings">Hi Administrator!<span><br>Add Office here</span></p>

                <div class="offc-container">
                    <p><input type="text" placeholder="Office Name" name="ofcname" minLength = "2" maxLength = "50" autocomplete="off" required></input></p>
                    <select id = "off_campus" name = "off_campus" required>
                        <option value = "" selected hidden disabled>Select a Campus</option>
                        <option value = "Boni Campus">Boni Campus</option>
                        <option value = "Pasig Campus">Pasig Campus</option>
                    </select>
                    <br>
                    <p><textarea placeholder="Description" name="desc" maxLength = "60" autocomplete="off"></textarea></p>
                    <br>
                    <input type = "checkbox" name = "accepts_app" id = "accepts_app" checked>
                    <label for = "accepts_app" id = "lbl_accepts_app">Open for appointments</label> 
                </div>
                <input class="add_office" type="submit" value = "Add Office" name = "sbmt_add"/>
            </form>
        </div>

        <div id="id02" class="modal">
            <form class="modal-content animate" action="../controllers/add-admin" method="POST">

                <div class="imgcontainer">
                  <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="" alt="" class=""></img>
                </div>

                <p class="p1">Hi Administrator!<span>
                    <br>Add Office Admin here</span>
                </p>
                
                <div class="ad_container">
                    <form class="form-inline">
                        <input type="text" id="firstname" placeholder="First Name" name="oa-firstname" minLength = "2" maxLength = "30" autocomplete="off" required>
                        <input type="text" id="lastname" placeholder="Last Name" name="oa-lastname" minLength = "2" maxLength = "30" autocomplete="off" required>
                    
                        <input type="email" id="email" placeholder="Email" name="oa-email" minLength = "2" maxLength = "40" autocomplete="off" required>
                        <input type="text" id="contact" placeholder="Contact No." name="oa-contact" minLength = "2" maxLength = "30" autocomplete="off" required>

                        <span class="form-inline">
                            <select id="oa-branch" onchange = "loadOffices()" required> 
                                <option value="" disabled selected hidden>RTU Campus</option>
                                <option value="Boni Campus">Boni Campus</option>
                                <option value="Pasig Campus">Pasig Campus</option>                                
                            </select>
                            <div id ="office-none"> 
                                <span>Please select a campus first.</span>
                            </div>
                            <div id ="office-wait"> 
                                <span>Please wait.</span>
                            </div>
                            <div id ="office-empt"> 
                                <span>No offices available.</span>
                            </div>
                            <select id="oa-office" name="oa-office" required> 
                                <option value="" disabled="" selected="" hidden="">Please select an office</option>
                            </select>
                        </span>
                    </form>
                    <br>
                    <input class="add_admin" type="submit" name = "add_admin" value = "Add Office Admin"/>
                </div>
            </form>
        </div>

        <div id="id11" class="modal">
            <form class="modal-content animate" action="../controllers/edit-office" method="POST">

                <div class="imgcontainer">
                  <span onclick="document.getElementById('id11').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="" alt="" class="">
                </div>
                
                <p class="greetings">Hi Administrator!<span><br>Edit Office Table here</span></p>

                <div class="offc-container">
                    <p><input type="text" class = "edit-txt edit-txt2" id = "editoffid" name="editoffid" autocomplete="off" readonly></input></p>
                    <p><input type="text" class = "edit-txt" placeholder="Office Name" id="editoffn" minLength = "2" maxLength = "50" name="editoffn" autocomplete="off" required></input></p>
                    <p><textarea class = "edit-txt" placeholder="Description" id="editoffdsc" maxLength = "60" name="editoffdsc" autocomplete="off"></textarea></p>

                    <input type = "checkbox" name = "editaccept" id = "editaccept">
                    <label for = "editaccept" id = "lbl_accepts_app">Open for appointments</label> 
                </div>
                <input class="add_office" type="submit" value = "Update Office" name = "updoffice">
            </form>
        </div>

        <div id="id12" class="modal">
            <form class="modal-content animate" action="../controllers/edit-admin" method="post">

                <div class="imgcontainer">
                  <span onclick="document.getElementById('id12').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="" alt="" class=""></img>
                </div>

                <p class="p1">Hi Administrator!<span>
                    <br>Edit Admin Table here</span>
                </p>
                
                <div class="ad_container">
                    <form class="form-inline">
                        <input type="text" id="editadmid" name="editadmid" autocomplete="off" readonly>
                      <input type="text" id="editadmfname" placeholder="First Name" name="editadmfname" minLength = "2" maxLength = "30" autocomplete="off" required>

                      <input type="text" id="editadmlname" placeholder="Last Name" name="editadmlname" minLength = "2" maxLength = "30" autocomplete="off" required>
                      <input type="email" id="editadmail" placeholder="Email" name="editadmail" minLength = "2" maxLength = "40" autocomplete="off" required>

                        <span class="form-inline">
                            <input type="text" id="editadmcntct" placeholder="Contact" name="editadmcntct" minLength = "2" maxLength = "30" autocomplete="off" required>
                            <input class = "edit_admin" type="submit" name = "edt_adm_pass" value = "Reset Password">
                        </span>
                    </form>
                    <br>
                    <input class="add_admin" type="submit" name = "edt_adm" value = "Update Office Admin">
                </div>
            </form>
        </div>

    </div>
    <!-- //Contents -->

    <!-- Javascript -->
    <script src="<?php echo HTTP_PROTOCOL . HOST . "/sys-config/assets/js/Admin-Script.js" . FILE_VERSION; ?>"></script>
    <script src="<?php echo HTTP_PROTOCOL . HOST; ?>/assets/js/fnon.min.js"></script>

    <?php 
		if($isAlert) {
            if($isSuccess) {
                echo "<script> Fnon.Alert.Warning({
                    message: '". $msg ."',
                    title: '" . $title . "',
                    btnOkText: 'Okay',
                    btnOkColor: 'White',
                    btnOkBackground: '#002060',
                    fontFamily: 'Poppins, sans-serif'
                }); </script>";
            } else {
                echo "<script> Fnon.Alert.Danger({
                    message: '". $msg ."',
                    title: '" . $title . "',
                    btnOkText: 'Okay',
                    fontFamily: 'Poppins, sans-serif'
                }); </script>";
            }
			
		} else {
            $lack = $all_office_size - $all_admin_size;
            if($lack > 0) {
                echo "<script> Fnon.Alert.Warning({
                    message: 'You still have (<strong>" . $lack. "</strong>) office with unassigned office admininistrators.',
                    title: 'Hello, <strong>" . $config_admin_id . "</strong>',
                    btnOkText: 'Okay',
                    btnOkColor: 'White',
                    btnOkBackground: '#002060',
                    fontFamily: 'Poppins, sans-serif'
                }); </script>";
            } else if($is_under_maintenance) {
				echo "<script> Fnon.Alert.Dark({
					message: 'The system is still under maintenance mode. All users except system administrators are still prohibited to use the system.',
					title: '<strong>Reminder</strong>',
					btnOkText: 'Okay',
					fontFamily: 'Poppins, sans-serif'
				}); </script>";
			}
        }
	?>
    <!-- //Javascript -->

</body>

</html>