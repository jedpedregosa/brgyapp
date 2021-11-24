<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");

    if(!$is_admn_lgn) {
        header("Location: ../../logout");
        exit();
    }

    $post_req = isset($_POST["ofcl_name"])
        && isset($_POST["position"]);

    if(!$post_req) {
        goPrev();
    }

    $unique_id = time();
    $storage_dir = '../../../FILE_STORAGE/BRGY_OFFICIAL/';

    if(is_dir($storage_dir)) {
        $temp_photo = tempnam_sfx($storage_dir, "OFFICIAL-" . $unique_id);
        $file_upload_success = move_uploaded_file($_FILES["ofcl_photo"]['tmp_name'], $temp_photo);

        if($file_upload_success) {
            $official_sql = "INSERT INTO tblOfficial (id, name, position) VALUES (?, ?, ?)";
            insertStatement($official_sql, [$unique_id, $_POST["ofcl_name"], $_POST["position"]]);
        }
    } else {
        goPrev(); //Error Message
    }

    goPrev();

    function goPrev($result = 201) {
        header("Location: ../../about"); 
        exit();
    }

    /* Generates random filename and extension */
    function tempnam_sfx($path, $file_name){
        do {
            $file = $path . "/" . $file_name . ".tmp";
            $fp = @fopen($file, 'x');
        }
        while(!$fp);

        fclose($fp);
        return $file;
    }
?>