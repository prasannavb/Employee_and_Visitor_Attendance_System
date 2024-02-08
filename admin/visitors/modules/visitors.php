<?php
function view_visitors_details($date)
{
    include '.../../../../../db_connection.php';
    $conn = OpenCon();
    $query = "SELECT * FROM `visitors_details` WHERE Today_date=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result(
        $visitor_Name,
        $phone_number,
        $purpose_of_visit,
        $from_Address,
        $Type,
        $today_Date,
        $Check_in,
        $Check_out,
        $Mode_of_transport,
        $Lap_make,
        $Adapt_make,
        $Profile_photo_link);
    $rowCount = $stmt->num_rows;
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    $formattedDate = $dateTime->format('d F Y');
    if ($rowCount > 0) {
        echo "<div class='container mt-6 mb-6'>
        <div class='columns'>
            <div class='column'>
                <div class='box has-text-centered has-background-link-light'>
                <h1 class='title is-4'>Internship</h1>
                </div>
            </div>
            <div class='column'>
            <div class='box has-text-centered has-background-primary'>
            <h1 class='title is-4'>Guest</h1>
            </div>
            </div>
            <div class='column'>
            <div class='box has-text-centered has-background-warning'>
            <h1 class='title is-4'>Service</h1>
            </div>
            </div>
    </div>
    </div>";
        while ($stmt->fetch()) {
            $bg = '';
            if ($Type == 'Intern') {
                $bg = 'link-light';
            } else if ($Type == 'Guest') {
                $bg = 'primary';
            } else if ($Type == 'Service') {
                $bg = 'warning';
            }
            echo "
            <div class='container mt-6 mb-6'>
            <div class='box has-background-$bg p-0 m-0'>
                <div class='columns'>
                    <div class='column is-one-fifths'>
                        <figure class='image is-128x128 ml-6 mt-5 pt-2'>
                            <img src='$Profile_photo_link' style='border-radius: 6px;'>
                        </figure>
                    </div>
                    <div class='column is-two-fifths'>
                        <p class='title is-5'>Visitor Name:</p>
                        <p class='subtitle is-6'>$visitor_Name</p>
                        <p class='title is-5'>Visitor Address:</p>
                        <p class='subtitle is-6'>$from_Address</p>
                        <p class='title is-5'>Purpose of visit:</p>
                        <p class='subtitle is-6'>$purpose_of_visit</p>
                        <p class='title is-5'>Phone no:</p>
                        <p class='subtitle is-6'>$phone_number</p>
                    </div>
                    <div class='column is-two-fifths'>
                        <p class='title is-5'>Check In Time:</p>
                        <p class='subtitle is-6'>$Check_in</p>
                        <p class='title is-5'>Check Out Time:</p>
                        <p class='subtitle is-6'>$Check_out</p>
                        <p class='title is-5'>Lap & Adap Make:</p>
                        <p class='subtitle is-6'> $Lap_make &
                            $Adapt_make</p>
                        <p class='title is-5'>Mode of Transport:</p>
                        <p class='subtitle is-6'>$Mode_of_transport</p>
                    </div>
                </div>
            </div>
        </div>
                ";
        }
    } else {
        echo "<div class='container has-text-centered pt-6'>
                    <h1 class='title is-1 has-text-danger'>No visitors on $formattedDate!</h1>
                    </div>";
    }
    CloseCon($conn);

}

?>