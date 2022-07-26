<?php
// Start the session
session_start();

function Login(){
    require_once "config.php";
    $username = $_SESSION["username"];
    $query = "SELECT * FROM users WHERE users.username = '$username';";

    $result = $conn->query($query);

    if (!$result) {
        echo "Querry SELECT error: " . $conn->error . "<br>";
    } elseif ($result->num_rows > 0) {

        echo "<table>"; // start a table tag in the HTML

        while ($row = $result->fetch_assoc()) {   //Creates a loop to loop through results
            echo "<tr><td>" . $row['id'] . "</td><td>" . $row['username'] . "</td><td>" . $row['password'] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "User doesn't exist";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Examen web</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<nav class="navbar navbar-expand-sm bg-light">

    <div class="container-fluid">
        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/index.php">Home</a>
            </li>
        </ul>

        <?php
        if (!is_null($_SESSION["username"])) : { ?>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                        <?php echo $_SESSION["username"]; ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="#">My exams</a></li>
                        <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php }
        else : ?>
            <li class="nav-item">
                <a class="nav-link" href="/login.php">Login / Sign in</a>
            </li>
        <?php endif ?>
    </div>
</nav>

<body>
    <h1>Such emptyness, such wow</h1>

    <?php
    if ($_POST){
        Login();
    }

    ?>
</body>

</html>