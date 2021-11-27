<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/e-barangay/classes/AdminMaster.php");
    require_once $_SERVER['DOCUMENT_ROOT'] . '/e-barangay/classes/api/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    if(!$is_admn_lgn) {
        header("Location: ../logout");
        exit();
    }

    $path = $_SERVER['DOCUMENT_ROOT'] . '/e-barangay/global_assets/img/LOGO BRGY 108.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);

    $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $req_sql = "SELECT res.* FROM tblResident_auth auth INNER JOIN tblResident res ON auth.resUname = res.resUname";
    $data_table = selectStatement("r", $req_sql, null);

    $size = sizeof($data_table["req_val"]);
    foreach($data_table["req_val"] as $resident) {
        $status = '';
        if($resident["resValid"]) {
            $status = "Verified";
        }
        
        $table .= "<tr>
            <td class = 'itd'>" . transformDate($resident["sysTime"], "m-d-y") ." </td>
            <td class = 'itd'>" . $resident["resFname"] ." </td>
            <td class = 'itd'>" . $resident["resMname"] ." </td>
            <td class = 'itd'>" . $resident["resLname"] ." </td>
            <td class = 'itd'>" . $resident["resSuffix"] ." </td>
            <td class = 'itd'>" . $resident["resCitiznshp"] ." </td> 
            <td class = 'itd'>" . getCivilStatus($resident["resCivStat"]) ." </td>
            <td class = 'itd'>" . transformDate($resident["resBdate"], "m/d/y") ." </td>
            <td class = 'itd'>" . $resident["resSex"] ." </td>
            <td class = 'itd'>" . $resident["resHouseNum"] ." </td>
            <td class = 'itd'>" . $resident["resStName"] ." </td>
            <td class = 'itd'>" . $resident["resContact"] ." </td>
            <td class = 'itd'>" . $resident["resEmail"] ." </td>
            <td class = 'itd'>" . $resident["resFbName"] ." </td>
            <td class = 'itd'>" . $resident["resVoter"] ." </td>
        </tr>";
    }

    $cr_date = new DateTime();
    $gen_date = $cr_date->format("D, d F Y h:i a");
    
    $report_date = $cr_date->format("l, d F Y h:i:s A");
    $file_date = $cr_date->format("Ymdhis");

    $html = "<html>
    <body style = 'font-family: Arial; font-size: 12px; margin: 1%;'>
        <span style = 'font-size: 8px; display: block; margin-bottom: 5px;'>
            Date & Time Generated: " . $gen_date ."
        </span
        <div align='center' style = 'margin-bottom: 2%;'> 
            <table cellspacing='0' cellpadding='0' style = 'width: 100%'>
                <tbody>
                    <tr>
                        <td width='9%' valign='top'>
                            <p>
                                <img
                                    width='62'
                                    height='62'
                                    src= '" . $logo . "'
                                    alt='e-Barangay'
                                
                                />
                            </p>
                        </td>
                        <td width='61%'>
                            <div align = 'left'>
                                <span style = 'font-size: 12px; display: block'> 
                                    Barangay 108 Zone 12
                                </span>
                                <span style = 'font-size: 12px;'>
                                    <strong>
                                        <em>519 Tengco Street, Pasay City, Metro Manila</em>
                                    </strong>
                                    <em></em>
                                </span>
                            </div>
                        </td>
                        <td width='35%'>
                            <div align = 'right'>
                                <span style = 'font-size: 12px; display: block;'>
                                    <strong>City of Pasay</strong>
                                </span>
                                <span style = 'font-size: 12px;'>
                                    Generated Information Report
                                </span>
                            </div>
                            <br><br>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style = 'margin: 3%; display: block'>
            <span style = 'display: block; margin-bottom: 3%;'><strong>DATE:</strong> " . $report_date . "</span>
            <span style = 'display: block;'><strong>REPORT NAME:</strong> Resident Request</span>
        </div>

        <style>
            .tb, .ith, .itd {
                border-collapse: collapse;
                border: 1px solid black;
            }
        </style>
        <div align = 'center' style = 'display: block;'>
            <table style = 'width: 100%; font-size: 10px; text-align: center;' class = 'tb'>
                <tr>
                    <th class = 'ith'>Date</th>
                    <th class = 'ith'>First Name</th>
                    <th class = 'ith'>Middle Name</th>
                    <th class = 'ith'>Last Name</th>
                    <th class = 'ith'>Suffix</th>
                    <th class = 'ith'>Civil Status</th>
                    <th class = 'ith'>Citizenship</th>
                    <th class = 'ith'>Birthdate</th>
                    <th class = 'ith'>Sex</th>
                    <th class = 'ith'>House Number</th>
                    <th class = 'ith'>Street Name</th>
                    <th class = 'ith'>Contact Number</th>
                    <th class = 'ith'>Email Address</th>
                    <th class = 'ith'>Facebook</th>
                    <th class = 'ith'>Voter Registration</th>
                </tr>
                " . $table . "
            </table>
        </div>
    </body>
    <span style = 'display: block; margin-top: 2%'><strong>Total of</strong> " . $size . " <em>Item</em>(s).</span>
</html>";
    
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    if (ob_get_length()) ob_end_clean();
    // Output the generated PDF to Browser
    $output = $dompdf->output();
    $dompdf->stream("Brgy108z12-Residents_" . $file_date . ".pdf");

    exit(0);
?>
