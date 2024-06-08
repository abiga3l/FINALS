<?php
session_start();
include 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $userId=$_SESSION['user_id'];
    $mood=$_POST['mood'];
    $notes=$_POST['notes'];
    $date=$_POST['date'];

    $query ="INSERT INTO mood_tracker(user_id,mood,notes,date)VALUES(?,?,?,?)";
    $stmt =$conn->prepare($query);
    $stmt->bind_param("isss",$userId,$mood,$notes,$date);

if($stmt->execute()){
    echo "Mood logged successfully";
}else{
    echo"Error: ".
    $stmt->error;
}
}
?>