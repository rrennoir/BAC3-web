<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">

<body>

    <?php


    require_once "config.php";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = $conn->query("SELECT * FROM users WHERE $username = username AND $password = password;");

    if ($result->num_row > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"] . " - Username: " . $row["username"] . " - Password: " . $row["password"] . " " . "<br>";
        }
    } else {
        if (!$conn->query("INSERT INTO users ('username', 'password') VALUES ('$username', '$password');")) {
            echo "Querry error: " . $conn->error;
        }
        echo "User $username with password $password added to DB";
    }

    ?>

</body>

</html>