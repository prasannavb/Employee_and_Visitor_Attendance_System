<?php
function getCheckInOutData()
{
    include_once("../db_connection.php");
    $conn = OpenCon();
    $currentMonth = date('m');
    $currentYear = date('Y');
    $query = "SELECT date, SEC_TO_TIME(AVG(TIME_TO_SEC(check_out_time))) AS avg_check_out, SEC_TO_TIME(AVG(TIME_TO_SEC(check_in_time))) AS avg_check_in FROM `employee_attendance` WHERE YEAR(date) = ? AND MONTH(date) = ?";
    $check_in_out_stmt = $conn->prepare($query);
    $check_in_out_stmt->bind_param("ss",$currentYear,$currentMonth);
    $check_in_out_stmt->execute();
    $check_in_out_stmt->store_result();
    $check_in_out_stmt->bind_result($date, $avg_check_out, $avg_check_in);
    $analytics_data = array();
    if ($check_in_out_stmt->num_rows > 0) { 
        while ($check_in_out_stmt->fetch()) {
            $key_date = $date;
            $analytics_data[$key_date] = array("avg_check_in" => $avg_check_in, "avg_check_out" => $avg_check_out);
        }
        $check_in_out_stmt->close();
    } else {
        $analytics_data[$date] = array("avg_check_in" => "09:00:00", "avg_check_out" => "18:00:00");
    }
    CloseCon($conn);
    return $analytics_data;
}

?>