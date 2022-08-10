<?php session_start();

function GetCorrectAnwser($question_id)
{

    require "config.php";

    $query = "SELECT anwser_text FROM anwser WHERE question_id = '$question_id' AND is_correct = 1;";
    $anwser_result = $conn->query($query);

    if (!$anwser_result) {
        echo "GetCorrectAnwser error: " . $conn->error;
    }

    return $anwser_result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Examen web</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
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
    <div style="margin: 10px;">
        <?php
        $exam_id = $_GET["exam_id"];

        require_once "config.php";

        $student_query = "SELECT question.question_id, question_text, anwser_text, is_correct FROM student_exam INNER JOIN student_anwser ON student_anwser.student_exam_id = student_exam.student_exam_id INNER JOIN question ON question.question_id = student_anwser.question_id LEFT JOIN anwser ON anwser.anwser_id = student_anwser.anwser_id WHERE student_exam.student_exam_id = '$exam_id';";
        $student_result = $conn->query($student_query);

        if (!$student_result) {
            echo "Query exam anwser error: " . $conn->error;
        }

        while ($row = $student_result->fetch_assoc()) {

            echo "<h3>" . $row["question_text"] . "</h3>";

            if ($row["anwser_text"] == NULL) {
                echo "<p> I don't know </p>";
            } else {
                if ($row["is_correct"] == "1") {
                    echo "<p class='correct'>" . $row["anwser_text"] . "</p>";
                } else {
                    echo "<p class='incorrect'>" . $row["anwser_text"] . "</p>";

                    $valid_anwser = GetCorrectAnwser($row["question_id"]);

                    echo "<p class='valid_anwser'>Correct anwser: " . $valid_anwser["anwser_text"] . "</p>";
                }
            }
        }
        ?>
    </div>
</body>

</html>