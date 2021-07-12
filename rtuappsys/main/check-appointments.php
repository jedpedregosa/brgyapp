<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/rtuappsys/includes/dbase.php");
    $app_id;
    if(isset($_GET["app_id"])) {
        $app_id = $_GET["app_id"];
    } else {
        header("Location: main/rtuappsys.php");
		die();
    }

    $conn = connectDb();
    $stmt = $conn->prepare("SELECT * FROM tbl_visitor WHERE vstor_id =
        (SELECT vstor_id FROM tbl_appointment WHERE app_id = ?)");
    $stmt-> execute([$app_id]);
    $result = $stmt->fetch();

    $stmt = $conn->prepare("SELECT * FROM tbl_appointment WHERE app_id = ?");
    $stmt-> execute([$app_id]);
    $result2 = $stmt->fetch();

    $stmt = $conn->prepare("SELECT * FROM tbl_schedule WHERE sched_id = (SELECT sched_id FROM tbl_appointment WHERE app_id = ?)");
    $stmt-> execute([$app_id]);
    $result3 = $stmt->fetch();
    
    echo "<br><p><strong>YOUR INFORMATION </strong></p>";
    echo "Last Name: " . $result[2] . "<br>";
    echo "First Name: " . $result[3] . "<br>";
    echo "Contact Number: " . $result[4] . "<br>";
    echo "Email: " . $result[5] . "<br>";
    echo "<br><p><strong>YOUR APPOINTMENT </strong></p>";
    $result4 = getValues($result3[3], $result3[2]);
    echo "Office: " . $result4["officeValue"] . "<br>";
    echo "Time: " . $result4["timeValue"] . "<br>";
    echo "Branch: " . $result2[5] . "<br>";
    echo "Purpose: " . $result2[6] . "<br>";
?>