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

                <a class="navbar-item" href="../employee">
                    Employee
                </a>
                <a class="navbar-item" href="./">
                    Visitors
                </a>

                <a class="navbar-item button is-danger mt-2" href="../logout">
                    Logout
                </a>
            </div>
        </div>
    </nav>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <?php
        $date = date('Y-m-d');
        $currentDate = $date;
        if (isset($_POST["visitors_btn"])) {
            $date = $_POST["selectedDate"];
        }

        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        $formattedDate = $dateTime->format('d F Y');
        echo "<div class='container has-text-centered pt-6'>
        <div class='columns'>
            <div class='column is-half has-text-centered'>
                <h1 class='title is-3 has-text-info'>$formattedDate</h1>
            </div>
            <div class='column'>
                <input type='date' class='input is-primary' value='$date' name='selectedDate' min='2022-01-01' max='$currentDate'
                    onchange='submitForm()' />
                    <button class='button is-primary is-hidden has-icons ml-6' type='submit' name='visitors_btn' id='visitors_btn'>
                </button>
            </div>
        </div>
    </div>";
        include_once './modules/visitors.php';
        view_visitors_details($date);
        ?>

    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
            console.log("hello")
            $navbarBurgers.forEach(el => {
                el.addEventListener('click', () => {
                    const target = el.dataset.target;
                    const $target = document.getElementById(target);
                    el.classList.toggle('is-active');
                    $target.classList.toggle('is-active');
                });
            });

        });

        function submitForm() {
            const myButton = document.getElementById('visitors_btn');
            myButton.click();
        }
    </script>
</body>

</html>