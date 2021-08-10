<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    if(isset($_POST['upload']) && isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

        if($_FILES['image']['size'] > 10485760) { //10 MB (size is also in bytes)
            goBack();
        } 

        $uploaddir = '../../files/ADMIN_PHOTO/';
    
        /* Generates random filename and extension */
        function tempnam_sfx($path, $suffix){
            do {
                $file = $path."/".mt_rand().$suffix;
                $fp = @fopen($file, 'x');
            }
            while(!$fp);
    
            fclose($fp);
            return $file;
        }
    
        /* Process image with GD library */
        $verifyimg = getimagesize($_FILES['image']['tmp_name']);
    
        /* Make sure the MIME type is an image */
        $pattern = "#^(image/)[^\s\n<]+$#i";
    
        if(!preg_match($pattern, $verifyimg['mime'])){
            goBack();
        }
    
        /* Rename both the image and the extension */
        $uploadfile = tempnam_sfx($uploaddir, ".tmp");
    
        /* Upload the file to a secure directory with the new name and extension */
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {

            /* Setup query */
            $result = doesAdminHasUpload($admin_id);
            $conn = connectDb();

            if($result) {
                $stmt = $conn->prepare("SELECT upld_key FROM tbl_office_upld WHERE oadmn_id = ?");
                $stmt->execute([$admin_id]);
                
                $file_to_delete = $stmt->fetchColumn();

                $file_to_delete = $uploaddir . $file_to_delete;

                if(is_file($file_to_delete) && @unlink($file_to_delete)){
                    // delete success
                }

                $query = 'UPDATE tbl_office_upld SET oadmn_id = :id, upld_key = :ukey, upld_mime = :mime WHERE oadmn_id = :id';
            } else {
                $query = 'INSERT INTO tbl_office_upld (oadmn_id, upld_key, upld_mime) VALUES (:id, :ukey, :mime)';
            }
            
            /* Prepare query */
            $stmt = $conn->prepare($query);
    
            /* Bind parameters */
            $stmt->bindParam(':id', $admin_id);
            $stmt->bindParam(':ukey', basename($uploadfile));
            $stmt->bindParam(':mime', $_FILES['image']['type']);
    
            /* Execute query */
            try {
                $stmt->execute();
            }
            catch(PDOException $e){
                // Remove the uploaded file
                unlink($uploadfile);
    
                //die("Error!: " . $e->getMessage());
                goBack();
            }
        } else {
            goBack();
        }
    } else {
        goBack();
    }
    header("Location: ../page/profile");

    function goBack($error_code = 301) {
        $_SESSION["upd_alert"] = $error_code;
        header("Location: ../page/profile");
        die();
    }
?>
