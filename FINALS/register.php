<?php
session_start();
require_once 'config.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $fullname =$_POST['fullname'];
    $email =$_POST['email'];
    $password =password_hash($_POST['password'],PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(fullname,email,password)VALUES(?,?,?)";
    if($stmt =$conn->prepare($sql)){
    $stmt->bind_param("sss",$fullname,$email,$password);
    if($stmt->execute()){
        $_SESSION['loggedin']=true;
        $_SESSION['id']=$id;
        $_SESSION['name']=$fullname;
            header('Location:dashboard.php');
            exit();
        }else{
            echo "Error: Could not execute.";
        }
    $stmt->close();
}else{
    echo "Error: Could not prepare SQL statement.";
}
$conn->close();
}
?>