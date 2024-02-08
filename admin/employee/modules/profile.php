<?php
function view_employee_profile($search_emp_id)
{
    include '.../../../../../db_connection.php';
    $conn = OpenCon();
    $query = "SELECT * FROM `employee_details` WHERE emp_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $search_emp_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($emp_id, $emp_name, $date_of_birth, $address, $email_id, $aadhar_no, $pan_no, $profile_photo_link, $phone_no, $date_of_joining);
    if ($stmt->num_rows > 0) {
        while ($stmt->fetch()) {
            $uniqueEditModalID = "editModal_" . $emp_id;
            $uniqueDeleteModalID = "deleteModal_" . $emp_id;
            echo "<div class='box m-5'>
                            <div class='columns'>
                                <div class='column is-two-fifths'>
                                    <p class='title is-4'>Name:</p>
                                    <p class='subtitle is-6 mb-6'>$emp_name</p>
                                    <p class='title is-4'>Address:</p>
                                    <p class='subtitle is-6 mb-6'>$address</p>
                                    <p class='title is-4'>Aadhar No:</p>
                                    <p class='subtitle is-6 mb-6'>$aadhar_no</p>
                                    <p class='title is-4'>Phone:</p>
                                    <p class='subtitle is-6'>$phone_no</p>
                                    <p class='title is-1 mt-6'>$emp_id</p>
                                </div>
                                <div class='column is-two-fifths'>
                                    <p class='title is-4'>Date of birth:</p>
                                    <p class='subtitle is-6 mb-6'>$date_of_birth</p>
                                    <p class='title is-4'>Email:</p>
                                    <p class='subtitle is-6 mb-6'>$email_id</p>
                                    <p class='title is-4'>PAN No:</p>
                                    <p class='subtitle is-6 mb-6'>$pan_no</p>
                                    <p class='title is-4'>Date of Joining:</p>
                                    <p class='subtitle is-6 mb-6'>$date_of_joining</p>
                                </div>
                                <div class='column is-one-fifths'>
                                    <figure class='image is-4by5'>
                                        <img src='$profile_photo_link' class='custom-rad'>
                                    </figure>
                                    <div class='columns'>
                                        <div class='column is-half'></div>
                                        <div class='column is-one-fourth'><button class='button is-primary has-icons mt-6 mr-3 js-modal-trigger' data-target='$uniqueEditModalID'
                                                type='button' name='edit_profile_modal_btn'>
                                                <span class='icon'>
                                                    <i class='fa-regular fa-edit'></i>
                                                </span>
                                            </button></div>
                                        <div class='column is-one-fourth'><button class='button is-danger has-icons mt-6 js-modal-trigger' data-target='$uniqueDeleteModalID' type='button'
                                                name='delete_profile_modal_btn'>
                                                <span class='icon'>
                                                    <i class='fa-solid fa-trash'></i>
                                                </span>
                                            </button></div>
                                    </div>
                                </div>
                            </div>
                            <div id='$uniqueEditModalID' class='modal'>
                <div class='modal-background'></div>
                <div class='modal-content'>
                    <div class='box'>
                        <div class='columns'>
                            <div class='column is-half'>
                            <input type='text' class='input is-primary mb-3' name='edit_emp_name' placeholder='Name' value='$emp_name'>
                            <input type='text' class='input is-primary mb-3' name='edit_emp_address' placeholder='Address' value='$address'>
                            <input type='number' class='input is-primary mb-3' name='edit_emp_aadhar' placeholder='Aadhar No' value='$aadhar_no'
                            min='100000000000' max='999999999999'
                            >
                            <input type='number' class='input is-primary mb-3' name='edit_emp_phone' placeholder='Phone No' value='$phone_no'
                            min='1000000000' max='9999999999'
                            >
                            </div>
                            <div class='column'>
                            <input type='date' class='input is-primary mb-3' name='edit_emp_bday' placeholder='Date of Birth' value='$date_of_birth'>
                            <input type='email' class='input is-primary mb-3' name='edit_emp_email' placeholder='Email ID' value='$email_id'>
                            <input type='text' class='input is-primary mb-3' name='edit_emp_pan' placeholder='PAN No' value='$pan_no'>
                            <input type='text' class='input is-primary mb-3' name='edit_emp_pic' placeholder='Profile Pic URL' value='$profile_photo_link'>
                            </div>
                        </div>
                        <div class='columns'>
                            <div class='column is-8'><input type='password' class='input is-primary' name='edit_admin_password' placeholder='Enter Admin Password to Confirm'></div>
                            <div class='column is-4'>                           
                            <button name='edit_profile_btn' class='button is-primary ml-6' type='submit' value='$emp_id'>Edit</button></div>
                        </div>
                    </div>
                </div>
                <button class='modal-close is-large' aria-label='close' type='button'></button>
            </div>
            <div id='$uniqueDeleteModalID' class='modal'>
            <div class='modal-background'></div>
            <div class='modal-content'>
                <div class='box is-flex'>
                <p class='subtitle-6 has-text-danger'>Note: this action cannot be undone!</p>
                <input type='password' class='input is-primary' name='delete_admin_password' placeholder='Enter Admin Password to Confirm'>
                   <button name='delete_profile_btn' class='button is-danger ml-3' type='submit' value='$emp_id'>Delete</button>
                </div>
    
            </div>
            <button class='modal-close is-large' aria-label='close' type='button'></button>
        </div>
                        </div>";
        }
    } else {
        echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>User not found!</h1>
                    </div>";
    }

    $stmt->close();
    CloseCon($conn);
}
?>

<script>
    // Modal Functionalities

    document.addEventListener("DOMContentLoaded", () => {
        function openModal(event) {
            event.preventDefault();
            const modalId = event.currentTarget.getAttribute("data-target");
            const modal = document.getElementById(modalId);
            openModal(modal);
        }
        function openModal($el) {
            $el.classList.add("is-active");
        }

        function closeModal($el) {
            $el.classList.remove("is-active");
        }

        function closeAllModals() {
            (document.querySelectorAll(".modal") || []).forEach(($modal) => {
                closeModal($modal);
            });
        }

        (document.querySelectorAll(".js-modal-trigger") || []).forEach(($trigger) => {
            const modal = $trigger.dataset.target;
            const $target = document.getElementById(modal);
            console.log($target);
            $trigger.addEventListener("click", () => {
                openModal($target);
            });
        });

        (
            document.querySelectorAll(
                ".modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button"
            ) || []
        ).forEach(($close) => {
            const $target = $close.closest(".modal");

            $close.addEventListener("click", () => {
                closeModal($target);
            });
        });

        document.addEventListener("keydown", (event) => {
            if (event.code === "Escape") {
                closeAllModals();
            }
        });
    });
</script>