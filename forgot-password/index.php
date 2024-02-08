<?php
session_start();

@include_once('./functions.php');

$page = 'email_page';
$error_msg = "";
$email = "";
$digit_1 = "";
$digit_2 = "";
$digit_3 = "";
$digit_4 = "";
$digit_5 = "";

$password = "";
$cpassword = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    if ($type == 'email_page') {
        $email = $_POST["email"];
        if (checkWhetherUserEmailIdExists($email)) {
            $_SESSION["change_password_email_id"] = $email;
            $page = "otp_page";
            sendMail($email);
        } else {
            $error_msg = "Email ID does not exist";
        }
    } else if ($type == "otp_page") {
        $GLOBALS['digit_1'] = $_POST["digit_1"];
        $GLOBALS['digit_2'] = $_POST["digit_2"];
        $GLOBALS['digit_3'] = $_POST["digit_3"];
        $GLOBALS['digit_4'] = $_POST["digit_4"];
        $GLOBALS['digit_5'] = $_POST["digit_5"];
        $user_otp = $digit_1 .  $digit_2 .  $digit_3 .  $digit_4 .  $digit_5;
        if (verifyOTP($user_otp)) {
            $page = "change_password";
        } else {
            $page = "otp_page";
            $error_msg = "Incorrect OTP";
        }
    } else {
        $GLOBALS['password'] = $_POST["password"];
        $GLOBALS['cpassword'] = $_POST["c_password"];
        if (trim($GLOBALS["password"]) == "") {
            $error_msg = "Enter the password";
            $page = "change_password";
        } else if (trim($GLOBALS['cpassword'] == "")) {
            $error_msg = "Enter the confirm password";
            $page = "change_password";
        } else if ($GLOBALS['password'] == $GLOBALS['cpassword']) {
            changePassword($GLOBALS['password']);
            header("Location: ../");        
        } else {
            $error_msg = "Password does not match";
            $page = "change_password";
        }
    }
}

?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLtc8BZ6ODkts0V0DHZ22rpI9pbM6Erydq3_bk7DWnsA&s' />
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    //  Form page to enter email
    if ($page == 'email_page')
        echo "
        <div class='email_page_form'>
            <form class='email_form' name='form' action='./' method='POST'>
                <h2>Forgot Password</h2>
                <p>Enter your email and we'll send an OTP to verify the account</p>
                <div class='input-group'>
                    <span class='material-symbols-outlined input-group-text'>
                        mail
                    </span>
                    <input type='email' class='form-control' name='email' placeholder='Email' value='$email' autocomplete = 'off'>
                </div>
                <label class='error-msg'>$error_msg</label>
                <input name='type' value='email_page' hidden />
                <button class='btn w-100 btn' type='submit'>GET OTP</button>
            </form>
        </div>";

    // OTP page
    else if ($page == "otp_page")
        echo "
        <div class='otp_form_container'>
            <form class = 'otp_form' name='form' action='./' method='POST'>
                <h2>OTP Verification</h2>
                <p>Enter OTP sent to your registered email</p>
                <div class='input' id='inputs'>
                    <input type='text' inputmode='numeric' name='digit_1' maxlength='1' autocomplete='off' value=$digit_1>
                    <input type='text' inputmode='numeric' name='digit_2' maxlength='1' autocomplete='off' value=$digit_2>
                    <input type='text' inputmode='numeric' name='digit_3' maxlength='1' autocomplete='off' value=$digit_3>
                    <input type='text' inputmode='numeric' name='digit_4' maxlength='1' autocomplete='off' value=$digit_4>
                    <input type='text' inputmode='numeric' name='digit_5' maxlength='1' autocomplete='off' value=$digit_5>
                </div>
                <label class='error-msg'>$error_msg</label>
                <input name='type' value='otp_page' hidden/>
                <button class='btn otp_btn' type='submit'>Verify & Proceed</button>
            </form>
        </div>
        ";

    else {
        echo "
        <div class='form'>
            <form name='change_password_form' action='./' method='POST'>";
        if ($error_msg != "")
            echo "<div class='alert alert-danger' id='msg'>$error_msg</div>";
        echo "      <h2>Change Password</h2>
                <div class='input-group password'>
                    <span class='material-symbols-outlined input-group-text'>
                        lock
                    </span>
                    <input class='form-control' type='password' name='password' placeholder='Password' value=$password>
                </div>
                <div class='input-group password'>
                    <span class='material-symbols-outlined input-group-text'>
                        lock
                    </span>
                    <input class='form-control' type='text' name='c_password' placeholder='Confirm Password' value=$cpassword>
                </div>
                <input name='type' value='change_password' hidden/>
                <button class='btn'>CHANGE PASSWORD</button>
            </form>
        </div>
        ";
    }
    ?>

    <!-- JavaScript Code -->
    <script src="./index.js"></script>
</body>

</html>