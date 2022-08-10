CREATE DATABASE exam_web;

USE exam_web;

CREATE TABLE user(
    user_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username varchar(255) NOT NULL,
    password_hash varchar(255) NOT NULL,
    user_type ENUM("student", "teacher", "admin") NOT NULL
);

CREATE TABLE class(
    class_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    class_name VARCHAR(255) NOT NULL
);

CREATE TABLE class_student(
    class_id INT NOT NULL,
    student_id INT NOT NULL,
    PRIMARY KEY (class_id, student_id)
);

CREATE TABLE class_teacher(
    class_id INT NOT NULL,
    teacher_id INT NOT NULL,
    PRIMARY KEY (class_id, teacher_id)
);

CREATE TABLE exam(
    exam_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    exam_name VARCHAR(255) NOT NULL,
    class_id INT NOT NULL,
    exam_start_date DATETIME NOT NULL,
    duration TIME NOT NULL
);

CREATE TABLE question(
    question_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    question_text VARCHAR(2000) NOT NULL
);


CREATE TABLE anwser(
    anwser_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    question_id INT NOT NULL,
    anwser_text VARCHAR(2000) NOT NULL,
    is_correct BOOLEAN NOT NULL
);

CREATE TABLE student_exam(
    student_exam_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    finish_date DATETIME,
    result FLOAT,
    exam_status ENUM("started", "finished") NOT NULL
);

CREATE TABLE student_anwser(
    student_exam_id INT NOT NULL,
    question_id INT NOT NULL,
    anwser_id INT NOT NULL,
    student_anwser_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT
);

INSERT INTO class ("class_name") VALUES ("Programming");
INSERT INTO class ("class_name") VALUES ("Math");

INSERT INTO exam (exam_name, class_id, exam_start_date, duration) VALUES ("Proga Q1", 1, "2022-08-11 08:30:00", "04:00");
INSERT INTO exam (exam_name, class_id, exam_start_date, duration) VALUES ("Math Q1", 2, "2022-08-10 14:00:00", "04:00");

INSERT INTO question(exam_id, question_text) VALUES (1, "Question 1 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 2 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 3 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 4 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 5 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 6 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 7 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 8 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 9 Program");
INSERT INTO question(exam_id, question_text) VALUES (1, "Question 10 Program");

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (1, "Anwser 1 Question 1", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (1, "Anwser 2 Question 1", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (1, "Anwser 3 Question 1", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (2, "Anwser 1 Question 2", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (2, "Anwser 2 Question 2", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (2, "Anwser 3 Question 2", TRUE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (3, "Anwser 1 Question 3", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (3, "Anwser 2 Question 3", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (3, "Anwser 3 Question 3", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (4, "Anwser 1 Question 4", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (4, "Anwser 2 Question 4", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (4, "Anwser 3 Question 4", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (5, "Anwser 1 Question 5", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (5, "Anwser 2 Question 5", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (5, "Anwser 3 Question 5", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (6, "Anwser 1 Question 6", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (6, "Anwser 2 Question 6", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (6, "Anwser 3 Question 6", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (7, "Anwser 1 Question 7", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (7, "Anwser 2 Question 7", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (7, "Anwser 3 Question 7", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (8, "Anwser 1 Question 8", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (8, "Anwser 2 Question 8", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (8, "Anwser 3 Question 8", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (9, "Anwser 1 Question 9", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (9, "Anwser 2 Question 9", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (9, "Anwser 3 Question 9", FALSE);

INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (10, "Anwser 1 Question 10", FALSE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (10, "Anwser 2 Question 10", TRUE);
INSERT INTO anwser(question_id, anwser_text, is_correct) VALUES (10, "Anwser 3 Question 10", FALSE);
