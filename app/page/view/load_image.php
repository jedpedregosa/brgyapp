<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    $result = doesAdminHasUpload($admin_id);

    if($result) {
        $uploaddir = '../../../files/ADMIN_PHOTO/';

        /* Setup query */
        $query = 'SELECT upld_key, upld_mime FROM tbl_office_upld WHERE oadmn_id = :id';

        /* Prepare query */
        $conn = connectDb();

        $stmt = $conn->prepare($query);

        /* Bind parameters */
        $stmt->bindParam(':id', $admin_id);

        /* Execute query */
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            die("Error!: " . $e->getMessage());
        }

        /* Send headers and file to visitor */
        
        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($uploaddir.$result['upld_key']));
        header("Content-Type: " . $result['upld_mime']);

        while (ob_get_level()) {
            ob_end_clean();
        }
        flush();
        
        readfile($uploaddir.$result['upld_key']);
    }
?>