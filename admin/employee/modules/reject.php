<?php
function reject_employee()
{
    include '.../../../../../db_connection.php';
    $conn = OpenCon();
    $reason = $_POST['reject_reason'];
    $clickedEmailID = $_POST['reject_btn'];
    $insertQuery = "INSERT INTO `rejected_employee_details` (email_id,reason) 
                                    VALUES (?,?)";
    $stmtInsert = $conn->prepare($insertQuery);
    $stmtInsert->bind_param("ss", $clickedEmailID, $reason);
    $stmtInsert->execute();
    $deleteQuery = "DELETE FROM `pending_employee_details` WHERE email_id=?";
    $stmtDelete = $conn->prepare($deleteQuery);
    $stmtDelete->bind_param("s", $clickedEmailID);
    $stmtDelete->execute();
    $stmtInsert->close();
    $stmtDelete->close();
    CloseCon($conn);
    echo "<div class='notification is-danger SignUp-Success' style='width: 25%;
    position: absolute !important;
    bottom: 10%;
    right: 1% !important;'>Employee Request rejected</div>";
    echo "
        <script>
        setTimeout(()=>{
        window.location.href='./';
    },2000)
    </script>
    ";
}
?>