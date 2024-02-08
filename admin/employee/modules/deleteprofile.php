<?php


function delete_profile($emp_id)
{
    include_once '.../../../../../db_connection.php';
    $conn = OpenCon();
    $stmt = $conn->prepare('DELETE FROM `employee_details` WHERE emp_id=?');
    $stmt->bind_param('s', $emp_id);
    $stmt->execute();
    $stmt->close();
    $stmt2 = $conn->prepare('DELETE FROM `employee_attendance` WHERE emp_id=?');
    $stmt2->bind_param('s', $emp_id);
    $stmt2->execute();
    $stmt2->close();
    $stmt3 = $conn->prepare('DELETE FROM `login` WHERE emp_id=?');
    $stmt3->bind_param('s', $emp_id);
    $stmt3->execute();
    $stmt3->close();
    CloseCon($conn);
    echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-success'>Successfully deleted $emp_id records!</h1>
                    </div>";
}
?>