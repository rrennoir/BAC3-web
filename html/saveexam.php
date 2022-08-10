<?php

session_start();

require_once("config.php");

$student_exam_id = $_SESSION["current_student_exam_id"];

$note = 0;
foreach ($_POST as $key => $value) {

    $question_id = htmlspecialchars($key);
    $anwser_id = htmlspecialchars($value);
    
    if ($value == "idk"){
        $query = "INSERT INTO student_anwser(student_exam_id, question_id, anwser_id) VALUES ('$student_exam_id', '$question_id', NULL);";
    }
    else{
        $query = "INSERT INTO student_anwser(student_exam_id, question_id, anwser_id) VALUES ('$student_exam_id', '$question_id', '$anwser_id');";
    }

    $result = $conn->query($query);

    if (!$result) {
        echo "Insert anwser error: " . $conn->error;
    }

    if ($anwser_id != "idk"){

        $query_check_anwser = "SELECT * FROM anwser WHERE anwser_id = '$anwser_id';";
        $result_check_anwser = $conn->query($query_check_anwser);
        
        if (!$result_check_anwser) {
            echo "Check anwser error: " . $conn->error;
        }
        
        $valid_anwser_id = ($result_check_anwser->fetch_assoc())["is_correct"];
        
        if ($valid_anwser_id == 1){
            $note += 1;
        }
        else{
            $note -= 0.5;
        }
    }
}

if ($note < 0){
    $note = 0;
}

$query_update_exam = "UPDATE student_exam SET result = '$note', exam_status = 'finished' WHERE student_exam_id = '$student_exam_id';";
$result_update_exam = $conn->query($query_update_exam);

if (!$result){
    echo "Error while updating exam" . $conn->error;
}

$_SESSION["current_student_exam_id"] = null;

header('Location: index.php');
exit();

?>