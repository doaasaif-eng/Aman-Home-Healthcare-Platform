<?php
$servername = "localhost";
$username = "root";  
$password = ""; 
$dbname = "aman"; 

$database = new mysqli($servername, $username, $password, $dbname);
$database->set_charset("utf8mb4");

if ($database->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $database->connect_error);
}
?>
