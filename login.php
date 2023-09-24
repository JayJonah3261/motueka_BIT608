<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

        form {
            background-color: white;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
<body>
<?php
session_start();
include "config.php"; // Include your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];

    if ($role === 'customer') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $table = 'customer';
        $id_column = 'customerID';
        $password_column = 'password';
    } elseif ($role === 'admin') {
        $username = $_POST['admin_username'];
        $password = $_POST['admin_password'];
        $table = 'administrators';
        $id_column = 'admin_id';
        $password_column = 'password';
    } else {
        // Handle invalid role
        echo "Invalid role.";
        exit();
    }

    $db_connection = mysqli_connect(DBHOST, DBUSER, DBPASSWORD, DBDATABASE);

    if (mysqli_connect_errno()) {
        echo "Error: Unable to connect to MySQL. " . mysqli_connect_error();
        exit();
    }

    $query = "SELECT $id_column, $password_column FROM $table WHERE ";

    if ($role === 'customer') {
        $query .= "email = ?";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
    } elseif ($role === 'admin') {
        $query .= "username = ?";
        $stmt = mysqli_prepare($db_connection, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row[$password_column])) {
            // Password is correct; create a session and redirect to a protected page
            $_SESSION['user_id'] = $row[$id_column];
            $_SESSION['role'] = $role;
            header("Location: index.php"); // Redirect to a protected page
            exit();
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "User not found. Please try again.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($db_connection);
}
?>

<!-- Customer Login -->
<form action="login.php" method="POST">
    <label for="email">Customer Email:</label>
    <input type="email" id="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="hidden" name="role" value="customer">
    <input type="submit" value="Login">
</form>

<!-- Administrator Login -->
<form action="login.php" method="POST">
    <label for="admin_username">Admin Username:</label>
    <input type="text" id="admin_username" name="admin_username" required>
    <br>
    <label for="admin_password">Password:</label>
    <input type="password" id="admin_password" name="admin_password" required>
    <br>
    <input type="hidden" name="role" value="admin">
    <input type="submit" value="Login">
</form>

</body>
</html>