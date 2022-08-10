<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Examen web</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/exam_check.css" rel="stylesheet">
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

    $query = "SELECT question_text, student_anwser.anwser_id, anwser_text, is_correct FROM student_exam INNER JOIN student_anwser ON student_anwser.student_exam_id = student_exam.student_exam_id INNER JOIN question ON question.question_id = student_anwser.question_id LEFT JOIN anwser ON anwser.anwser_id = student_anwser.anwser_id WHERE student_exam.student_exam_id = '$exam_id';";
    $result = $conn->query($query);

    if (!$result){
        echo "Query exam anwser error: " . $conn->error;
    }

    while ($row = $result->fetch_assoc()){


        echo "<h2>" . $row["question_text"] . "</h2>";

        if ($row["anwser_text"] == NULL){
            echo "<h3>I don't know</h3>";
        }
        else{
            if ($row["is_correct"] == "1"){
                $style = "correct";
            }
            else{
                $style = "incorrect";
            }

            echo "<h2 class='" . $style . "'>" . $row["anwser_text"] . "</h2>";
        }

    }

    ?>
    </div>
</body>

</html>