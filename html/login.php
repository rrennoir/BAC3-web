<?php session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    require "common.php";

    if (!empty($_POST["username"]) && !empty($_POST["password"])){
        $username = trim(htmlspecialchars($_POST["username"]));
        $password = trim(htmlspecialchars($_POST["password"]));

        $user_data = GetUserData($username);

        if ($user_data && password_verify($password, $user_data["password_hash"])){
            $_SESSION["username"] = $username;
            return true;
        }
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
    <a href="/signup.php">No account yet ?</a><br>

    <?php echo $error . "<br>"; ?>
</body>

</html>