<?php
function view_employee_attendance($search_emp_id)
{
    include '.../../../../../db_connection.php';
    $conn = OpenCon();
    $month = date('Y-m');
    if (isset($_POST["selectedMonth"])) {
        $month = $_POST["selectedMonth"];
    }
    $currentMonth = date('Y-m');
    $dateTime = DateTime::createFromFormat('Y-m', $month);
    $formattedMonth = $dateTime->format('F Y');
    echo "<div class='container has-text-centered pt-6'>
            <div class='columns'>
                <div class='column is-half has-text-centered'>
                <h1 class='title is-3 has-text-info'>$formattedMonth</h1>
                </div>
                <div class='column'>
                        <input type='month' class='input is-primary' value='$month' name='selectedMonth' min='2022-01' max='$currentMonth' onchange='submitForm()'/>
                </div>
                </div>
        </div>";

    $query = "SELECT * FROM `employee_attendance` WHERE emp_id=? AND DATE_FORMAT(date, '%Y-%m') = ?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $search_emp_id, $month);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($date, $check_in_time, $check_out_time,$emp_id);
    $rowCount = 0;
    if ($stmt->num_rows > 0) {
        echo "<div class='container mt-6'>
        <div class='columns'>
        ";
        while ($stmt->fetch()) {
            if ($rowCount == 0) {
                echo "
                <div class='column is-one-third'>
                <table class='table is-bordered is-striped'>
                <thead class='has-background-primary'>
                    <tr>
                        <th>Date</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                    </tr>
                 </thead>
                 <tbody>";
            } else if ($rowCount == 10 || $rowCount == 20) {
                echo "
                </tbody></table></div>
                <div class='column is-one-third'>
                <table class='table is-bordered is-striped'>
                <thead class='has-background-primary'>
                    <tr>
                        <th>Date</th>
                        <th>Check-In</th>
                        <th>Check-Out</th>
                    </tr>
                 </thead>
                 <tbody>";
            }
            echo "      
            <tr>                 
             <td>$date</td>
             <td>$check_in_time</td>
             <td>$check_out_time</td>
             </tr>
            ";
            $rowCount += 1;
        }
        echo "</div></div>";
    } else {
        echo "<div class='container has-text-centered pt-6'>
        <h1 class='title is-1 has-text-danger'>Attendance for $formattedMonth or user does not exist!</h1>
        </div>";
    }
    $stmt->close();
    CloseCon($conn);
}
?>

<script>
function submitForm() {
    const myButton = document.getElementById('attendance_btn');
    myButton.click();
}
</script>