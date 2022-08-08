<?php
// Start the session
session_start();

function GetUserId(){
    require "config.php";
    
    $username = $_SESSION["username"];
    $result = $conn->query("SELECT * FROM user WHERE user.username = '$username'");

    if (!$result) {
        echo "Error in the DB query: " . $conn->error;
    }

    if ($result->num_rows == 0) {
        echo "User not in database";
    }
    $row = $result->fetch_assoc();
    return $row["user_id"];
}

function GetClass($id){

    require "config.php";

    $result = $conn->query("SELECT class.* FROM class INNER JOIN class_student ON class.class_id = class_student.class_id AND student_id = '$id';");

    $classes = array();

    if ($result && $result->num_rows) {
        while ($row = $result->fetch_assoc()) { 
            array_push($classes, $row);
        }
    }

    return $classes;
}

function GetExamInfo($class_info){

    require "config.php";

    $class_id = $class_info["class_id"];
    $result = $conn->query("SELECT * FROM exam WHERE class_id = '$class_id'");

    if ($result && $result->num_rows > 0){

        $exams = array();
        while ($row = $result->fetch_assoc()){
            array_push($exams, $row);
        }
        return $exams;
    }
    
    return null;
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
    <div class="container-fluid">

    <?php
    require_once "config.php";
    $username = $_SESSION["username"];
    $query = "SELECT * FROM user WHERE user.username = '$username';";

    $result = $conn->query($query);

    if (!$result) {
        echo "Querry SELECT error: " . $conn->error . "<br>";
    } elseif ($result->num_rows > 0) {

        echo "<table>"; // start a table tag in the HTML

        while ($row = $result->fetch_assoc()) {   //Creates a loop to loop through results
            echo "<tr><td>" . $row['user_id'] . "</td><td>" . $row['username'] . "</td><td>" . $row['password_hash'] . "</td><td>";
        }

        echo "</table>";


        $user_id = GetUserId();
        $classes = GetClass($user_id);

        echo count($classes);

        echo "<h2> Classes: </h2>";
        foreach ($classes as $class){
            echo "<h3>- " . $class["class_name"] . "</h3>";
        }

        echo "<h2>Exams: </h2>";
        foreach ($classes as $class){
            $exams = GetExamInfo($class);

            if ($exams){
                foreach ($exams as $exam){
                    echo "<h3>" . $exam["exam_name"] . " " . $exam["exam_start_date"] . " " . $exam["duration"] . "<button>Something</button> </h3>";
                }
                
            }
        }

    } else {
        echo "User doesn't exist";
    }

    ?>
    </div>
</body>

</html>