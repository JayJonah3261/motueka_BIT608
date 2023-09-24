<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Bookings</title>
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
    }

    /* Subtitle alignment */
    h2 {
        text-align: center;
    }

    /* Hyperlink styling */
    a {
        text-decoration: none;
        color: #007BFF;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Table styling */
    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    /* Header row styling */
    th {
        background-color: #007BFF;
        color: white;
    }

    /* Table row hover effect */
    tr:hover {
        background-color: #f5f5f5;
    }

    /* Button styling */
    a.btn {
        background-color: #007BFF;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
    }

    a.btn:hover {
        background-color: #0056b3;
    }
</style>

<body>

    <?php
    // Include database configuration file
    include "config.php";

    // Establish a database connection
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    // Check Database connection
    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit;
    }

    // Query to retrieve booking data
    $query = 'SELECT b.bookingID, b.checkInDate, b.checkOutDate, r.roomname, c.firstname, c.lastname FROM Booking b
          INNER JOIN room r ON b.roomID = r.roomID
          INNER JOIN customer c ON b.customerID = c.customerID';
    $result = mysqli_query($db_connection, $query);
    $rowcount = mysqli_num_rows($result);
    ?>

    <div style="text-align: center;">
        <h1>Current Bookings</h1>
        <h2>
            <!-- Navigation links -->
            <a href="booking.php">Make a booking</a> |
            <a href="index.php">Return to Main Page</a>
        </h2>
    </div>
    <br>
    <table border="1">
        <tr>
            <th>Booking (Room, Dates)</th>
            <th>Customer</th>
            <th>Action</th>
        </tr>

        <?php
        // Check if there are bookings
        if ($rowcount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $bookingID = $row['bookingID'];
                $roomname = $row['roomname'];
                $checkInDate = $row['checkInDate'];
                $checkOutDate = $row['checkOutDate'];
                $customerName = $row['firstname'] . ' ' . $row['lastname'];

                // Display booking information in a table row
                echo '<tr>';
                echo '<td>' . $roomname . ', ' . $checkInDate . ', ' . $checkOutDate . '</td>';
                echo '<td>' . $customerName . '</td>';
                echo '<td>';
                // Create links for viewing, editing, and deleting bookings
                echo '<a href="viewbookings.php?id=' . $bookingID . '">View</a> ';
                echo '<a href="editbooking.php?id=' . $bookingID . '">Edit</a> ';
                echo '<a href="' . $bookingID . '">Manage Reviews</a> ';
                echo '<a href="deletebookings.php?id=' . $bookingID . '">Delete</a> ';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            // Display a message when no bookings are found
            echo '<tr><td colspan="3">No bookings found!</td></tr>';
        }
        mysqli_free_result($result);
        mysqli_close($db_connection);
        ?>
    </table>
</body>

</html>