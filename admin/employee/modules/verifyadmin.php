<?php
function verifyadmin($pwd)
{
    include_once '.../../../../../db_connection.php';
    $conn = OpenCon();
    $admin_id = "BBAD01";
    $query = "SELECT * FROM `login` WHERE emp_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($emp_id, $password);
    if ($stmt->num_rows > 0) {
        while ($stmt->fetch()) {
            if (password_verify($pwd, $password)) {
                $stmt->close();
                CloseCon($conn);
                return true;
            }
        }
        
    }    
    return false;
}
?>