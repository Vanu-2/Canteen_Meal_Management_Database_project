<?php
include 'db.php';

if(isset($_POST['register'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    if($userType == 'student')
    {
        try
        {
            $tp = 'requested';
            $sql = "INSERT INTO student (Student_id, Student_name, Email, Password, Mobile_No, Type) VALUES ('$id', '$name', '$email', '$password', '$mobile', '$tp')";
        }
        catch(Exception $e) {
            echo "<h1 align = center> Something Went Wrong <br> </h1>";
        }
    
        if ($conn->query($sql) === TRUE) {
            header('Location: login_form.php');
        } else {
            echo "<h1 align = center > Something Went Wrong <br> </h1>";
        }
    }
    else if($userType == 'manager')
    {
        try
        {
            $t = 'requested';
            $sql = "INSERT INTO manager (Manager_id, Manager_name, Email, Password, Mobile_No, Type) VALUES ('$id', '$name', '$email', '$password', '$mobile', '$t')";
        }
        catch(Exception $e) {
            echo "<h1 align = center> Something Went Wrong <br> </h1>";
        }
    
        if ($conn->query($sql) === TRUE) {
            header('Location: login_form.php');
        } else {
            echo "<h1 align = center > Something Went Wrong <br> </h1>";
        }
    }

}
?>
