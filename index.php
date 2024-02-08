<?php
session_start();
echo $_SESSION['emp_id'];
if (isset($_SESSION['emp_id'])) {
    if (strpos($_SESSION['emp_id'], 'EM') == true)
        header('Location: ./employee');
    else
        header('Location: ./admin');
} else {
    header('Location: ./login');
}

?>  