<?php
session_start();

if (!isset($_SESSION["emp_id"])) {
    header("Location: ../login");
}

$emp_id = $_SESSION['emp_id'];

// Database Connection
include_once("../dbConnection.php");

$sql = "SELECT * FROM employee_details WHERE emp_id = '$emp_id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLtc8BZ6ODkts0V0DHZ22rpI9pbM6Erydq3_bk7DWnsA&s' />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Hello <?php echo $row['emp_name'] ?>,</h2>

        <img class="photo" src="<?php echo $row['profile_photo_link'] ?>" alt="" srcset="">
    </header>

    <div class="profile-card">
        <section>
            <h3>My account</h3>
            <a href="../logout" class="btn btn-primary">Logout</a>
        </section>

        <!-- USER INFORMATION -->

        <div class="user-details">
            <label class="title">USER INFORMATION</label>
            <div class="user-detail-section">

                <div class="content">
                    <h6>Employee ID</h6>
                    <label class="value"><?php echo $row["emp_id"] ?></label>
                </div>
                <div class="content">
                    <h6>Name</h6>
                    <label class="value"><?php echo $row["emp_name"] ?></label>
                </div>

                <div class="content">
                    <h6>Email</h6>
                    <label class="value"><?php echo $row["email_id"] ?></label>
                </div>

                <div class="content">
                    <h6>DOB</h6>
                    <label class="value"><?php echo $row["date_of_birth"] ?></label>
                </div>

                <div class="line"></div>    
            </div>
        </div>

        <!-- CONTACT INFORMATION -->

        <div class="user-details">
            <label class="title">CONTACT INFORMATION</label>
            <div class="user-detail-section">
                <div class="content">
                    <h6>Address</h6>
                    <label class="value"><?php echo $row["address"]; ?></label>
                </div>

                <div class="content">
                    <h6>Contact Number</h6>
                    <label class="value"><?php echo $row["phone_number"] ?></label>
                </div>

                <div class="line"></div>    
            </div>
        </div>

        <!-- IDENTITY DETAILS -->

        <div class="user-details">
            <label class="title">IDENTITY DETAILS</label>
            <div class="user-detail-section">
                <div class="content">
                    <h6>Aadhar No</h6>
                    <label class="value"><?php echo substr($row["aadhar_no"],0,4) . " " . substr($row["aadhar_no"],4,4) . " " . substr($row["aadhar_no"],8,4) . " "; ?></label>
                </div>

                <div class="content">
                    <h6>PAN Card No</h6>
                    <label class="value"><?php echo $row["pan_no"] ?></label>
                </div>

                <div class="line"></div>    
            </div>
        </div>
    </div>
</body>
</html>