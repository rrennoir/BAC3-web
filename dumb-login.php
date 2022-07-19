
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">

<body>

<?php


require_once "config.php";

$username = $_POST["name"];
$password = $_POST["password"];

$result = $conn->query("SELECT * in users WHERE $username LIKE username & $password LIKE password");

if ($result->num_row > 0){
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Username: " . $row["username"]. " - Password: " . $row["password"]. " " . "<br>";
        }

}
else{
    $conn->query("INSERT INTO user (username, passord) VALUES ($username, $password)");
    echo "User added to DB";
}

?>

</body>
</html>