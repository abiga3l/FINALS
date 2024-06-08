<?php
$servername = "localhost";
$username ="root";
$password ='Abigael@2006';
$dbname ="harmony_hub";

$conn = new mysqli($servername,$username,$password,$dbname);

if($conn ->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>