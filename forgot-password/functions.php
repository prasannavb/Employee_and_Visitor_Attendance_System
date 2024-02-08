<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
@include_once("../dbConnection.php");
function checkWhetherUserEmailIdExists($email_id)
{
    $sql = "SELECT * FROM employee_details WHERE email_id = '$email_id'";
    $result = mysqli_query($GLOBALS['con'], $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}


function sendMail($email)
{
    $otp = rand(10000, 99999);
    $email_id = $_SESSION['change_password_email_id'];
    $sql = "INSERT INTO otp_table VALUES('$email_id','$otp') ON DUPLICATE KEY UPDATE otp = '$otp';";
    $result = mysqli_query($GLOBALS['con'], $sql);

    $mail = new PHPMailer(TRUE);
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com;';
        $mail->SMTPAuth = true;

        // Mail ID and App password
        $mail->Username = 'plsquared04@gmail.com';
        $mail->Password = 'yzadwtbylzylravp';


        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('plsquared04@gmail.com', 'BlueBase');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'OTP for Forgot password';
        $mail->Body = "Your OTP for forgot password is : <b>$otp</b> ";
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
    } catch (Exception $e) {
        header("Location: ../forgot-password?error=$mail->ErrorInfo");
    }
}

function verifyOTP($user_otp)
{
    $email_id = $_SESSION['change_password_email_id'];
    $sql = "SELECT * FROM otp_table WHERE email_id = '$email_id';";
    $result = mysqli_query($GLOBALS['con'], $sql);
    $row = mysqli_fetch_array($result);
    $otp = $row["otp"];
    $status = $otp == (int) $user_otp ? true : false;
    if ($status) {
        $sql = "DELETE FROM otp_table WHERE email_id = '$email_id';";
        $result = mysqli_query($GLOBALS['con'], $sql);
    }
    return $status;
}


function changePassword($password)
{
    $email_id = $_SESSION['change_password_email_id'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM employee_details WHERE email_id = '$email_id'";
    $result = mysqli_query($GLOBALS["con"], $sql);
    $row = mysqli_fetch_array($result);
    $emp_id = $row["emp_id"];

    $sql = "UPDATE login SET password = '$password' WHERE emp_id = '$emp_id'";
    mysqli_query($GLOBALS["con"], $sql);
}