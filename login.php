<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Examen web</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <form method="POST" autocomplete="on">
        <label>Username</label><br>
        <input type="text" name="username"><br>
        <label>Password</label><br>
        <input type="text" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
    <?php

    require_once "config.php";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE users.username = '$username' AND users.password = '$password';";
    $result = $conn->query($query);

    if (!$result) {
        echo "Querry SELECT error: " . $conn->error . "<br>";
    } else {
        if ($result->num_rows > 0) {
            echo "Welcome $username" . "<br>";
            $_SESSION["username"] = $username;
        } else {
            if (!$conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password');")) {
                echo "Querry INSERT error: " . $conn->error . "<br>";
            } else {
                echo "User added $username with password $password added to DB" . "<br>";
            }
        }
    }

    ?>
</body>

</html>