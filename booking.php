<!DOCTYPE HTML>
<html>

<head>
    <title>Make a Booking</title>
    <!-- Include jQuery library for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    .container {
        text-align: center;
        margin: 20px auto;
        max-width: 400px;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Form and input styling */
    form {
        text-align: left;
    }

    label,
    input[type="text"],
    input[type="date"],
    input[type="number"],
    input[type="tel"],
    textarea,
    input[type="submit"] {
        display: block;
        margin: 10px auto;
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Submit button styling */
    input[type="submit"] {
        background-color: #007BFF;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Table styling */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
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
</style>

<!-- Page header -->
<div style="text-align: center;">
    <h1>Make a Booking</h1>
    <!-- Navigation links -->
    <h2><a href='listrooms.php'>[Return to the Bookings listings]</a><a href="index.php">[Return to main page]</a></h2>
</div>
</h2>

<!-- Booking Form -->
<form id="bookingForm" action="savebooking.php">
    <label for="roomname">Room Name:</label>
    <input type="text" id="roomname" name="roomname" required>

    <label for="roomtype">Room Type:</label>
    <input type="text" id="roomtype" name="roomtype" required>

    <label for="beds">Number of Beds:</label>
    <input type="number" id="beds" name="beds" min="0" max="5" required>

    <label for="checkInDate">Check-in Date:</label>
    <input type="date" id="checkInDate" name="checkInDate" required>

    <label for="checkOutDate">Check-out Date:</label>
    <input type="date" id="checkOutDate" name="checkOutDate" required>

    <label for="contactNumber">Contact Number:</label>
    <input type="tel" id="contactNumber" name="contactNumber" pattern="[0-9]{10}" required>

    <label for="bookingExtras">Booking Extras:</label>
    <textarea id="bookingExtras" name="bookingExtras" rows="4"></textarea>

    <input type="submit" value="Add Booking">
</form>

<body>
    <h1>Search for Availability</h1>

    <!-- Availability Search Form -->
    <div class="container">
        <h1>Search for room availability</h1>
        <form id="availabilityForm">
            <label for="fromDate">Check-in Date:</label>
            <input type="date" id="fromDate" name="fromDate" required>

            <label for="toDate">Check-out Date:</label>
            <input type="date" id="toDate" name="toDate" required>

            <input type="submit" value="Search">
        </form>
        <!-- Availability results will be displayed in the table below -->
        <table id="availabilityTable">
            <tbody>
                <!-- Room availability results will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <!-- JavaScript to handle form submission via AJAX -->
    <script>
        $(document).ready(function () {
            // Submit the form via AJAX
            $("#availabilityForm").submit(function (e) {
                e.preventDefault(); // Prevent form submission
                var fromDate = $("#fromDate").val();
                var toDate = $("#toDate").val();

                $.ajax({
                    type: "POST",
                    url: "roomsearch.php",
                    data: {
                        fromDate: fromDate,
                        toDate: toDate
                    },
                    success: function (response) {
                        $("#availabilityTable tbody").html(response);
                    }
                });
            });
        });
    </script>
</body>

</html>
