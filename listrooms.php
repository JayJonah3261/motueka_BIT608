<!DOCTYPE HTML>
<html>

<head>
    <title>Browse rooms</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            background-color: #007BFF;
            color: white;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            margin: 0 10px;
        }

        a:hover {
            text-decoration: underline;
        }

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

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
<body>

    <?php
    include "config.php"; //load in any variables
    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    //insert DB code from here onwards
//check if the connection was good
    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit; //stop processing the page further
    }

    //prepare a query and send it to the server
    $query = 'SELECT roomID,roomname,roomtype FROM room ORDER BY roomtype';
    $result = mysqli_query($db_connection, $query);
    $rowcount = mysqli_num_rows($result);
    ?>
    <h1>Room list</h1>
    <h2><a href='addroom.php'>[Add a room]</a><a href="index.php">[Return to main page]</a></h2>
    <table border="1">
        <thead>
            <tr>
                <th>Room Name</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php

        //makes sure we have rooms
        if ($rowcount > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['roomID'];
                echo '<tr><td>' . $row['roomname'] . '</td><td>' . $row['roomtype'] . '</td>';
                echo '<td><a href="viewroom.php?id=' . $id . '">[view]</a>';
                echo '<a href="editroom.php?id=' . $id . '">[edit]</a>';
                echo '<a href="deleteroom.php?id=' . $id . '">[delete]</a></td>';
                echo '</tr>';
            }
        } else
            echo "<h2>No rooms found!</h2>"; //suitable feedback
        
        mysqli_free_result($result); //free any memory used by the query
        mysqli_close($db_connection); //close the connection once done
        ?>
    </table>
</body>

</html>