<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/Config.php");

    function getConnection() {
        $conn;
        try {
            $conn = new PDO("mysql:host=" . dbHost . ";dbname=" . dbName, dbUser, dbPword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage(); 
            // Catch if db fails
        }
        return $conn;
    }

    function insertStatement($query, $params) {
        $conn = getConnection();

        $stmt = $conn->prepare($query);
        
        try {
            return $stmt->execute((array)$params);
        } catch(PDOException $e) { 
            return false;
        }
        
        return true;
    }

    function deleteStatement($query, $params) {
        $conn = getConnection();

        $stmt = $conn->prepare($query);
        
        try {
            return $stmt->execute((array)$params);
        } catch(PDOException $e) { 
            return false;
        }

        return true;
    }

    function updateStatement($query, $params) {
        $conn = getConnection();

        $stmt = $conn->prepare($query);
        
        try {
            return $stmt->execute((array)$params);
        } catch(PDOException $e) { 
            return false;
        }

        return true;
    }

    function selectStatement($type, $query, $params) {
        $conn = getConnection();

        $stmt = $conn->prepare($query);

        $request_result = true;
        $request_val = null;

        try {
            $stmt->execute((array)$params);

            switch($type) {
                case "c": //Get column
                    $request_val = $stmt->fetchColumn();
                    break;
                case "f": //Get Row
                    $request_val = $stmt->fetch();
                    break;
                case "r": //Get all rows
                    $request_val = [];
                    while($row = $stmt->fetchAll()) {
                        $request_val = array_merge($request_val, $row);
                    }
                    break;
                default:
                    $request_result = false;
            }
        } catch(PDOException $e) { 
            $request_result = false;
        }

        return array("req_result" => $request_result, "req_val" => $request_val);

    }
?>