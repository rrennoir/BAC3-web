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
    <?php
    $exam_id = $_GET["exam_id"];

    require_once "config.php";

    $username = $_SESSION["username"];
    $query = "SELECT * FROM user  WHERE username = '$username';";
    $result = $conn->query($query);

    if (!$result){
        echo $conn->error;
    }

    $user_id = ($result->fetch_assoc())["user_id"];

    $query = "INSERT INTO student_exam(student_id, exam_id, exam_status) VALUES ($user_id, $exam_id, 'started');";
    $result = $conn->query($query);

    $student_exam_id = $conn->insert_id;

    if (!$result){
        echo $conn->error;
    }

    $query = "SELECT exam_name, class_name FROM exam INNER JOIN class ON class.class_id = exam.class_id WHERE exam_id = '$exam_id';";
    $result = $conn->query($query);


    $_SESSION["current_student_exam_id"] = $student_exam_id;

    if (!$result) {
        echo "Querry SELECT error: " . $conn->error . "<br>";
    } elseif ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        echo "<h1>Class: " . $row["class_name"] . "</h1>";
        echo "<h2>Exam: " . $row["exam_name"] . "</h2>";

        $query = "SELECT question.question_id, question_text, anwser_id, anwser_text FROM exam INNER JOIN question ON exam.exam_id = question.exam_id INNER JOIN anwser ON question
        .question_id = anwser.question_id WHERE exam.exam_id = '$exam_id';";
        $result = $conn->query($query);

        echo "<form method=POST action=saveexam.php>";

        $prev_question_id = 0;
        while ($question = $result->fetch_assoc()) {

            if ($prev_question_id != $question["question_id"]) {
                if ($prev_question_id != 0) {
                    echo "<label for='" . $prev_question_id . "'>I don't know</label>";
                    echo "<input type='checkbox' id='" . $prev_question_id . "_idk' name='" . $prev_question_id . "' value='idk'>";
                }

                echo "<h3>" . $question["question_text"] . "</h3>";
            }

            echo "<label for='" . $question["anwser_id"] . "'>" . $question["anwser_text"] . "</label>";
            echo "<input type='checkbox' value='" . $question["anwser_id"] . "' id='" . $question["anwser_id"] . "' name='" . $question["question_id"] . "'><br>";

            $prev_question_id = $question["question_id"];
        }

        echo "<label for='" . $prev_question_id . "'>I don't know</label>";
        echo "<input type='checkbox' id='" . $prev_question_id . "_idk' name='" . $prev_question_id . "' value='idk'>";

        echo "<input type='submit' value='Finish'>";

        echo "</form>";
    } else {
        echo "No exam with id " . $exam_id . " found";
    }
    ?>

</body>

</html>