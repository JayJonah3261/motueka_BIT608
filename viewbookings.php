<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking</title>
</head>
<style>
    /* CSS styling for the page */

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    /* Header styling */
    h1 {
        background-color: #007BFF;
        color: white;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Hyperlink styling */
    a {
        text-decoration: none;
        color: #007BFF;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Container styling */
    div {
        border: 1px solid #ccc;
        padding: 20px;
        max-width: 400px;
        margin: 0 auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Subtitle alignment */
    h2 {
        text-align: center;
    }

    /* Paragraph margin */
    p {
        margin: 10px 0;
    }
</style>

<body>
    <?php
    // Include database configuration file
    include "config.php";

    // Establish a database connection
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    // Check SQL connection
    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit;
    }

    // Validation
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid Booking ID</h2>";
        exit;
    }

    // Query to retrieve booking data
    $query = 'SELECT b.bookingID, b.checkInDate, b.checkOutDate, r.roomname, c.firstname, c.lastname FROM booking b
          INNER JOIN room r ON b.roomID = r.roomID
          INNER JOIN customer c ON b.customerID = c.customerID
          WHERE b.bookingID=' . $id;

    $result = mysqli_query($db_connection, $query);
    $rowcount = mysqli_num_rows($result);
    ?>

    <div style="text-align: center;">
        <h1>Booking Details View</h1>
        <h2>
            <!-- Navigation links -->
            <a href='listbookings.php'>Return to Booking Listing</a>
            <a href='index.php'>Return to Main Page</a>
        </h2>
    </div>

    <?php
    // Check Booking
    if ($rowcount > 0) {
        echo '<div style="border: 1px solid black; padding: 10px">';
        echo "<h2>Room Detail #$id</h2>";
        $row = mysqli_fetch_assoc($result);
        echo "<p>Room Name: " . $row['roomname'] . "</p>";
        echo "<p>Check-in Date: " . $row['checkInDate'] . "</p>";
        echo "<p>Check-out Date: " . $row['checkOutDate'] . "</p>";
        echo "<p>Contact Number: " . $row['contactNumber'] . "</p>";
        echo "<p>Extras: " . $row['extras'] . "</p>";
        echo "<p>Room Review: " . $row['roomReview'] . "</p>";
        echo '</div>';
    } else {
        echo "<h2>No Booking found</h2>";
    }

    // Free result and close the database connection
    mysqli_free_result($result);
    mysqli_close($db_connection);
    ?>
</body>

</html>
