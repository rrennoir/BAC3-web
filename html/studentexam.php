<?php session_start();?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Examen web</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
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
        $exam_id = $_GET["exam_id"];

        require "config.php";
        require "common.php";

        $user_id = GetUserId($_SESSION["username"]);

        $_SESSION["current_student_exam_id"] = CreateStudentExam($user_id, $exam_id);

        $exam_info = GetExamInfoFromId($exam_id);
        if (!$exam_info) {
            die();
        }

        echo "<h1>Class: " . $exam_info["class_name"] . "</h1>";
        echo "<h2>Exam: " . $exam_info["exam_name"] . "</h2>";

        $questions = GetExamQuestions($exam_id);
        shuffle($questions);

        echo "<form method=POST action=saveexam.php onsubmit='return ConfirmExamFinish();'>";

        $prev_question_id = 0;
        for ($i = 0; $i < count($questions) / 2; $i++) {

            $question_data = $questions[$i];
            $question_id = $question_data["question_id"];

            $anwsers = GetQuestionAnwsers($question_id);

            shuffle($anwsers);

            if ($prev_question_id != $question_id) {
                if ($prev_question_id != 0) {
                    echo "<input required class='spaced_radio' type='radio' id='" . $prev_question_id . "_idk' name='" . $prev_question_id . "' value='idk'>";
                    echo "<label for='" . $prev_question_id . "'>I don't know</label><br><br>";
                }

                echo "<h3>" . $question_data["question_text"] . "</h3>";
            }

            foreach ($anwsers as $anwser) {
                echo "<input required class='spaced_radio' type='radio' value='" . $anwser["anwser_id"] . "' id='" . $anwser["anwser_id"] . "' name='" . $question_id . "'>";
                echo "<label for='" . $anwser["anwser_id"] . "'>" . $anwser["anwser_text"] . "</label><br>";
            }

            $prev_question_id = $question_id;
        }

        echo "<input required class='spaced_radio' type='radio' id='" . $prev_question_id . "_idk' name='" . $prev_question_id . "' value='idk'>";
        echo "<label for='" . $prev_question_id . "'>I don't know</label><br><br>";

        echo "<input type='submit' value='Finish'>";

        echo "</form>";

        ?>
    </div>
</body>

</html>