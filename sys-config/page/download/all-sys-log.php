<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/SystemLog.php");

    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/api/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    $path = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rtu_logo.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);

    $rtu_logo = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $log_data = getAllSysLog();
    $log_size = sizeof($log_data);


    $table ="";
    foreach($log_data as $log) {
        $table .= "<tr>
            <td>[" . htmlspecialchars($log[1]) ."]</td>
            <td style = 'text-align: right;'>" . $log[3] ." </td>
            <td>" . $log[2] ." </td>
            <td>" . $log[4] ." </td>
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
                                    width='52'
                                    height='52'
                                    src= '" . $rtu_logo . "'
                                    alt='Rizal Technological University'
                                
                                />
                            </p>
                        </td>
                        <td width='61%'>
                            <div align = 'left'>
                                <span style = 'font-size: 12px; display: block'> 
                                    Rizal Technological University
                                </span>
                                <span style = 'font-size: 12px;'>
                                    <strong>
                                        <em>Cities of Mandaluyong and Pasig</em>
                                    </strong>
                                    <em></em>
                                </span>
                            </div>
                        </td>
                        <td width='35%'>
                            <div align = 'right'>
                                <span style = 'font-size: 12px; display: block;'>
                                    <strong>RTU Online Appointment System</strong>
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
            <span style = 'display: block; margin-bottom: 3%;'><strong>DATE: </strong> " . $report_date . "</span>
            <span style = 'display: block;'><strong>REPORT NAME:</strong> All Internal System Activities</span>
            <span style = 'display: block;'><strong>REPORT FOR:</strong> " . $config_admin_id . ", <em>System Administrator</em></span>
        </div>

        <div align = 'center' style = 'display: block; margin: 3%'>
            <table style = 'font-size: 12px; text-align: left'>
                " . $table . "
            </table>
        </div>
    </body>
    
</html>";
    // <span style = 'display: block; margin-top: 2%'><strong>Total of</strong> " . $log_size . " <em>Office Feedback</em>(s).</span>
    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    if (ob_get_length()) ob_end_clean();
    // Output the generated PDF to Browser
    $output = $dompdf->output();
    $dompdf->stream("System_Report_All_Sys_Log_" . $file_date . ".pdf");

    exit(0);
?>
