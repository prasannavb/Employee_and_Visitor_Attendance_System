<?php

// Database Connection
include_once("../dbConnection.php");

function faceVerification($image)
{
    $emp_id = $_SESSION["emp_id"];
    $sql = "SELECT profile_photo_link FROM employee_details WHERE emp_id = '$emp_id';";
    $result = mysqli_query($GLOBALS['con'], $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $profile = $row['profile_photo_link'];
    }

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://face-verification2.p.rapidapi.com/faceverification",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "image1Base64=$image&image2Base64=$profile",
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: face-verification2.p.rapidapi.com",
            "X-RapidAPI-Key: 437d8536fdmsh517633e7c412eb8p144a84jsn35b3e056ac89",
            "content-type: application/x-www-form-urlencoded"
        ],
    ]);


    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return $err;
    } else {
        $res = json_decode($response, true);
        if ($res["hasError"]) {
            return $res["statusMessage"];
        } else if (strpos($res["data"]["resultMessage"], "two faces belong to the same person")) {
            return "success";
        } else {
            return $res["data"]["resultMessage"];
        }
    }
}


function checkIn($image)
{
    $result = faceVerification($image);
    if ($result == "success") {
        $emp_id = $_SESSION["emp_id"];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $time = date("H:i:s", time());
        $sql = "INSERT INTO employee_attendance (emp_id,date,check_in_time,check_out_time) VALUES ('$emp_id','$date','$time','00:00:00')";
        $result = mysqli_query($GLOBALS['con'], $sql);
        header("Location: ../");
    } else
        return $result;
}


function checkOut($image)
{
    $result = faceVerification($image);
    if ($result == "success") {
        $emp_id = $_SESSION["emp_id"];
        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');
        $time = date("H:i:s", time());
        $sql = "UPDATE employee_attendance SET check_out_time = '$time' WHERE date = '$date' and emp_id = '$emp_id';";
        $result = mysqli_query($GLOBALS['con'], $sql);
        header("Location: ../");
    } else
        return $result;
}
