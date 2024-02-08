<?php $connection = mysqli_connect('localhost', 'root', '', 'quadsel');

?>
<?php
//Varibales
$name = '';
$email = '';
$password = '';
$Confirmpassword = '';
$phone_number = '';
$address = '';
$pan_no = '';
$aadhar_no = '';
$dob = '';
$date_of_join = '';
$profile_photo_link = '';

//Error varivales 
$nameErr = '';
$emailErr = '';
$phoneErr = '';
$addressErr = '';
$pan_no_Err = '';
$aadhar_no_Err = '';
$password_Err = '';
$Confirmpassword_Err = '';
$dobErr = '';
$date_of_join_Err = '';
$profile_photo_link_Err = '';


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $profile_photo_link = $_POST['profile_photo_link'];
    $password = $_POST['password'];
    $Confirmpassword = $_POST['Confirmpassword'];
    $pan_no = $_POST['pan_no'];
    $aadhar_no = $_POST['aadhar_no'];
    $dob = $_POST['dob'];
    $date_of_join = $_POST['date_of_join'];


    if (trim($name) === '') {
        $nameErr = 'Enter your name';
    } else {
        $nameErr = '';
    }

    if (trim($email) === '') {
        $emailErr = 'Enter your email';
    } else {
        $emailErr = '';
    }

    if (trim($phone_number) === '') {
        $phoneErr = 'Enter your phone number';
    } else if (strlen(trim($phone_number)) !== 10) {
        $phoneErr = 'Enter a valid number';
    } else {
        $phoneErr = '';
    }

    if (trim($address) === '') {
        $addressErr = 'Enter your permanant address';
    } else {
        $addressErr = '';
    }

    if ($profile_photo_link === '') {
        $profile_photo_link_Err = 'Upload your image';
    } else {
        $profile_photo_link_Err = '';
    }
    if (trim($pan_no) === '') {
        $pan_no_Err = 'Enter your pan number';
    } else if (strlen(trim($pan_no)) !== 10) {
        $pan_no_Err = 'Enter a valid pan number';
    } else {
        $pan_no_Err = '';
    }

    if (trim($aadhar_no) === '') {
        $aadhar_no_Err = 'Enter your aadhar number';
    } else if (strlen(trim($aadhar_no)) !== 12) {
        $aadhar_no_Err = 'Enter a valid aadhar number';
    } else {
        $aadhar_no_Err = '';
    }

    if ($dob === "" || $dob === null) {
        $dobErr = 'Enter the date of birth';
    } else {
        $dobErr = '';
    }
    if ($date_of_join === "" || $date_of_join === null) {
        $date_of_join_Err = 'Enter the date of joining';
    } else {
        $date_of_join_Err = '';
    }
    if ($password === '') {
        $password_Err = 'Enter the password';
    } else {
        $password_Err = '';
    }

    if ($Confirmpassword === '') {
        $Confirmpassword_Err = 'Enter the password';
    } else if ($Confirmpassword !== $password) {
        $Confirmpassword_Err = 'Password doesnt match';
    } else {
        $Confirmpassword_Err = '';
    }
    
    if (trim($name) !== '' && trim($email) !== '' && trim($phone_number) !== '' && strlen(trim($phone_number)) === 10 && trim($address) !== '' && trim($pan_no) !== '' && strlen(trim($pan_no)) === 10 && trim($aadhar_no) !== "" && strlen(trim($aadhar_no)) === 12 && ($dob !== '' || $dob !== null) && ($date_of_join !== '' && $date_of_join !== null) && $profile_photo_link !== '' && $password !== '' && $Confirmpassword !== '' && $Confirmpassword === $password) {
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO pending_employee_details(emp_name,date_of_birth,address,email_id,aadhar_no,pan_no,password,profile_photo_link,phone_number,date_of_joining) VALUES('$name','$dob','$address','$email','$aadhar_no','$pan_no','$hashedPassword','$profile_photo_link','$phone_number','$date_of_join')";
        $result = mysqli_query($connection, $sql);
        if ($result !== false) {
            echo "<div class='notification is-success SignUp-Success'>Succesfully created </div>";
            echo "<script>sessionStorage.removeItem('file-name'); sessionStorage.removeItem('modal-profile')</script>";
             echo "<script>setTimeout(()=>{window.location.href='../../login'},2000)</script>";


        } else {
            echo "<div class='notification is-danger SignUp-Success'>The Email Address you provided already exist </div>";
        } 
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel='icon' href='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLtc8BZ6ODkts0V0DHZ22rpI9pbM6Erydq3_bk7DWnsA&s' />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="SignUp.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div class="Employee-SignUp">
        <div class="SignUp-Form-Img">
            <div class='SignUp-Form-Logo-div'>
                <div class="Employee-SignUp-title">
                    <h1>SignUp</h1>
                </div>
                <img src="../BlueBase.jpeg" alt="">
            </div>
            <form class='Employee-SignUp-Form' action="" method='post'>
                <div class="Employee-SignUp-div-1">
                    <div class="Employee-SignUp-Name">
                        <label for="">Name</label>
                        <input type="text" name="name" value='<?php echo $name ?>' placeholder='Name'
                            autocomplete='off'>
                        <span>
                            <?php echo $nameErr ?>
                        </span>
                    </div>

                    <div class="Employee-SignUp-Email">
                        <label for="">Email Address</label>
                        <input type="email" name="email" value='<?php echo $email ?>' placeholder='Email Address'
                            autocomplete='off'>
                        <span>
                            <?php echo $emailErr ?>
                        </span>
                    </div>

                    <div class="Employee-SignUp-Phone">
                        <label for="">Contact Number</label>
                        <input type="number" name="phone_number" min='0' value='<?php echo $phone_number ?>'
                            placeholder='Contact Number' autocomplete='off'>
                        <span>
                            <?php echo $phoneErr ?>
                        </span>
                    </div>
                </div>

                <div class="Employee-SignUp-div-2">
                    <div class="Employee-SignUp-Password">
                        <label for="">Password</label>
                        <input type="password" name="password" id='password' value='<?php echo $password ?>'
                            placeholder='Password' autocomplete='off'>
                        <span id='password_Err'>
                            <?php echo $password_Err ?>
                        </span>
                    </div>

                    <div class="Employee-SignUp-ConfirmPassword">
                        <label for="">Confirm Password</label>
                        <input type="password" name="Confirmpassword" id='Confirmpassword'
                            value='<?php echo $Confirmpassword ?>' placeholder='Confirm Password' autocomplete='off'>
                        <span id='Confirmpassword_Err'>
                            <?php echo $Confirmpassword_Err ?>
                        </span>
                    </div>

                    <div class="Employee-SignUp-Dob">
                        <label for="">Date of Birth</label>
                        <input type='date' id='dob' name='dob' value='<?php echo $dob ?>' autocomplete='off'>
                        <span id='dob_Err'>
                            <?php echo $dobErr ?>
                        </span>
                    </div>
                </div>

                <div class="Employee-SignUp-div-3">
                    <div class="Employee-SignUp-Pan">
                        <label for="">PAN Number</label>
                        <input type='text' name='pan_no' id='pan_no' maxlength="10" value='<?php echo $pan_no ?>'
                            placeholder='Pan Number' autocomplete='off'>
                        <span id='pan_no_Err'>
                            <?php echo $pan_no_Err ?>
                        </span>
                    </div>

                    <div class="Employee-SignUp-Aadhar">
                        <label for="">Aadhar Number</label>
                        <input type='number' name='aadhar_no' id='aadhar_no' maxlength="12" min='0'
                            value='<?php echo $aadhar_no ?>' placeholder='Aadhar Number' autocomplete='off'>
                        <span id='aadhar_no_Err'>
                            <?php echo $aadhar_no_Err ?>
                        </span>
                    </div>

                    <div class="Employee-SignUp-Join">
                        <label for="">Date of joining</label>
                        <input type='date' id='date_of_joining' name='date_of_join' value='<?php echo $date_of_join ?>'
                            autocomplete='off'>
                        <span id='date_of_joining_Err'>
                            <?php echo $date_of_join_Err ?>
                        </span>
                    </div>

                </div>

                <div class="Employee-SignUp-div-4">

                    <div class="Employee-SignUp-Address">
                        <label for="">Permanant Address</label>
                        <textarea name="address"
                            placeholder='Permanant Residential Address'><?php echo $address ?></textarea>
                        <span>
                            <?php echo $addressErr ?>
                        </span>
                    </div>

                    <div class="Employee-SignUp-Profile file has-name">
                        <div class="file has-name is-boxed is-small">
                            <label class="file-label">
                            <input accept="image/jpg,png,jpeg" class="file-input " type="file"
                                onchange="imageUploaded()" name="profile_photo_link" autocomplete='off'>                                <span class="file-cta">
                                    <span class="file-icon">
                                        <span class="material-symbols-outlined">
                                         upload
                                        </span>                                   
                                     </span>
                                    <span class="file-label">
                                      Upload your Image
                                    </span>
                                </span>
                            </label>
                        </div>
                        <span class="js-modal-trigger" data-target="modal-js-example" name='name_of_file' id='file-name' target='_blank'>

                        </span>
                        <span id='profile_photo_link_Err'>
                            <?php echo $profile_photo_link_Err ?>
                        </span>

                </div>
               
        </div>
        <div class="Employee-SignUp-Submitbtn">
                    <input type="submit" name='submit' class='button signup-btn' value='SignUp'>
                    <p>Already have an account? <a onclick={SignUpToLogin()}>Login</a></p>
                </div>
        <input type="hidden" name="profile_photo_link" id='profile_photo_link'
            value='<?php echo $profile_photo_link ?>'>
    </div>
    </form>
    </div>
    </div>
    <div id="modal-js-example" class="modal" $modal-content-width='200px'>
        <div class="modal-background"></div>

    <div class="modal-content">
        <div class="box">
            <img src="" alt="Uploaded Image" id='modal-profile'>
        </div>
    </div>

  <button class="modal-close is-large" aria-label="close"></button>
</div>

</body>
<script>
    let base64String = "";

    function imageUploaded() {
        let file = document.querySelector('input[type=file]')['files'][0];
        let names = document.getElementById('profile_photo_link')
        let reader = new FileReader();
        reader.onload = function () {
            base64String = reader.result;
            names.value = base64String;
            // document.getElementById("file-name").innerText = file.name;
            // document.getElementById("modal-profile").src = base64String;
            sessionStorage.setItem('file-name',file.name)
            sessionStorage.setItem('modal-profile',base64String)
            InnerText()

        }
        reader.readAsDataURL(file);
    }
    document.addEventListener('DOMContentLoaded', () => {
  // Functions to open and close a modal
  function openModal($el) {
    $el.classList.add('is-active');
  }

  function closeModal($el) {
    $el.classList.remove('is-active');
  }

  function closeAllModals() {
    (document.querySelectorAll('.modal') || []).forEach(($modal) => {
      closeModal($modal);
    });
  }

  // Add a click event on buttons to open a specific modal
  (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
    const modal = $trigger.dataset.target;
    const $target = document.getElementById(modal);

    $trigger.addEventListener('click', () => {
      openModal($target);
    });
  });

  // Add a click event on various child elements to close the parent modal
  (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
    const $target = $close.closest('.modal');

    $close.addEventListener('click', () => {
      closeModal($target);
    });
  });

  // Add a keyboard event to close all modals
  document.addEventListener('keydown', (event) => {
    if (event.code === 'Escape') {
      closeAllModals();
    }
  });
});

const InnerText=()=>
{
    document.getElementById("file-name").innerText = sessionStorage.getItem('file-name');
    document.getElementById("modal-profile").src = sessionStorage.getItem('modal-profile');
}
InnerText();

const SignUpToLogin=()=>
{
    sessionStorage.removeItem('file-name'); 
    sessionStorage.removeItem('modal-profile')
    window.location.href='../../index.php'
}

</script>

</html>