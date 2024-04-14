<?php
include 'db.php';

if(isset($_POST['register'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    try
    {
        $sql = "INSERT INTO student (Student_Id, Student_name, Email, Password, Mobile_No) VALUES ('$id', '$name', '$email', '$password', '$mobile')";
    }
    catch(Exception $e) {
        echo "<h1 align = center> Something Went Wrong <br> </h1>";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful <br>"; 
        echo "<h1 align = center > Hello  $name <br> </h1>";
    } else {
        echo "<h1 align = center > Something Went Wrong <br> </h1>";
    }
}
?>
