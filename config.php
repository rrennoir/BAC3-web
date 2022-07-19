<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', '127.0.0.0');
define('DB_USERNAME', 'web');
define('DB_PASSWORD', 'very_secure');
define('DB_NAME', 'web');
 
try {
    $link = new PDO("mysql:host=localhost;dbname=web", DB_USERNAME, DB_PASSWORD);
    // set the PDO error mode to exception
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
?>