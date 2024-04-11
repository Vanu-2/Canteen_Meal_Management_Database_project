<?php
include 'db.php';

if(isset($_POST['login'])){
    $id = $_POST['id'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type']; // Fetch the selected user type from the form
    $name;
    // Construct the SQL query with email and user type
    if($user_type === 'student') {
        $sql = "SELECT * FROM student WHERE Student_id ='$id'";
    }
    if($user_type === 'manager') {
        $sql = "SELECT * FROM manager WHERE Manager_id ='$id'";
    }
    if($user_type === 'provost') {
        $sql = "SELECT * FROM provost WHERE Admin_id ='$id'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['Password']) {
            echo "Login successful";
            if($user_type === 'student') echo "<h1 align = center> Welcome  $user_type:  $row[Student_name] <br> </h1>";
            if($user_type === 'manager') echo "<h1 align = center> Welcome  $user_type:  $row[Manager_name] <br> </h1>";
            if($user_type === 'provost') echo "<h1 align = center> Welcome  $user_type:  $row[Provost_name] <br> </h1>";
            //echo "<h1 align = center> Your email is   $row[email] <br> </h1>";
            // echo "<h1 align = center> Your user type is    <br> </h1>";
        }
        else {

            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}
?>
