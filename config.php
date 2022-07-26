<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', $_ENV["DB_HOST"]);
define('DB_USERNAME', $_ENV["DB_USER"]);
define('DB_PASSWORD', $_ENV["DB_PASSWORD"]);
define('DB_NAME', $_ENV["DB_DATABASE"]);
 
/* Attempt to connect to MySQL database */
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>