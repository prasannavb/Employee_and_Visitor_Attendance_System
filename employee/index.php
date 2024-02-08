<?php
session_start();

if (!isset($_SESSION["emp_id"])) {
    header("Location: ../login");
}

// Database details
include_once("../dbCOnnection.php");

// Generate Calendar for a month
include_once("generateCalendar.php");

// Generate Holiday dates
include_once("generateHolidayDates.php");

// Functions
include_once("./functions.php");


class details
{
    public $date;
    public $check_in;
    public $check_out;
}

//user_id
$emp_id = $_SESSION["emp_id"];


// Variables - begin
$GLOBALS["check_in_open_camera"] = false;
$GLOBALS["check_out_open_camera"] = false;
$verification_error = "";

$mon_arr = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$day_arr = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

$month = isset($_REQUEST['month']) ? $_REQUEST['month'] : date("n");
$year = isset($_REQUEST['year']) ? $_REQUEST['year'] : date("Y");

// First date of this month
$date = strtotime("$year-$month-1");

// First day of the month
$start_date = date("w", $date);

// No of days in the month
$end_date = date("t", $date);

// Today date
$today_date = date("d");

// Variables - end



// Check In and Check Out Verification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["image"])) {
    $image = $_POST["image"];
    if ($_POST["type"] == "check_in") {
        $GLOBALS['verification_error'] = checkIn($image);
        $GLOBALS["check_in_open_camera"] = true;
    } else {
        $GLOBALS['verification_error'] = checkOut($image);
        $GLOBALS["check_out_open_camera"] = true;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['type'] == "check_in")
        $GLOBALS["check_in_open_camera"] = true;
    else
        $GLOBALS["check_out_open_camera"] = true;
}


// Fetching Date of joining
$sql = "SELECT date_of_joining FROM employee_details WHERE emp_id = '$emp_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$dateOfJoining = strtotime($row["date_of_joining"]);
$month_of_joining = date("n", $dateOfJoining);
$year_of_joining = date("Y", $dateOfJoining);
$first_date = null;


// Avg working hours
$avg_working_time = 0;
$sql = "SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(`check_out_time`) - TIME_TO_SEC(`check_in_time`))) as stats FROM `employee_attendance` WHERE check_out_time != '00:00:00' GROUP BY emp_id HAVING emp_id = '$emp_id';";
$result = mysqli_query($con, $sql);
if ($row = mysqli_fetch_array($result)) {
    $avg_working_time = $row["stats"];
    $avg_working_time = (int)number_format(substr($avg_working_time, 0, 2)) + round(number_format(substr($avg_working_time, 3, 2)) / 60, 1);
}

// If date of joining is not this month then go to date of joining month
if (strtotime(date("$year_of_joining-$month_of_joining-1")) > strtotime(date("$year-$month-1"))) {
    header("Location: ./?month=$month_of_joining&year=$year_of_joining");
}

// If date of joining is this month then block before dates
if (strtotime(date("$year_of_joining-$month_of_joining-1")) == strtotime(date("$year-$month-1"))) {
    $GLOBALS['first_month'] = true;
    $GLOBALS['first_date'] = date("j", $dateOfJoining);
}

// Get Employee Name from DB
$sql = "SELECT emp_name FROM employee_details WHERE emp_id = '$emp_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$emp_name = $row["emp_name"];


// Update Attendace till Yesterday
$system_date = Date("Y-m-d");
$sql = "DELETE FROM employee_attendance WHERE date < '$system_date' and check_out_time = '00:00:00'";
mysqli_query($con, $sql);


// Get the attendance from DB for this month
$sql = "SELECT * FROM employee_attendance WHERE date >= '$year-$month-01' and date <= '$year-$month-31' and emp_id = '$emp_id'";
$result = mysqli_query($con, $sql);

//Monthly employee_details data
$data = array();

while ($row = mysqli_fetch_array($result)) {
    $user_det = new details();
    $user_det->date = strtotime($row["date"]);
    $user_det->check_in = $row["check_in_time"];
    $user_det->check_out = $row["check_out_time"];
    $data[(int) date("d", $user_det->date)] = $user_det;
}

// Get the holiday dates from DB
$holiday = generateHolidayDates($year, $month);

?>
<html lang="en">

