<?php
session_start();
if (isset($_SESSION["emp_id"])) {
    if (!strpos($_SESSION["emp_id"], "AD")) {
        header("Location: ../../login");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLtc8BZ6ODkts0V0DHZ22rpI9pbM6Erydq3_bk7DWnsA&s' />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <script src="https://kit.fontawesome.com/5718f6eb3a.js" crossorigin="anonymous"></script>
    <style>
        #navbar-item {
            background: url(../quadsel_logo.png) no-repeat center center;
            background-size: cover;
            width: 130px;
        }

        .custom-rad {
            border-radius: 6px;
        }
    </style>

</head>

<body>
    <nav class="navbar has-shadow " role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" id="navbar-item" href="./">
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="mainNav">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="mainNav" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="../">
                    Analytics
                </a>

                <a class="navbar-item" href="./">
                    Employee
                </a>
                <a class="navbar-item" href="../visitors">
                    Visitors
                </a>

                <a class="navbar-item button is-danger mt-2" href="../logout">
                    Logout
                </a>
            </div>
        </div>
    </nav>
    <form action="<?php echo htmlspecialchars(filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_STRING)); ?>" method="post">
        <div class="container mt-6">
            <div class="columns">
                <div class="column is-one-fifths"><button class="button is-info has-icons" type="submit" name="pending_btn">
                        <span class="icon">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <h1>Pending Approvals</h1>
                    </button></div>
                <div class="column is-three-fifths">
                    <div class="control has-icons-left">
                        <?php
                        $search_emp_id_value = filter_input(INPUT_POST, 'search_emp_id', FILTER_SANITIZE_EMAIL);
                        ?>
                        <input class="input is-primary" type="text" name="search_emp_id" placeholder="EMP ID of employee" value="<?php echo isset($search_emp_id_value) ? htmlspecialchars($search_emp_id_value) : ''; ?>"></input>
                        <span class="icon is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
                <div class="column is-one-fifths">
                    <button class="button is-primary has-icons mr-5" type="submit" name="attendance_btn" id="attendance_btn">
                        <span class="icon">
                            <i class="fa-regular fa-calendar-days"></i>
                        </span>
                    </button>
                    <button class="button is-primary has-icons mr-5" type="submit" name="profile_btn">
                        <span class="icon">
                            <i class="fa-regular fa-user"></i>
                        </span>
                    </button>
                    <button class="button is-primary has-icons mr-5" type="submit" name="all_users">
                        <span class="icon">
                            <i class="fa-solid fa-users"></i>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pending_btn = filter_input(INPUT_POST, 'pending_btn', FILTER_SANITIZE_STRING);
            $approve_btn = filter_input(INPUT_POST, 'approve_btn', FILTER_SANITIZE_STRING);
            $reject_btn = filter_input(INPUT_POST, 'reject_btn', FILTER_SANITIZE_STRING);
            $edit_profile_btn = filter_input(INPUT_POST, 'edit_profile_btn', FILTER_SANITIZE_STRING);
            $delete_profile_btn = filter_input(INPUT_POST, 'delete_profile_btn', FILTER_SANITIZE_STRING);
            $all_users = filter_input(INPUT_POST, 'all_users', FILTER_SANITIZE_STRING);
            $search_emp_id = filter_input(INPUT_POST, 'search_emp_id', FILTER_SANITIZE_EMAIL);
            if (isset($all_users)) {
                include_once('./modules/viewAll.php');
                viewAllEmployees();
            } else if (isset($pending_btn)) {
                include('./modules/pending.php');
                pending_approvals();
            } else if (isset($approve_btn)) {
                include('./modules/approve.php');
                approve_employee();
            } else if (isset($reject_btn)) {
                include('./modules/reject.php');
                reject_employee();
            } else if (isset($edit_profile_btn)) {
                include("./modules/editprofile.php");
                include("./modules/verifyadmin.php");
                $edit_emp_id = $edit_profile_btn;
                $admin_pwd = filter_input(INPUT_POST, 'edit_admin_password', FILTER_SANITIZE_STRING);
                if (trim($admin_pwd) == '') {
                    echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>Admin Password cannot be empty!</h1>
                    </div>";
                } else {
                    if (verifyadmin($admin_pwd)) {
                        edit_profile($edit_emp_id);
                    } else {
                        echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>Admin Password is not correct!</h1>
                    </div>";
                    }
                }
            } else if (isset($delete_profile_btn)) {
                include("./modules/deleteprofile.php");
                include("./modules/verifyadmin.php");
                $del_emp_id = $delete_profile_btn;
                $admin_pwd = filter_input(INPUT_POST, 'delete_admin_password', FILTER_SANITIZE_STRING);
                if (trim($admin_pwd) == '') {
                    echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>Admin Password cannot be empty!</h1>
                    </div>";
                } else {
                    if (verifyadmin($admin_pwd)) {
                        delete_profile($del_emp_id);
                    } else {
                        echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>Admin Password is not correct!</h1>
                    </div>";
                    }
                }
            } else if (isset($search_emp_id)) {
                if (trim($search_emp_id) == "") {
                    echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>EMPID cannot be empty!</h1>
                    </div>";
                } else {
                    if (isset($_POST['attendance_btn'])) {
                        include('./modules/attendance.php');
                        view_employee_attendance($search_emp_id);
                    } else if (isset($_POST['profile_btn'])) {
                        include('./modules/profile.php');
                        view_employee_profile($search_emp_id);
                    }
                }
            }
        } else {
            include_once('./modules/viewAll.php');
            viewAllEmployees();
        }
        ?>
    </form>
    <script>
        // Responsive Navbar
        document.addEventListener("DOMContentLoaded", () => {
            const $navbarBurgers = Array.prototype.slice.call(
                document.querySelectorAll(".navbar-burger"),
                0
            );
            $navbarBurgers.forEach((el) => {
                el.addEventListener("click", () => {
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);
                    el.classList.toggle("is-active");
                    $target.classList.toggle("is-active");
                });
            });
        });

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
</body>

</html>