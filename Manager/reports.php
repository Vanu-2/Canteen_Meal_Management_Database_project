<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    $sql = "SELECT * FROM manager WHERE Manager_name ='$username' AND Password='$password' ";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userType'] = $userType;
        header('Location: Manager/dashboard.php');
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 style = "text-align : center; color : Red"> Page under construction </h1>
</body>
</html>