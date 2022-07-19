<?php


require_once "config.php";

$username = $_POST["name"];
$password = $_POST["password"];

$result = $conn->query("SELECT * in users");

if ($result->num_row > 0){
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Username: " . $row["username"]. " - Password: " . $row["password"]. " " . "<br>";
        }
}
else{
    $conn->query("INSERT INTO user (username, passord) VALUES ($username, $password)");
}

?>