<head>
    <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLtc8BZ6ODkts0V0DHZ22rpI9pbM6Erydq3_bk7DWnsA&s' />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <!-- Webcam CDN -->
    <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav>
        <img src="../assests/image-removebg.png" alt="no-image">

        <a href="../profile" class="profile">
            <span class="material-symbols-outlined">
                person_edit
            </span>
            <h6 id="name"><?php echo $emp_name ?></h6>
        </a>

    </nav>

    <div class="container1" style="<?php if ($check_in_open_camera || $check_out_open_camera) echo "opacity:0.5"; ?>">
        <div class="calendar">
            <div class="header">

                <a href=<?php echo './?month=' . ($month - 1 < 1 ? 12 : $month - 1) . '&year=' . ($month == 1 ? $year - 1 : $year) ?> style="<?php if ($first_month) echo "pointer-events:none" ?>">
                    <span class='material-symbols-outlined'>
                        arrow_back_ios
                    </span>
                </a>

                <?php
                echo "<h4 class='month'>{$mon_arr[$month - 1]} - {$year}</h4>";
                ?>

                <a href="<?php echo './?month=' . ($month + 1 > 12 ? 1 : $month + 1) . '&year=' . ($month == 12 ? $year + 1 : $year) ?>">
                    <span class="material-symbols-outlined">
                        arrow_forward_ios
                    </span>
                </a>
            </div>

            <div class='cal_header'>
                <?php
                for ($i = 0; $i < 7; $i++) {
                    echo "<h5 class='day'>$day_arr[$i]</h5>";
                }
                ?>
            </div>

            <div class="dates">
                <?php
                $extra = [];
                if ($start_date == 5 and $end_date == 31) {
                    $extra = [31, 0, 0, 0, 0, 0, 0];
                    $end_date = 30;
                } else if ($start_date == 6 and $end_date == 31) {
                    $extra = [30, 31, 0, 0, 0, 0, 0];
                    $end_date = 29;
                } else if ($start_date == 6 and $end_date == 30) {
                    $extra = [30, 0, 0, 0, 0, 0, 0];
                    $end_date = 29;
                } else {
                    $extra = [0, 0, 0, 0, 0, 0, 0];
                }

                for ($i = 0; $i < $start_date; $i++) {
                    generateCalendarDate($first_date, $year, $month, $extra[$i], $data, $holiday);
                }


                for ($i = 1; $i <= $end_date; $i++) {
                    generateCalendarDate($first_date, $year, $month, $i, $data, $holiday);
                }

                for ($i = ($start_date + $end_date) + 1; $i < 36; $i++)
                    generateCalendarDate($first_date, $year, $month, 0, $data, $holiday);
                ?>
            </div>
        </div>


        <div class="stats">
            <div class="sub-stats">
                <span class="material-symbols-outlined">
                    calendar_clock
                </span>
                <div class='avg_working_time'>
                    <h2><?php echo $avg_working_time  ?>hrs</h2>
                    <h5>per day</h5>
                </div>
            </div>

            <div id="attendance" class="sub-stats">
                <h4><?php echo $mon_arr[$month - 1] ?> attendance</h4>
                <canvas id="piechart"></canvas>
            </div>
        </div>

    </div>

    <!-- Check In Verification -->

    <?php
    if ($check_in_open_camera)
        echo "
        <div class='check_in_verify'>
            <form action='./' method='POST' onsubmit='return handleImage();' class='check_in_container'>";
    if ($check_in_open_camera && trim($verification_error) != '')
        echo "
            <div class='alert alert-danger check_in_alert'>$verification_error</div>";

    if ($check_in_open_camera)
        echo "
                <video id='webcam' autoplay></video>
                <canvas id='canvas'></canvas>
                <div class='buttons'>
                    <a href='./' class='btn close'>
                        <span class='material-symbols-outlined'>
                            close
                        </span>
                        CLOSE
                    </a>
                    <button class='btn check_in' type='submit'>
                        <span class='material-symbols-outlined'>
                            camera
                        </span>
                        CHECK IN
                    </button>
                </div>
                <input name='type' value='check_in' style='display:none;' />
                <!-- Base64 Image -->
                <input id='image' type='text' name='image' style='display:none' />
            </form>
        </div>";
    ?>

    <!-- Check Out Verification -->


    <?php

    if ($check_out_open_camera)
        echo "<div class='check_in_verify'>
        <form action='./' method='POST' onsubmit='return handleImage();' class='check_in_container'>";
    if ($check_out_open_camera && trim($verification_error) != '')
        echo "<div class='alert alert-danger check_in_alert'>$verification_error</div>";

    if ($check_out_open_camera)
        echo "
            <video id='webcam' autoplay></video>
            <canvas id='canvas'></canvas>
            <div class='buttons'>
                <a href='./' class='btn close'>
                    <span class='material-symbols-outlined'>
                        close
                    </span>
                    CLOSE
                </a>
                <button class='btn check_in' type='submit'>
                    <span class='material-symbols-outlined'>
                        camera
                    </span>
                    CHECK OUT
                </button>
            </div>
            <input name='type' value='check_out' style='display:none;' />
            <!-- Base64 Image -->
            <input id='image' type='text' name='image' style='display:none' />
        </form>
    </div>";

    ?>


    <!-- Javascript code -->
    <script>
        var xValues = ["Present", "Absent"];
        var yValues = [<?php echo  $present_days ?>, <?php echo $total_days - $present_days ?>];
        var barColors = [
            "#3B2747",
            "#ffff",
        ];

        new Chart("piechart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            }
        });


        const webcamElement = document.getElementById('webcam');
        const canvasElement = document.getElementById('canvas');
        const webcam = new Webcam(webcamElement, 'user', canvasElement);

        <?php

        if ($check_in_open_camera || $check_out_open_camera)
            echo "webcam.start()
            .then(result => {})
            .catch(err => {
                console.log(err);
            });";
        else
            echo "webcam.stop();"

        ?>

        function handleImage() {
            document.getElementById("image").value = webcam.snap();
            return true;
        }
    </script>
</body>

</html>