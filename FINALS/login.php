<?php
session_start();
require_once 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email =$_POST['email'];
    $password =$_POST['password'];

    $sql = "SELECT id,email,password FROM users WHERE email = ?";

    if($stmt =$conn->prepare($sql)){
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->bind_result($id,$email,$hashed_password);
        $stmt->fetch();
        
    if(password_verify($password,$hashed_password)){
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['name']=$name;

            header("Location:dashboard.html");
            exit();
        }else{
            echo "Incorrect password.";
        }
    }else{
        echo "No user found with this email.";
    }
    $stmt->close();
}else{
    echo "Error: Could not prepare SQL statement.";
}
$conn->close();
}
?>