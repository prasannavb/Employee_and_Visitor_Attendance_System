<?php

$total_days = 0;
$present_days = 0;

function generateCalendarDate($first_date, $year, $month, $i, $data, $holiday)
{

    $month = $month < 10 ? "0" . $month : $month;
    $date = $i < 10 ? "0" . $i : $i;

    // Blank spaces
    if ($i == 0)
        echo "
            <div class='alert alert-light date'></div>    
        ";

    // Before Date of joining
    else if ($first_date != null && $first_date > $i)
        echo "
        <div class='alert alert-secondary date'>
            <h3>$i</h3>
        </div>    
        ";

    // Check for holidays
    else if(date("w",strtotime(date($year . "-" . $month . "-" .$i))) == 0){
        echo "
            <div class='alert alert-primary date'>
                <h3>$i</h3>
                <h5>Holiday</h5>
            </div>    
        ";
    }

    else if (isset($holiday["$year-$month-$date"])) {
        $reason = $holiday["$year-$month-$date"];
        echo "
            <div class='alert alert-primary date'>
                <h3>$i</h3>
                <h5>$reason</h5>
            </div>    
        ";
    } else if (isset($data[$i])) {
        $check_in = substr((string) ($data[$i]->check_in), 0, 5);
        $check_out = substr((string) ($data[$i]->check_out), 0, 5) == "00:00" ? "null" : substr((string) ($data[$i]->check_out), 0, 5);

        $GLOBALS['total_days']++;
        $GLOBALS['present_days']++;
        // Checked In But not Checked Out
        if ($check_out == "null") {
            echo "
                <form action='./' method='POST' class='alert alert-success date'>
                    <h3>$i</h3>
                    <h5 style='width:100%;text-align:center'>$check_in : <button class='btn btn-light check_in_out' type='submit'>LOG OFF</button></h5>
                    <input name='type' value='check_out' style='display:none;' />                       
                </form>
                ";
        }
        // Checked In and Out
        else
            echo "
                <div class='alert alert-success date'>
                    <h3>$i</h3>
                    <h5>$check_in : $check_out</h5>
                </div>
            ";
    }

    // Not Checked In
    else if ($month == date("m") && $year == date("Y") && $i == (int) date("d")) {
        $GLOBALS['total_days']++;
        echo "
            <form action='./' method='POST' class='alert alert-info date'>
                <h3>$i</h3>
                <button class='btn btn-light' type='submit'>LOG IN</button>     
                <input name='type' value='check_in' style='display:none;' />                       
            </form>
        ";
    }

    // Future dates
    else if ($month > date("m") || $year > date("Y") || ($month == date("m") && $year == date("Y") && $i > (int) date("d")))
        echo "<div class='alert alert-light date'>$i</div>";

    // Absent dates
    else {
        $GLOBALS['total_days']++;
        echo "<div class='alert alert-danger date'>$i</div>";
    }
}
