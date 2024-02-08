<?php


function generateHolidayDates($year, $month){
    // Database Connection
    include "../dbConnection.php";

    $month = $month < 10 ?"0". $month : $month;

    $sql = "SELECT * FROM company_holidays WHERE holiday_date >= '$year-$month-01' and holiday_date <= '$year-$month-31';";
    $result = mysqli_query($con,$sql);

    $res = [];
    while($row = mysqli_fetch_array($result)){
        $res[$row['holiday_date']] = $row["reason"];
    }
    return $res;
}

?>