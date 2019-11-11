<?php
// including db config file
include_once 'config/db-config.php';


$db = new DBController();

$conn = $db->connect();


$csv_array = Array();
$file = fopen($_FILES['upload_file']['tmp_name'], 'r');
if ($file) {
    while (($line = fgetcsv($file)) !== FALSE) {
        //$line is an array of the csv elements
        array_push($csv_array, $line);
    }
    fclose($file);
}

/* Map Rows and Loop Through Them */
$rows = array_map('str_getcsv', file('file.csv'));
$header = array_shift($rows);
$csv = array();
foreach ($rows as $row) {
    $csv[] = array_combine($header, $row);
}


?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <?php
    $arr = array();

    foreach ($csv_array as $key => $item) {
        $arr[$item[0]][$key] = $item;


    } ?>


    <table class="table table-dark" style="margin-bottom: 1px">
        <thead>
        <tr>
            <th style="width: 200px"><?= 'Customer_ID' ?></th>
            <th style="width: 200px"><?= 'Number of customer\'s calls within same continen' ?></th>
            <th style="width: 200px"><?= 'Total duration of customer\'s calls within same continent' ?></th>
            <th style="width: 200px"><?= 'Number of all customer\'s calls' ?></th>
            <th style="width: 200px"><?= 'Total duration of all customer\'s calls' ?></th>
        </tr>
        </thead>
    </table>

    <?php foreach ($arr as $key => $csvs) {


        switch ($key) {
            case $key:

                foreach ($csvs as $csv) {

                    $cod = substr($csv[3], 0, 3);
                    $sql = "SELECT name, continent FROM  countryInfo WHERE  Phone = $cod ";
                    $result = mysqli_query($conn, $sql);
                    $row = $result->fetch_assoc();
                    $ip = $csv[4];
                    $access_key = 'a1bfda53abdf4f0cc80870e5cdef6116';
                    // Initialize CURL:
                    $ch = curl_init('http://api.ipstack.com/' . $ip . '?access_key=' . $access_key . '');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    // Store the data:
                    $json = curl_exec($ch);
                    curl_close($ch);
                    // Decode JSON response:
                    $api_result = json_decode($json, true);
                    $calls += 1;
                    if ($api_result['continent_code'] == $row['continent']) {
                        $sum += 1;

                        $time += $csv[2];

                    }
                    $totaltime += $csv[2];

                } ?>

                <table class="table table-dark" style="margin-bottom: 1px" ;>

                    <tbody>
                    <tr>
                        <td style="width: 200px"><?= $key ?></td>
                        <td style="width: 200px"><?= $sum ?></td>
                        <td style="width: 200px"><?= $time ?></td>
                        <td style="width: 200px"><?= $calls ?></td>
                        <td style="width: 200px"><?= $totaltime ?></td>
                    </tr>

                    </tbody>
                </table>


                <?php
                $sum = 0;
                $totaltime = 0;
                $time = 0;
                $calls = 0;
                break;

        }

    } ?>

</head>
<body>

</body>
</html>