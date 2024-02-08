<!DOCTYPE html>
<html lang="en">

<head>
    <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLtc8BZ6ODkts0V0DHZ22rpI9pbM6Erydq3_bk7DWnsA&s' />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Document</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["holiday_data"])) {
            $file_name = "holiday.xlsx";
            $file_tmp = $_FILES["holiday_data"]["tmp_name"];
            $file_size = $_FILES["holiday_data"]["size"];
            $file_type = $_FILES["holiday_data"]["type"];
            $upload_dir = "./uploads/";
            $upload_path = $upload_dir . $file_name;
            if (move_uploaded_file($file_tmp, $upload_path)) {

                require_once '../../vendor/autoload.php';
                include_once('../../dbConnection.php');

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $filename = './uploads/holiday.xlsx';
                $spreadsheet = $reader->load($filename);

                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                unset($rows[0]);
                foreach ($rows as $row) {
                    // echo $row[0] . " " . $row[1];
                    $date = date("Y-m-d", strtotime(date($row[0])));
                    $sql = "INSERT INTO company_holidays VALUES('$date','$row[1]') ON DUPLICATE KEY UPDATE reason = '$row[1]';";
                    $result = mysqli_query($con, $sql);
                }
                echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-primary'>Data uploaded successfully!</h1>
                    </div>";
            } else {
                echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>Data upload unsuccessful.</h1>
                    </div>";
            }

        } else {
            echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>File is empty!</h1>
                    </div>";
        }
    }
    ?>

</body>

</html>