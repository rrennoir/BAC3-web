<?php

function GetUserId($username)
{
    require "config.php";

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

function GetUserData($username){

    require "config.php";

    $query = "SELECT * FROM user WHERE user.username = '$username';";
    $result = $conn->query($query);

    if (!$result){
        echo "GetUserData error: " . $conn->error . "<br>";
    }

    if ($result->num_rows == 0){
        return null;
    }
    
    return $result->fetch_assoc();
}

function GetQuestionAnwsers($question_id)
{
    require "config.php";

    $anwser_query = "SELECT anwser_id, anwser_text FROM anwser WHERE question_id = '$question_id';";
    $anwser_result = $conn->query($anwser_query);

    if (!$anwser_result) {
        echo "Anwser query error: " . $conn->error;
    }

    $anwsers = [];
    while ($anwser = $anwser_result->fetch_assoc()) {
        array_push($anwsers, $anwser);
    }

    return $anwsers;
}

function GetExamQuestions($exam_id)
{
    require "config.php";

    $query = "SELECT question.question_id, question_text FROM exam INNER JOIN question ON exam.exam_id = question.exam_id WHERE exam.exam_id = '$exam_id';";
    $result = $conn->query($query);
    
    if (!$result){
        echo "GetExamQuestion error: " . $conn->error;
    }

    $questions = [];
    while ($question = $result->fetch_assoc()) {
        array_push($questions, $question);
    }

    return $questions;
}

function CreateStudentExam($user_id, $exam_id){

    require "config.php";

    $query = "INSERT INTO student_exam(student_id, exam_id, exam_status) VALUES ($user_id, $exam_id, 'started');";
    $result = $conn->query($query);

    if (!$result) {
        echo $conn->error;
    }

    return $conn->insert_id;
}

function GetExamInfoFromId($exam_id){

    require "config.php";

    $query = "SELECT exam_name, class_name FROM exam INNER JOIN class ON class.class_id = exam.class_id WHERE exam_id = '$exam_id';";
    $result = $conn->query($query);

    if (!$result) {
        echo "GetExamInfo: " . $conn->error . "<br>";
        return null;
    }

    if ($result->num_rows == 0){
        echo "No exam found<br>";
        return null;
    }

    return $result->fetch_assoc();
}
?>