<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $userId =   $_POST['userid'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    $sql = "";
    
    if ($userType == 'manager') {
        $sql = "SELECT * FROM manager WHERE Manager_id = $userId AND Password='$password' AND manager.Type = 'active'";
    } elseif ($userType == 'admin') {
        $sql = "SELECT * FROM administrator WHERE Admin_id ='$userId' AND Password='$password' AND isActive = 1";
    } elseif ($userType == 'student') {
        $sql = "SELECT * FROM student WHERE Student_id ='$userId' AND Password='$password'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userid'] = $userId;
        $_SESSION['userType'] = $userType;
        if ($userType == 'manager') {
            header('Location: Manager/dashboard.php');
        } else if ($userType == 'admin') {
            header('Location: Admin/admin_dashboard.php');
        } else if ($userType == 'student') {
            header('Location: Student/index.php');
        }
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
        <div class="mb-6 text-center">
            <img src="D Meal (Logo) (2).png" alt="DMeal Logo" class="w-32 mx-auto mb-4">
            <!-- <h1 class="text-3xl font-bold mb-2">DMeal Login</h1> -->
            <p class="text-sm text-gray-500">Login to access your account</p>
        </div>
        <form action="" method="post">
            <div class="mb-4">
                <label for="userType" class="block text-lg font-semibold mb-2">User Type:</label>
                <select id="userType" name="userType" class="border border-gray-300 p-2 w-full rounded">
                    <option value="manager">Manager</option>
                    <option value="admin">Admin</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="userid" class="block text-lg font-semibold mb-2">UserID:</label>
                <input type="text" id="userid" name="userid" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-lg font-semibold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <button type="submit" name="login" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Login</button>
        </form>
        <p class="mt-4 text-center">Not a user? <a href="register_form.php" class="text-blue-500">Register</a></p>
    </div>

</body>

</html>