<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
    require_once 'api/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    function generateAppointmentFile($app_id) {
        $appointmentKey = getAppointmentKeyByAppointmentId($app_id);
        $file_keys = getFileKeysByAppId($app_id);

	    $file_dir = APP_FILES . $appointmentKey . "/";          

        // For RTU Logo
        $path = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rtu_logo.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        $rtu_logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // RTU Logo

        // For QR Code
        $path = $file_dir . $file_keys[0] .'.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        $qr_code = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // QR Code

        date_default_timezone_set("Asia/Manila");
        $currentDateTime = new DateTime();
        $genDate = $currentDateTime->format("D, d F Y h:i a");
        
        $appData = getAppointmentDetails($app_id);
        $visitorData =  getVisitorDataByAppointmentId($app_id);
        $schedData = getScheduleDetailsByAppointmentId($app_id);

        $timeOffice = getValues($schedData[3], $schedData[2]); 

        $extension;
        $fullAddress;

        if($appData[5] == "Boni Campus") {
            $extension = ", City of Mandaluyong";
            $fullAddress = "Boni Ave, Mandaluyong, 1550 Metro Manila";
        } else {
            $extension = ", City of Pasig";
            $fullAddress = "510 Eusebio, Pasig, 1600 Metro Manila";
        }

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml("<html>
        <body style = 'font-family: Arial; font-size: 12px; margin-left: 5%; margin-right: 5%; line-height: 95%;'> 
            <span style = 'font-size: 8px; display: block;'>
                Date & Time Generated: " . $genDate . "
            </span
            <div align='center' style = 'margin-bottom: 2%;'> 
                <table cellspacing='0' cellpadding='0' style = 'width: 100%'>
                    <tbody>
                        <tr>
                            <td width='50' valign='top'>
                                <p>
                                    <img
                                        width='52'
                                        height='52'
                                        src= '" . $rtu_logo . "'
                                        alt='Rizal Technological University'
                                    
                                    />
                                </p>
                            </td>
                            <td width='260'>
                                <span style = 'font-size: 12px; display: block'> 
                                    Rizal Technological University
                                </span>
                                <span style = 'font-size: 12px;'>
                                    <strong>
                                        <em>Cities of Mandaluyong and Pasig</em>
                                    </strong>
                                    <em></em>
                                </span>
                            </td>
                            <td width='150'>
                                <div align = 'right'>
                                    <span style = 'font-size: 12px; display: block;'>
                                        <strong>RTU Online Appointment System</strong>
                                    </span>
                                    <span style = 'font-size: 12px;'>
                                        Printed Appointment Slip
                                    </span>
                                </div>
                                <br><br>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div align='center' style = 'margin-bottom: 5%; margin-left: 5%; margin-right: 5%;'>
                <table cellspacing='0' cellpadding='0' style = 'width: 100%'>
                    <tbody>
                        <tr>
                            <td valign='top' style = 'width: 60%;'>
                                <span style = 'font-size: 12px; display: block; margin-bottom: 3%'>
                                    <strong>Appointment No:</strong>
                                    " . $app_id . "
                                </span>
                                <span style = 'font-size: 12px; display: block'>
                                    " . $visitorData[2] . ", " . $visitorData[3] . "
                                </span>
                                <span style = 'font-size: 12px; display: block'>
                                    <em>" . $timeOffice["officeValue"] . "</em>
                                </span>
                                <span style = 'font-size: 12px; display: block; margin-bottom: 3%'>
                                    <strong>" . $appData[5] . $extension ."</strong>
                                </span>
                                <span style = 'font-size: 12px; display: block; '>
                                    <strong>" . date("F j, Y", strtotime($schedData[4]))  . "</strong>
                                </span>
                                <span style = 'font-size: 12px; display: block'>
                                    " . $timeOffice["timeValue"] . "
                                </span>
                                <br>
                                <span> <strong>Purpose</strong> </span>
                                <span style = 'font-size: 12px; display: block; margin-bottom: 3%'>
                                    " . $appData[6] . "
                                </span>
                                <span> Assisted by: <strong>______________</strong> </span>
                                <span style = 'display: block; margin-top: 1px'>
                                    Date: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>" . date("F j, Y", strtotime($schedData[4])) . "</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> 
                                </span>
                            </td>
                            <td width='20' valign = 'top' align = 'center' style = 'width: 40%;'>
                                <span style = 'display: block;'>
                                        <img
                                            width='123'
                                            height='123'
                                            src='". $qr_code ."'
                                            
                                        />
                                </span>
                                <span style = 'font-size: 10px; display: block; margin-bottom: 2%;'>
                                    <strong> " . $file_keys[2] ." </strong>
                                </span>
                                <span style = 'font-size: 12px;'>
                                    <strong style = 'font-size: 15px;'>" . $appData[5]  . "</strong>
                                    <span style = 'display: block; width: 100%'>" . $fullAddress . "<span>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p align='right'>
                <em><span>\"Forever true to the gold and blue~\"</span></em>
            </p>
            <br>
            <p align='center'>
                <strong>***<span style = 'margin-right: 2%; margin-left: 2%'>NOTHING FOLLOWS</span>***</strong>
            </p>
        </body>
    </html>");

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        if (ob_get_length()) ob_end_clean();
        // Output the generated PDF to Browser
        $output = $dompdf->output();
        file_put_contents($file_dir . $file_keys[1] .'.pdf', $output);


    }
    
?>