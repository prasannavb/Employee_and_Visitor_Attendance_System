<?php
function edit_profile($emp_id)
{
    $edited_name = filter_input(INPUT_POST, 'edit_emp_name', FILTER_SANITIZE_STRING);
    $edited_address = filter_input(INPUT_POST, 'edit_emp_address', FILTER_SANITIZE_STRING);
    $edited_aadhar = filter_input(INPUT_POST, 'edit_emp_aadhar', FILTER_VALIDATE_INT);
    $edited_phone = filter_input(INPUT_POST, 'edit_emp_phone', FILTER_VALIDATE_INT);
    $edited_email = filter_input(INPUT_POST, 'edit_emp_email', FILTER_SANITIZE_EMAIL);
    $edited_pan = filter_input(INPUT_POST, 'edit_emp_pan', FILTER_SANITIZE_STRING);
    $edited_dob = filter_input(INPUT_POST, 'edit_emp_bday', FILTER_SANITIZE_STRING);
    $edited_photo = filter_input(INPUT_POST, 'edit_emp_pic', FILTER_SANITIZE_URL);
    include_once '.../../../../../db_connection.php';
    $conn = OpenCon();
    $stmt = $conn->prepare('UPDATE `employee_details`
    SET emp_name=?,date_of_birth=?,address=?,email_id=?,aadhar_no=?,pan_no=?,profile_photo_link=?,phone_number=?
    WHERE emp_id=?');
    $stmt->bind_param('ssssissis', $edited_name, $edited_dob, $edited_address, $edited_email, $edited_aadhar, $edited_pan, $edited_photo, $edited_phone, $emp_id);
    $stmt->execute();
    $stmt->close();
    CloseCon($conn);
    echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-success'>Successfully edited $emp_id records!</h1>
                    </div>";
}
?>