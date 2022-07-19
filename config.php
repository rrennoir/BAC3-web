<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', '127.0.0.0');
define('DB_USERNAME', 'web');
define('DB_PASSWORD', 'very_secure');
define('DB_NAME', 'web');
 
/* Attempt to connect to MySQL database */
$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>