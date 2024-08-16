<?php
session_start();
include 'db.php';

// Check if user is logged in, if not redirect to login page
if (!isset($_SESSION['loggedIn']) || $_SESSION['userType'] !== 'admin') {
    header('Location: ../login_form.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = ($_POST['password']);
    $ac = 1;
    $currentAdminId = $_SESSION['userid'];
    $updateSql = "UPDATE administrator SET isActive = '0' WHERE Admin_id = '$currentAdminId'";
    $conn->query($updateSql);

    $sql = "INSERT INTO administrator (Admin_id, Admin_name, Email, `Password`, isActive) VALUES ('$id', '$name', '$email', '$password', '$ac')";

    if ($conn->query($sql) === TRUE) {
        $message = 'New admin added successfully. Logging out...';
        session_destroy();
        header('Location: ../login_form.php');
        exit;
    } else {
        $message = 'Error: ' . $sql . '<br>' . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin - DMeal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-green-100 font-sans">

<div class="flex">

    <!-- Sidebar -->
    <div style="background-color: #4c9173;" class="text-white h-screen w-64 fixed left-0 top-0 overflow-y-auto">
        <div class="px-11 py-1 w-45 h-45">
            <img src="D Meal (Logo) (2).png" alt="Image" class="w-full h-full object-contain" />
        </div>
        <ul id="sidebarMenu" class="mt-8">
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="admin_dashboard.php" class="block">Dashboard</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="approve_student_requests.php" class="block">Approve Student Requests</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="approve_manager_requests.php" class="block">Approve Manager Requests</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="modify_student_info.php" class="block">Modify Student Information</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="modify_manager_info.php" class="block">Modify Manager Information</a>
            </li>
            <li class="px-5 py-3 hover:bg-green-300">
                <a href="reports.php" class="block">Add New Admin</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Add New Admin</h1>

        <?php if ($message): ?>
            <p class="text-red-500"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Add Admin Form -->
        <form action="" method="post">
            <div class="mb-4">
                <label for="id" class="block text-lg font-semibold mb-2">ID:</label>
                <input type="text" id="id" name="id" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-lg font-semibold mb-2">Name:</label>
                <input type="text" id="name" name="name" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-lg font-semibold mb-2">Email:</label>
                <input type="email" id="email" name="email" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-lg font-semibold mb-2">Password:</label>
                <input type="password" id="password" name="password" class="border border-gray-300 p-2 w-full rounded" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Admin</button>
        </form>
    </div>

</div>

</body>
</html>
