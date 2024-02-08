<?php $connection = mysqli_connect('localhost', 'root', '', 'quadsel'); ?>
<?php
date_default_timezone_set("Asia/Calcutta");

//Variables
$name = '';
$phone_number = '';
$lap_make = '';
$adapt_make = '';
$address = '';
$purpose_of_visit = '';
$mode_of_transport = '';
$type = '';
$check_out = '';
$profile_photo_link = '';

//variables for throwing Error
$nameErr = '';
$emailErr = '';
$phoneErr = '';
$lapErr = '';
$adaptErr = '';
$addressErr = '';
$povErr = '';
$profile_photo_link_Err = '';
$check_out_Err = '';

//Submit btn press
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $phone_number = $_POST['phone_number'];
  $lap_make = $_POST['lap_make'];
  $adapt_make = $_POST['adapt_make'];
  $address = $_POST['address'];
  $purpose_of_visit = $_POST['purpose_of_visit'];
  $mode_of_transport = $_POST['mode_of_transport'];
  $type = $_POST['type'];
  $profile_photo_link = $_POST['profile_photo_link'];
  $check_out = $_POST['check_out'];

  //Validation

  if (trim($name) === '') {
    $nameErr = 'Enter your name';
  } else {
    $nameErr = '';
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

  if (trim($purpose_of_visit) === '') {
    $povErr = 'Enter your purpose of visit';
  } else {
    $povErr = '';
  }

  if ($profile_photo_link === '') {
    $profile_photo_link_Err = 'Capture your image';
  } else {
    $profile_photo_link_Err = '';
  }

  if ($check_out === '') {
    $check_out_Err = 'Enter the estimated checkout time';
  } else {
    $check_out_Err = '';
  }

  if (trim($name) !== '' && trim($phone_number) !== '' && strlen(trim($phone_number)) === 10 && trim($address) !== '' && trim($purpose_of_visit) !== '' && $profile_photo_link !== '' && $check_out !== '') {
    $date = Date('Y-m-d');
    $time = Date('H-i');

    if (!$connection) {
      die('Connection Error' . mysqli_connect_error());
    } else {
      $sql = "INSERT INTO visitors_details(Visitor_Name,Phone_number,Purpose_of_visit,From_Address,Type,Today_Date,Check_in,Check_out,Mode_of_transport,Lap_make,Adapt_make,Profile_photo_link) VALUES('$name','$phone_number','$purpose_of_visit','$address','$type','$date','$time','$check_out','$mode_of_transport','$lap_make','$adapt_make','$profile_photo_link')";
      $result = mysqli_query($connection, $sql);
      if ($result !== false) {
        echo "<div class='notification is-success SignUp-Success'>Succesfully created</div>";
        echo "<script>setTimeout(()=>{window.location.href='../../login'},2000)</script>";

      } else {
        echo "<div class='notification is-danger SignUp-Success'>Unsuccessful!</div>";
      }
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
  <title>Visitors Form</title>
  <link rel="stylesheet" href="./Form.css">
  <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>

<body>
  <div class="Visitor-Details">
    <div class="Visitor-Form-div">
      <div class="Visitor-logo-div">
        <div class="Visitor-logo-title">
          <h1>Visitors Details</h1>
        </div>
        <img src="../BlueBase.jpeg" alt="BluebaseLogo">
      </div>
      <form class='Visitor-Form' action="" method='post'>
        <div class="Visitor-Form-div-1">
          <div class="Visitor-Form-Name">
            <label for="">Name</label>
            <input type="text" name="name" value='<?php echo $name ?>' placeholder='Name' autocomplete='off'>
            <span>
              <?php echo $nameErr ?>
            </span>
          </div>

          <div class="Visitor-Form-Phone">
            <label for="">Contact No</label>
            <input type="number" name="phone_number" value='<?php echo $phone_number ?>' min='0' placeholder='Contact number' autocomplete='off'>
            <span>
              <?php echo $phoneErr ?>
            </span>
          </div>
        </div>

        <div class="Visitor-Form-div-2">
          <div class="Visitor-Form-TransportMode">
            <label for="">Mode Of Transport</label>
            <select id='mode_of_transport' name="mode_of_transport" value='<?php echo $mode_of_transport ?>'>
              <option value="2">2 Wheelers</option>
              <option value="4">4 Wheelers</option>
            </select>
          </div>

          <div class="Visitor-Form-Type">
            <label for="">Type:</label>
            <select id='type' name="type" id='type' onchange="Toggle()">
              <option value='Guest' <?php echo ($type === 'Guest') ? 'selected' : ''; ?>>Guest </option>
              <option value="Service" <?php echo ($type === 'Service') ? 'selected' : ''; ?>>Service </option>
              <option value="Intern" <?php echo ($type === 'Intern') ? 'selected' : ''; ?>>Intern </option>
            </select>
          </div>
        </div>

        <div class="Visitor-Form-div-3">
          <div class="Visitor-Form-Time">
            <label for="">Estimated Check-out Time</label>
            <input type="time" id='time' name="check_out" value='<?php echo $check_out ?>' min=<?php echo date("Hi");  ?>>
            <span id='time_Err'>
              <?php echo $check_out_Err ?>
            </span>
          </div>

          <div class="Visitor-Form-LapMake">
            <label for="">Laptop Make</label>
            <input type="text" name="lap_make" id='lap_make' value='<?php echo $lap_make ?>' placeholder='Laptop Serial number' autocomplete='off'>
          </div>

          <div class="Visitor-Form-AdaptMake">
            <label for="">Adaptor Make</label>
            <input type="text" name="adapt_make" id='adapt_make' value='<?php echo $adapt_make ?>' placeholder='Adapter Serial number' autocomplete='off'>
          </div>
        </div>

        <div class="Visitor-Form-div-4">
          <div class="Visitor-Form-Address">
            <label for="">Address</label>
            <textarea name="address" placeholder='Permanant Residential Address' autocomplete='off'><?php echo $address ?></textarea>
            <span>
              <?php echo $addressErr ?>
            </span>
          </div>

          <div class="Visitor-Form-pov">
            <label for="">Purpose of Visit</label>
            <textarea name="purpose_of_visit" id='purpose_of_visit' placeholder='Purpose of visit' autocomplete='off'><?php echo $purpose_of_visit ?></textarea>
            <span>
              <?php echo $povErr ?>
            </span>
          </div>
        </div>

        <div class="Visitor-Form-div-5">
          <div class="Visitor-Form-Upload">
            <p class='js-modal-trigger button is-dark' data-target="picture-Model" onclick="openCamera();">Capture your image</p>
            <span>
              <?php echo $profile_photo_link_Err ?>
            </span>
          </div>

          <div class="Visitor-Form-Submitbtn">
            <input type="submit" class='button is-danger' name='submit' id='submit' value='Submit'>
          </div>

        </div>
    </div>
    <input type="hidden" name="profile_photo_link" id='profile_photo_link' value=''>
    </form>

    <div id='picture-Model' class="modal">
      <div class="modal-background"></div>
      <div class="modal-card">
        <section class="modal-card-body">
          <button class="delete" aria-label="close" onclick="stopCamera();"></button>
          <video id="webcam" autoplay playsinline width='640' height='400'></video>
          <p class="button is-info " id='profile-Model-title'></p>
          <button class='button is-dark Visitor-Img-Capture' onclick="Snap()">Capture</button>
          <canvas id='canvas' style='width:640;height:400;margin-top:10px;'></canvas>
        </section>
      </div>
    </div>
  </div>
</body>

<script>
  //WEBCAM package
  const webcamElement = document.getElementById('webcam')
  const canvas = document.getElementById('canvas')
  const imgcaption = document.getElementById('profile-Model-title');

  const webcam = new Webcam(webcamElement, 'user', canvas)

  //webcam start function
  function openCamera() {
    webcam.start()
      .then((result) => {
        imgcaption.innerHTML = "Webcam online";
      })
      .catch((error) => {
        imgcaption.innerHTML = "Webcam Permission denied"

      })
  }


  // Stop Camera
  function stopCamera(){
    webcam.stop();
  }
  //webcam on click snap 

  const Snap = async () => {
    try {
      const picture = await webcam.snap();
      const formData = new FormData();
      const imglink = document.getElementById('profile_photo_link');

      formData.append('api_key', "Z50gMTpItrXBaUtHe65Nj5_d_A7W4ocK");
      formData.append('api_secret', "0bGoqLdAB8d5BUSsqlckTXUF_EYBXFEx");
      formData.append('image_base64', picture.split(',')[1]);

      //Face++ API to detect if face or other object

      const response = await fetch('https://api-us.faceplusplus.com/facepp/v3/detect', {
        method: 'POST',
        body: formData,
      });

      const data = await response.json();

      if (data.faces.length > 0) {
        console.log('OK')
        imglink.value = picture;

      } else {
        console.log('NOT OK')
        imglink.value = '';
      }
      stopCamera();

    } catch (error) {
      console.error('Error during Face++ API request:', error);
    }
  };

  document.addEventListener('DOMContentLoaded', () => {

    function openModal($el) {
      $el.classList.add('is-active');
    }

    function closeModal($el) {
      $el.classList.remove('is-active');
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
    (document.querySelectorAll('.modal-background,.delete,.Visitor-Img-Capture') || []).forEach(($close) => {
      const $target = $close.closest('.modal');
      $close.addEventListener('click', () => {
        setTimeout(() => {
          closeModal($target);
        }, 1600);
      });
    });
  });
</script>

</html>