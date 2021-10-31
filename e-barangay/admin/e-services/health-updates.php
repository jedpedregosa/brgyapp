<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }
?>
<html>
    <head>
        <title>e-Barangay - Health Updates</title>

        <meta name="viewport" content="width=device-width, initial-scale=0.1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../global_assets/css/master.css">
        <link rel="stylesheet" href="../../global_assets/css/about.css">

        <!-- Main Quill library -->
        <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
        <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

        <!-- Theme included stylesheets -->
        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/gh/T-vK/DynamicQuillTools@master/DynamicQuillTools.js"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        
    </head>
    <body onload="initClock()">
    <!-- Navigation Bar -->
        <!-- CLOCK -->
        <nav class="time">
            <ul class="navbar-nav">
                <!--digital clock start-->
                <div class="datetime">
                    <span id="dayname">Day</span>,
                    <span id="month">Month</span>
                    <span id="daynum">00</span>,
                    <span id="year">Year</span>
                    <span>|</span>
                    <span id="hour">00</span>:
                    <span id="minutes">00</span>:
                    <span id="seconds">00</span>
                    <span id="period">AM</span>
                </div>
                <!--digital clock end-->
                <div class = "uid">
                    <span><?php echo "@" . $admn_uid; ?></span>
                </div>
            </ul>
        </nav>
        <!-- LOGO -->   
        <div class="container">
            <div class="image">
                <img src="../../global_assets/img/LOGO BRGY 108.png" height="150px">
            </div>
            <div class="text">
                <h1 class = "head-title">e-Barangay</h1>
                <h4> <i class = "fa fa-map-marker"></i>&ensp;519 Tengco Street, Pasay City,<br>Metro Manila </h4>
            </div>
            <div class="logo1">
                <img src="../../global_assets/img/facebook.png" height="50px">
            </div>
            <div class="text facebook">
                <a target="blank" href="https://www.facebook.com/Barangay-108-Zone-12-110664607282436/">Barangay Official Account</a>
                <br>
                <a target="blank" href="https://www.facebook.com/skbrgy108/">SK Official Account</a>
            </div>
        </div>
        <!-- NAVIGATION PANEL -->
        <div class="navbar">
            <div class = "nav-button-group">
                <a href="../home"> H O M E </a>
                <a href="../about"> A B O U T </a>
                <a href="../guide"> U S E R - G U I D E </a>
                <div class="dropdown">
                    <button class="dropbtn">E-SERVICES
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="announcements">ANNOUNCEMENTS</a>
                        <a href="health-updates">HEALTH UPDATES</a>
                        <a href="">COVID-19 INFORMATION</a>
                        <a href="resident-request">REQUESTS</a>
                        <a href="">BLOTTER REPORTS</a>
                        <a href="charity-donation">DONATIONS</a>
                        <a href="">PROFILES</a>
                        <a href="../logout">LOG OUT</a>
                    </div>
                </div>
            </div>  
        </div>
        <div class = "content">
            <form id = "frmUpdate" action = "../controllers/service/create-post?type=hlthpdt" method = "POST" enctype="multipart/form-data" >
                <div class="editor-wrapper">
                    <div id="editor-container"></div>
                    <div id="editor-tbar"></div>
                </div>
                <textarea class = "custom_fileuload" id="update_text_msg" name="update_text_msg" required></textarea>
                <table class = "grid button-grid">
                    <tr>
                        <td>
                            <div class="info-msg" id = "uploaded_img">
                                <i class="fa fa-image"></i> &ensp;
                                <span class = "filename"></span>
                            </div>
                            <div class="info-msg" id = "uploaded_file">
                                <i class="fa fa-file-pdf-o"></i> &ensp;
                                <span class = "filename"></span>
                            </div>
                            <span class = "validate-msg" id = "all_file_msg"></span>
                        </td>
                        <td class = "col-right">
                            <input type = "button" class = "sys-modal-button modal-button-2" onclick = "location.href = '../home'" value = "Cancel">
                            <input type = "button" class = "sys-modal-button" onclick = "submitForm()" value = "Post">
                        </td>
                    </tr>
                </table>
                <input type = "file" class = "custom_fileuload" accept=".jpg,.png" onchange = "checkUpload(this)" id = "photo_update" name = "file_pht"/>
                <input type = "file" class = "custom_fileuload" accept=".docx,.pdf" onchange = "checkUpload(this)" id = "file_update" name = "file_doc"/>
            </form>
        </div>
    <!-- /Navigation Bar/ -->
        <div class = "main-footer">
            <span class = "footer-info"><span class = "copyright">Ⓒ</span> 2021 - Manila Tytana Colleges</span>
        </div>
    </body>
    <script src="../../global_assets/js/datetime.js"></script>
    <script src="../assets/js/announcement.js"></script>
    <script>

        var attchmnt_icon = "<svg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px'viewBox='0 0 512 512' style='enable-background:new 0 0 512 512;' xml:space='preserve'>"
		    + "<path d='M467.076,68.86c-59.902-59.902-156.846-59.896-216.741,0L34.919,284.276c-46.558,46.557-46.558,122.312,0,168.87"
			+ "c46.57,46.571,122.326,46.544,168.87,0L419.205,237.73c33.36-33.36,33.36-87.64,0-121c-33.359-33.361-87.64-33.361-121,0"
			+ "L114.478,300.457c-6.975,6.975-6.975,18.285,0,25.259c6.975,6.975,18.285,6.975,25.259,0l183.727-183.727"
			+ "c19.432-19.432,51.05-19.432,70.481,0c19.431,19.432,19.431,51.05,0,70.481L178.53,427.887c-32.71,32.71-85.646,32.706-118.352,0"
			+ "c-15.806-15.806-24.511-36.821-24.511-59.175s8.706-43.369,24.511-59.176L275.594,94.119c45.94-45.94,120.287-45.934,166.222,0"
			+ "c45.827,45.828,45.827,120.395,0,166.222l-95.741,95.741c-6.975,6.975-6.975,18.284,0,25.259s18.285,6.975,25.259,0l95.741-95.741"
			+ "C526.978,225.7,526.971,128.754,467.076,68.86z'/></svg>";
        // The activated editor functions
        var toolbarOptions = [
            ['bold', 'italic', 'underline'],
            ['image'],
        ];

        // Quill configuration
        var options = {
            modules: {
                toolbar: toolbarOptions,
                
            },
            
            placeholder: 'Post health updates to your barangay',
            readOnly: false,
            theme: 'snow'
        };
        var editor = new Quill('#editor-container', options);
        editor.getModule("toolbar").addHandler("image", () => {
            $('#photo_update').trigger('click');
        });

        // Add a custom Button to the Quill Editor's toolbar:
        const myButton = new QuillToolbarButton({
            icon: attchmnt_icon
        });
    
        myButton.onClick = function(quill) {
            event.preventDefault();
            $('#file_update').trigger('click');
        }
        myButton.attach(editor);

        const limit = 300;

        editor.on('text-change', function (delta, old, source) {
            update_msg_area.textContent = editor.container.firstChild.innerHTML;
            if (editor.getLength() > limit) {
                editor.deleteText(limit, editor.getLength());
            }
        });
    </script>
</html>