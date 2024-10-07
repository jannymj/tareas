<?php
//Para conectar a la base de datos 
$conn = new mysqli("localhost", "root", "", "tasks_manager"); 
//
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
?>

