<?php
// Start the session
session_start();

function GetUserId(){
    require "config.php";
    
    $username = $_SESSION["username"];
    $result = $conn->query("SELECT id FROM user WHERE user.username = '$username'");

    if (!$result) {
        echo "Error in the DB query: " . $conn->error;
    }

    if ($result->num_rows == 0) {
        echo "User not in database";
    }
    $row = $result->fetch_assoc();
    return $row["id"];
}

function GetClass($id){

    require "config.php";

    $result = $conn->query("SELECT class_name FROM class INNER JOIN class_student ON class.id = class_student.class_id AND student_id = '$id';");

    $classes = array();

    if ($result && $result->num_rows) {
        while ($row = $result->fetch_assoc()) { 
            array_push($classes, $row["class_name"]);
        }
    }

    return $classes;
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
                        <li><a class="dropdown-item" href="./StudentExam.php">My exams</a></li>
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
    <?php
    

    $user_id = GetUserId();

    echo "UserId is: " . $user_id . "<br>";

    if ($user_id == 0){
        echo "can't find user";
    }
    else{
        $classes = GetClass($user_id);

        echo "Found: " . count($classes) . "<br>";

        echo "<h1> Classes: </h1>";

        echo implode(", ", $classes);

        foreach ($classes as $class){
            echo "<h2>$classes[$class]</h2>";
        }
    }

    ?>
</body>

</html>