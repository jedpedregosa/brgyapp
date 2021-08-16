<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/dbase.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Appointment.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/app/controllers/master.php");

    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/api/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    $path = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rtu_logo.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);

    $rtu_logo = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $feedback_data = getAllFeedback($assigned_office);
    $feedback_size = sizeof($feedback_data);


    $table ="";
    foreach($feedback_data as $feedback) {
        
        $isSatisfied = "UNSATISFIED";
        if($feedback["fback_is_stsfd"]) {
            $isSatisfied = "SATISFIED";
        }
        $table .= "<tr>
            <td class = 'itd'>" . htmlspecialchars($feedback["fback_fname"]) ." </td>
            <td class = 'itd'>" . htmlspecialchars($feedback["fback_contact"]) ." </td>
            <td class = 'itd'>" . htmlspecialchars($feedback["fback_email"]) ." </td>
            <td class = 'itd'>" . htmlspecialchars($feedback["fback_msg"]) ." </td>
            <td class = 'itd'>" . htmlspecialchars(strtoupper($feedback["fback_cat"])) ." </td>
            <td class = 'itd'>" . htmlspecialchars($feedback["fback_sys_time"]) ." </td>
            <td class = 'itd'>" . $isSatisfied ." </td>
        </tr>";
    }

    $cr_date = new DateTime();
    $gen_date = $cr_date->format("D, d F Y h:i a");
    
    $report_date = $cr_date->format("l, d F Y h:i:s A");
    $file_date = $cr_date->format("Ymdhis");

    $office_name = getOfficeName($assigned_office);
	$campus_name = getCampusName($assigned_office);

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
            <span style = 'display: block; margin-bottom: 3%;'><strong>DATE:</strong> " . $report_date . "</span>
            <span style = 'display: block;'><strong>NAME:</strong> All Feedbacks</span>
            <span style = 'display: block;'><strong>FOR OFFICE:</strong> <em>" . $office_name . "</em>, " . $campus_name . "</span>
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
                    <th class = 'ith'>Full Name</th>
                    <th class = 'ith'>Contact No.</th>
                    <th class = 'ith'>Email</th>
                    <th class = 'ith'>Feedback Message</th>
                    <th class = 'ith'>User Category</th>
                    <th class = 'ith'>System Time</th>
                    <th class = 'ith'>Reaction</th>
                </tr>
                " . $table . "
            </table>
        </div>
    </body>
    <span style = 'display: block; margin-top: 2%'><strong>Total of</strong> " . $feedback_size . " <em>Feedback</em>(s).</span>
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
    $dompdf->stream("All_Feedbacks" . $assigned_office . "_" . $file_date . ".pdf");

    exit(0);
?>
