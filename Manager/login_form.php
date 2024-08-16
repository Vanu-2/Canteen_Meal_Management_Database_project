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
        header('Location: dashboard.php');
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DMeal - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-3xl font-bold mb-8 text-center">DMeal Login</h1>
        <form action="" method="post">
            <div class="mb-4">
                <label for="userType" class="block text-lg font-semibold mb-2">User Type:</label>
                <select id="userType" name="userType" class="border border-gray-300 p-2 w-full rounded">
                    <option value="manager">Manager</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="username" class="block text-lg font-semibold mb-2">Username:</label>
                <input type="text" id="username" name="username" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-lg font-semibold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <button type="submit" name="login" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Login</button>
        </form>
    </div>

</body>

</html>
