<?php
session_start();

$emp_id = "";
$user_password = "";
$error_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $GLOBALS['emp_id'] = $_POST["emp_id"];
    $GLOBALS['user_password'] = $_POST["password"];
    $type = $_POST["type"];

    if (trim($emp_id) == "")
        $error_msg = "Enter your employee_details ID";
    else if (trim($user_password) == "")
        $error_msg = "Enter your Password";
    else if (trim($type) == "")
        $error_msg = "Select the type of user";
    else if (($type == "admin" && substr($emp_id, 0, 4) != "BBAD") || ($type == "employee" && substr($emp_id, 0, 4) != "BBEM"))
        $error_msg = "Invalid User ID";
    else {

        // Database Connection
        include_once("../dbConnection.php");

        $sql = "SELECT * FROM login WHERE emp_id='$emp_id'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
            if (password_verify($user_password, $row["password"])){
                $_SESSION["emp_id"] = $emp_id;
                header("Location: ../");
            }
            else
                $error_msg = "Invalid Password";
        } else
            $error_msg = "Invalid User ID";
        $con->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLtc8BZ6ODkts0V0DHZ22rpI9pbM6Erydq3_bk7DWnsA&s' />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="outer-box-1"></div>
    <div class="outer-box"></div>
    <div class="form-section">
        <div class="company-section">
            <img class="company-logo" src="../assests/image-removebg.png" alt="sdas" />
        </div>

    <form action="./index.php" method="post">
        <?php
        if (trim($error_msg) != ""){
            echo "
                    <div class='alert alert-danger error-msg'>$error_msg</div>    
                ";}
                ?>
            <h3>Login</h3>
            <label for="emp_id">Employee ID</label>
            <input class="form-control w-100" name="emp_id" id="empid" placeholder="Employee ID"  autocomplete="off" value='<?php echo $emp_id ?>'/>
            <label for="emp_id">Password</label>
            <input class="form-control w-100" type="password" name="password" id="password" placeholder="Password" value='<?php echo $user_password ?>' />
            <section>
            <select class="form-select w-50" name="type">
                <option value="employee">Employee</option>
                <option value="admin">Admin</option>
            </select>
            <a class="w-50 forgot " href="../forgot-password">Forgot Password?</a>
            </section>
            <button type="submit" class="btn w-100 login-btn">Login</button>
            <a class="sign_up_page" href="../visitors/SignUp">Create an account</a>
            <a class="sign_up_page" href="../visitors/Form">Just Visiting?</a>
        </form>
        </div>
    </body>
    </html>