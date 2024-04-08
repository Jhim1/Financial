<?php 

require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

$client = new Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([Sheets::SPREADSHEETS_READONLY]);
$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Sheets($client);
$spreadsheetId = "1d_18QdALOQAJlYqGtpxySmgR2VzegTnl-km9uMNnUd0";
$range = "Form_Responses"; 

$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            
            <div class="card-header">
                <large class="card-title">
                    <b>Client Feedback</b>
                </large>
                <a  class="btn btn-primary btn-block col-md-2 float-right" href="https://docs.google.com/forms/d/e/1FAIpQLSc-Zxf3Ttd_naLtQehBzI5t-4caj_i7KxNxl-ecjucTGW1FVQ/viewform?usp=sf_link"> Report Link</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="loan-list">
                    <colgroup>
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Contact Number</th>
                            <th class="text-center">Comments</th>
                            <th class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1; 
                        if (!empty($values)) {
                            foreach ($values as $row) {
                                 if ($i > 1) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i - 1; ?>
                            <td class="text-center">
                                <b><?php echo ucwords($row[1].", ".$row[2].' '.$row[3]) ?></b>
                            </td>
                            <td class="text-center">
                                <?php echo $row[4]; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $row[5]; ?>
                            </td>
                             <td class="text-center">
                                <?php echo $row[6]; ?>
                            </td>
                            <td class="text-center">
                                <?php echo $row[0]; ?>
                            </td>
                        </tr>
                           <?php 
                                }
                                $i++; 
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No data found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    td p {
        margin: unset;
    }
    td img {
        width: 8vw;
        height: 12vh;
    }
    td {
        vertical-align: middle !important;
    }
</style>
