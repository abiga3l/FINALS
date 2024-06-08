<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name =$_POST['name'] ??'';
    $email =$_POST['email'] ??'';
    $type=$_POST['type'];
    $detailed =$_POST['detailed'];

    $servername ="localhost";
    $username ="root";
    $password ="Abigael@2006";
    $dbname ="harmony_hub";

    $conn = new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}   

$stmt=$conn->prepare("INSERT INTO feedback(name,email,type,message)VALUES(?,?,?,?)");
$stmt->bind_param("ssss",$name,$email,$type,$message);
if($stmt->execute()){
    header("Location:feedback.html?status=success");
    exit();
}else{
    echo "Error: ".$stmt->error;
}
$stmt->close();
$conn->close();
}
?>