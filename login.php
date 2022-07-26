<?php session_start();

if ($_POST) {
    if (Login()) {
        header('Location: index.php');
        exit();
    }
    else{
        $error = "Invalid username / password";
    }
}

function Login()
{
    require_once "config.php";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM user WHERE users.username = '$username';";
    $result = $conn->query($query);

    if (!$result) {
        echo "Querry SELECT error: " . $conn->error . "<br>";
    } elseif ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row["psw"])){
            $_SESSION["username"] = $username;
            return true;
        }
        echo "Invalid password";

    } else {
        echo "No user found";
    }
    return false;
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
    <form method="POST" autocomplete="on">
        <label>Username</label><br>
        <input type="text" name="username"><br>
        <label>Password</label><br>
        <input type="text" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
    <a href="/signup.php">No account yet ?</a>

    <?php echo $error;?>
</body>

</html>