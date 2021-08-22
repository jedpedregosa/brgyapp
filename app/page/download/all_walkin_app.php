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

    $appointees_table = getWalkinAppointments($assigned_office);
    $appointees_size = sizeof($appointees_table);


    $table ="";
    foreach($appointees_table as $appointees) {
        $date_to_show = new DateTime($appointees[1]);
        $date_to_show = $date_to_show->format("M d, Y");

        $type = "";
        if($appointees[11] == "student") {
            $type = "Student (RTU)";
        } else if ($appointees[11] == "employee") {
            $type = "Employee (RTU)";
        } else {
            $type = $appointees[11];
        }

        $table .= "<tr>
            <td class = 'itd'>" . $appointees[0] ." </td>
            <td class = 'itd'>" . $appointees[8] ." </td>
            <td class = 'itd'>" . $appointees[6] ." </td>
            <td class = 'itd'>" . $appointees[7] ." </td>
            <td class = 'itd'>" . $appointees[9] ." </td>
            <td class = 'itd'>" . $appointees[10] ." </td>
            <td class = 'itd'>" . $date_to_show ." </td>
            <td class = 'itd'>" . $appointees[2] ." </td>
            <td class = 'itd'>" . $appointees[3] ." </td>
            <td class = 'itd'>" . $type ." </td>
            <td class = 'itd'>" . $appointees[5] ." </td>
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
            <span style = 'display: block;'><strong>NAME:</strong> All Walk-in Appointments</span>
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
                    <th class = 'ith'>Appointment No.</th>
                    <th class = 'ith'>Identification No.</th>
                    <th class = 'ith'>Last Name</th>
                    <th class = 'ith'>First Name</th>
                    <th class = 'ith'>Contact Number</th>
                    <th class = 'ith'>Email Address</th>
                    <th class = 'ith'>Date</th>
                    <th class = 'ith'>Time</th>
                    <th class = 'ith'>Purpose</th>
                    <th class = 'ith'>Identification Type</th>
                    <th class = 'ith'>Date & Time of Walk-in Visit</th>    
                </tr>
                " . $table . "
            </table>
        </div>
    </body>
    <span style = 'display: block; margin-top: 2%'><strong>Total of</strong> " . $appointees_size . " <em>Walk-in Appointment</em>(s).</span>
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
    $dompdf->stream("Walk-in_Appointments" . $assigned_office . "_" . $file_date . ".pdf");

    exit(0);
?>
