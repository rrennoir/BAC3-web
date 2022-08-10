<?php
// Start the session
session_start();

function GetUserId()
{
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

function GetClass($id)
{

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

function GetExamInfo($class_info)
{

    require "config.php";

    $class_id = $class_info["class_id"];
    $result = $conn->query("SELECT * FROM exam WHERE class_id = '$class_id'");

    if ($result && $result->num_rows > 0) {

        $exams = array();
        while ($row = $result->fetch_assoc()) {
            array_push($exams, $row);
        }
        return $exams;
    }

    return null;
}

function ShowMyExams()
{
    $user_id = GetUserId();
    $classes = GetClass($user_id);

    echo "<h2>Exams</h2>";
    echo "
        <table class='GeneratedTable'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Start</th>
                </tr>
            </thead>
        ";
    foreach ($classes as $class) {
        $exams = GetExamInfo($class);

        if (!$exams)
            continue;

        foreach ($exams as $exam) {
            echo "<tbody><tr>";
            echo "<td>" . $exam["exam_id"] . "</td>";
            echo "<td>" . $exam["exam_name"] . "</td>";
            echo "<td><a class='btn btn-primary' href='studentexam.php?exam_id=" . $exam["exam_id"] . "'>StartExam</a></td>";
            echo "</tr></tbody>";
        }
    }

    echo "</table>";
}

function ShowMyClass()
{
    $user_id = GetUserId();
    $classes = GetClass($user_id);

    echo "<h2> Classes</h2>";
    echo "
        <table class='GeneratedTable'>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                </tr>
            </thead>
        ";
    foreach ($classes as $class) {
        echo "<tbody><tr>";
        echo "<td>" . $class["class_id"] . "</td>";
        echo "<td>" . $class["class_name"] . "</td>";
        echo "</tr></tbody>";
    }

    echo "</table>";
}

function ShowStudentExam()
{
    require "config.php";

    $user_id = GetUserId();

    $query = "SELECT username, student_exam_id, exam_status, result, exam_name, teacher_id FROM student_exam INNER JOIN user ON user.user_id = student_id INNER JOIN exam ON exam.exam_id = student_exam.exam_id INNER JOIN class ON class.class_id = exam.class_id INNER JOIN class_teacher ON class_teacher.class_id = class.class_id WHERE teacher_id = '$user_id';";

    $result = $conn->query($query);

    if (!$result) {
        echo "Student exams querry failed: " . $conn->error . "<br>";
    }

    echo "
        <table class='GeneratedTable'>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Exam</th>
                    <th>Status</th>
                    <th>Result</th>
                    <th>Check Exam</th>
                </tr>
            </thead>
        ";

    while ($row = $result->fetch_assoc()) {

        echo "<tbody><tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["exam_name"] . "</td>";
        echo "<td>" . $row["exam_status"] . "</td>";
        echo "<td>" . $row["result"] . " / 5</td>";
        echo "<td><a class='btn btn-primary' href='checkexam.php?exam_id=" . $row["student_exam_id"] . "'>Check</a></td>";
        echo "</tr></tbody>";
    }
    echo "</table>";
}

function ShowMyPassedExams(){

    require "config.php";

    $user_id = GetUserId();

    $query = " SELECT * FROM student_exam INNER JOIN exam ON exam.exam_id = student_exam.exam_id WHERE student_id = '$user_id' AND exam_status = 'finished';";
    $result = $conn->query($query);

    if (!$result){
        echo "Show passed exam query error: " . $conn->error;
    }

    echo "<h2>Passed Exams</h2>";

    echo "
    <table class='GeneratedTable'>
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Result</th>
                <th>Check Exam</th>
            </tr>
        </thead>
    ";

    while ($row = $result->fetch_assoc()) {

        echo "<tbody><tr>";
        echo "<td>" . $row["exam_name"] . "</td>";
        echo "<td>" . $row["exam_status"] . "</td>";
        echo "<td>" . $row["result"] . " / 5</td>";
        echo "<td><a class='btn btn-primary' href='checkexam.php?exam_id=" . $row["student_exam_id"] . "'>Check</a></td>";
        echo "</tr></tbody>";
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
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/main.css">
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
    <div class="center">

        <?php
        require_once "config.php";
        $username = $_SESSION["username"];
        $query = "SELECT * FROM user WHERE user.username = '$username';";

        $result = $conn->query($query);

        if (!$result) {
            echo "Querry SELECT error: " . $conn->error . "<br>";
        } elseif ($result->num_rows == 0) {
            echo "Please sign in";
        } else {

            $user_data = $result->fetch_assoc();

            if ($user_data["user_type"] == "student") {
                ShowMyClass();
                ShowMyExams();
                ShowMyPassedExams();
            } elseif ($user_data["user_type"] == "teacher") {
                ShowStudentExam();
            } elseif ($user_data["user_type"] == "admin") {
                echo "welcome admin";
            }
        }

        ?>
    </div>
</body>

</html>