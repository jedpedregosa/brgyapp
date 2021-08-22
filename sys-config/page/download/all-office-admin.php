<?php 
    include_once($_SERVER['DOCUMENT_ROOT'] . "/sys-config/controllers/master.php");

    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/api/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;

    $path = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rtu_logo.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);

    $rtu_logo = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $office_table = getAllOfficeAdmin();
    $office_size = sizeof($office_table);


    $table ="";
    foreach($office_table as $office) {

        $table .= "<tr>
            <td class = 'itd'>" . $office[0] ." </td>
            <td class = 'itd'>" . $office[1] ." </td>
            <td class = 'itd'>" . $office[2] ." </td>
            <td class = 'itd'>" . $office[3] ." </td>
            <td class = 'itd'>" . $office[4] ." </td>
            <td class = 'itd'>" . $office[5] ." </td>
            <td class = 'itd'>" . $office[6] ." </td>
            <td class = 'itd'></td>
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
            <span style = 'display: block;'><strong>REPORT NAME:</strong> All Office Administrator</span>
            <span style = 'display: block;'><strong>REPORT FOR:</strong> " . $config_admin_id . ", <em>System Administrator</em></span>
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
                    <th class = 'ith'>For Office</th>
                    <th class = 'ith'>Username</th>
                    <th class = 'ith'>Last Name</th>
                    <th class = 'ith'>First Name</th>
                    <th class = 'ith'>Email</th> 
                    <th class = 'ith'>Contact No.</th> 
                    <th class = 'ith'>Date Created</th> 
                    <th class = 'ith' style = 'width: 10%'>Password</th> 
                </tr>
                " . $table . "
            </table>
        </div>
    </body>
    <span style = 'display: block; margin-top: 2%'><strong>Total of</strong> " . $office_size . " <em>Office Admin</em>(s).</span>
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
    $dompdf->stream("System_Report_All_Office_Admin_" . $file_date . ".pdf");

    exit(0);
?>