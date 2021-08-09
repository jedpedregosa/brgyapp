<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    $feedback_data = getAllFeedback($assigned_office);
    $feedback_size = sizeof($feedback_data);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Feedback</title>

    <link rel="stylesheet" href="../../assets/css/OA-TableStyle.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
                    <img src="load_image" id="bar-pic" alt="Not Found" onerror="this.src='../assets/img/user-icon.png'">
                </div>
                <!-- //User Image -->
            </div>
            <!-- //User Image Container -->

            <!-- User Name, Title and Line -->
            <div class="name"><?php echo htmlspecialchars($full_name); ?></div>
            <div class="job">Office Administrator</div>
            <div class="line"></div>
            <!-- //User Name, Title and Line -->

        </div>
        <!-- //User Image Container -->

        <!-- Navigation List -->
        <ul class="nav-list">
            <li>
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search...">
                <span class="tooltip">Search</span>
            </li>
            <li>
                <a href="../dashboard">
                    <i class="bi bi-columns-gap"></i>
                    <span class="links_name">DASHBOARD</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="appointment">
                    <i class="bi bi-calendar3"></i>
                    <span class="links_name">APPOINTMENTS</span>
                </a>
                <span class="tooltip">Appointments</span>
            </li>
            <li>
                <a href="javascript:window.location.reload(true)" class="active">
                    <i class="bi bi-star"></i>
                    <span class="links_name">FEEDBACK</span>
                </a>
                <span class="tooltip">Feedback</span>
            </li>
            <li>
                <a href="../profile">
                    <i class="bx bx-user"></i>
                    <span class="links_name">PROFILE</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>
            <div class="line2"></div>
            <a href = "../logout">
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
                    <img src="../../assets/img/menu.png" id="btn"> RTU APPOINTMENT SYSTEM
                    <!-- Add here the office name -->
                </div>

                <div class="user-wrapper">
                    <!-- User Image Container -->
                    <div class="header-user-con">

                        <!-- User Image -->
                        <div class="header-user-img">
                            <img src="load_image" id="header-pic" alt="Not Found" onerror="this.src='../assets/img/user-icon.png'">
                        </div>
                        <!-- //User Image -->
                    </div>
                    <!-- //User Image Container -->

                    <div class="user-name">
                        <a href="../profile">
                            <h5><?php echo htmlspecialchars($full_name); ?></h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- //Header -->

    <!-- Contents -->
    <main>
        <!-- Contents Container -->
        <div class="contents">
            <div class="main-container">
                <div class="text-container">
                    <h4>FEEDBACK</h4>
                </div>

                <div class="select-input-container">
                    <select class="select-table">
                        <option value="" hidden selected disabled>Select Table</option>
                        <option value="Student">Student</option>
                        <option value="Employee">Employee</option>
                        <option value="Guest">Guest</option>
                    </select>
                    <select class="select-display">
                        <option value="" hidden disabled selected>View By</option>
                        <option value="">Default</option>
                    </select>
                    <input type="text" name="" id="" class="search-bar" placeholder="Search">
                    <input type="button" value="" class="search-button">
                </div>

                <div class="table-container">
                    <table>
                        <tr class="table-header">
                            <th style="width: 15%;">FULL NAME</th>
                            <th style="width: 10%;">CONTACT NO.</th>
                            <th style="width: 10%;">EMAIL</th>
                            <th style="width: 20%;">FEEDBACK MESSAGE</th>
                            <th style="width: 10%;">USER CATEGORY</th>
                            <th style="width: 20%;">SYSTEM TIME</th>
                            <th style="width: 10%;">REACTION</th>
                        </tr>
            <?php 
                foreach((array)$feedback_data as $feedback) {
                    ?>
                        <tr>
                    
                            <td><?php echo htmlspecialchars($feedback["fback_fname"])?></td>
                            <td><?php echo htmlspecialchars($feedback["fback_contact"])?></td>
                            <td><?php echo htmlspecialchars($feedback["fback_email"])?></td>
                            <td><?php echo htmlspecialchars($feedback["fback_msg"])?></td>
                            <td>
                                <div class="build-badge">
                                    <span class="build-badge__status build-badge__status-information">
                                    <?php echo htmlspecialchars(strtoupper($feedback["fback_cat"]))?>
                                    </span>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($feedback["fback_sys_time"])?></td>
                            <td>
                <?php
                        if($feedback["fback_is_stsfd"]) {
                            ?>
                                <div class="like" id="like">
									<i class="bi bi-heart-fill"></i>
								    <span class="like_dislike">Satisfied</span> <!-- Show Result Data (Display Rating) -->
							    </div>
                            <?php
                        } else {
                            ?>
                                <div class="dislike" id="dislike">
									<i class="bi bi-heart-half"></i>
								    <span class="like_dislike">Unsatisfied</span> <!-- Show Result Data (Display Rating) -->
							    </div>
                            <?php
                        }               
                ?>
                                
                            </td>
                        </tr>
                    <?php
                }
            ?>
                    </table>
                    <p class="record-count" id="record-count">Total of <?php echo htmlspecialchars($feedback_size); ?> feedback(s). </p>
                </div>

            </div>


        </div>
        <!-- //Contents Container -->
    </main>
    <!-- //Contents -->

    <!-- Javascript -->
    <script src="../../assets/js/OA-TableScript.js"></script>
    <!-- //Javascript -->

</body>

</html>